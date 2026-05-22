<?php

namespace App\Services;

use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\RawMaterialConditionAdjustment;
use App\Models\RawMaterialReceipt;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryStockService
{
    public function recordRawMaterialReceipt(array $data): RawMaterialReceipt
    {
        return DB::transaction(function () use ($data): RawMaterialReceipt {
            $rawMaterial = RawMaterial::query()->lockForUpdate()->findOrFail($data['raw_material_id']);

            $goodQuantity = (float) $data['good_quantity'];
            $damagedQuantity = (float) $data['damaged_quantity'];
            $quantity = $goodQuantity + $damagedQuantity;

            if ($quantity <= 0) {
                throw ValidationException::withMessages([
                    'good_quantity' => 'Jumlah penerimaan harus lebih dari 0.',
                ]);
            }

            $receipt = RawMaterialReceipt::create([
                'supplier_id' => $data['supplier_id'],
                'raw_material_id' => $rawMaterial->id,
                'received_at' => $data['received_at'],
                'quantity' => $quantity,
                'good_quantity' => $goodQuantity,
                'damaged_quantity' => $damagedQuantity,
                'remaining_good_quantity' => $goodQuantity,
                'remaining_damaged_quantity' => $damagedQuantity,
            ]);

            $rawMaterial->increment('stok', $quantity);
            $rawMaterial->increment('stok_baik', $goodQuantity);
            $rawMaterial->increment('stok_rusak', $damagedQuantity);

            return $receipt->load('supplier', 'rawMaterial');
        });
    }

    public function consumeRawMaterialsForProduction(array $requirements): void
    {
        DB::transaction(function () use ($requirements): void {
            $requirements = collect($requirements)
                ->groupBy('id')
                ->map(fn(Collection $items): array => [
                    'id' => $items->first()['id'],
                    'qty' => $items->sum(fn(array $item): float => (float) $item['qty']),
                ])
                ->values();

            $rawMaterials = RawMaterial::query()
                ->whereIn('id', $requirements->pluck('id')->all(), 'and', false)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($requirements as $requirement) {
                $rawMaterial = $rawMaterials->get($requirement['id']);
                $quantity = (float) $requirement['qty'];

                if (! $rawMaterial || ($rawMaterial->stok_baik ?? 0) < $quantity) {
                    throw ValidationException::withMessages([
                        'raw_materials' => 'Stok bahan baku baik tidak mencukupi.',
                    ]);
                }

                $receipts = RawMaterialReceipt::query()
                    ->where('raw_material_id', $rawMaterial->id)
                    ->where('remaining_good_quantity', '>', 0)
                    ->orderBy('received_at')
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get();

                $available = (float) $receipts->sum('remaining_good_quantity');

                if ($available < $quantity) {
                    throw ValidationException::withMessages([
                        'raw_materials' => 'Stok bahan baku baik tidak mencukupi.',
                    ]);
                }

                $remaining = $quantity;

                foreach ($receipts as $receipt) {
                    if ($remaining <= 0) {
                        break;
                    }

                    $consumed = min((float) $receipt->remaining_good_quantity, $remaining);
                    $receipt->remaining_good_quantity -= $consumed;
                    $receipt->save();
                    $remaining -= $consumed;
                }

                $rawMaterial->decrement('stok', $quantity);
                $rawMaterial->decrement('stok_baik', $quantity);
            }
        });
    }

    public function adjustRawMaterialCondition(array $data): RawMaterialConditionAdjustment
    {
        return DB::transaction(function () use ($data): RawMaterialConditionAdjustment {
            $rawMaterial = RawMaterial::query()->lockForUpdate()->findOrFail($data['raw_material_id']);
            $quantity = (float) $data['quantity'];
            $fromStatus = $data['from_status'];
            $toStatus = $data['to_status'];

            if ($quantity <= 0 || $fromStatus === $toStatus) {
                throw ValidationException::withMessages([
                    'quantity' => 'Perubahan kondisi harus bernilai lebih dari 0 dan status harus berbeda.',
                ]);
            }

            $sourceColumn = $fromStatus === 'Baik' ? 'remaining_good_quantity' : 'remaining_damaged_quantity';
            $targetColumn = $toStatus === 'Baik' ? 'remaining_good_quantity' : 'remaining_damaged_quantity';

            $receipts = RawMaterialReceipt::query()
                ->where('raw_material_id', $rawMaterial->id)
                ->where($sourceColumn, '>', 0)
                ->orderBy('received_at')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            $available = (float) $receipts->sum($sourceColumn);

            if ($available < $quantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok pada kondisi asal tidak mencukupi.',
                ]);
            }

            $remaining = $quantity;
            $firstReceiptId = null;

            foreach ($receipts as $receipt) {
                if ($remaining <= 0) {
                    break;
                }

                $moved = min((float) $receipt->{$sourceColumn}, $remaining);
                $receipt->{$sourceColumn} -= $moved;
                $receipt->{$targetColumn} += $moved;
                $receipt->save();
                $remaining -= $moved;

                $firstReceiptId ??= $receipt->id;
            }

            if ($fromStatus === 'Baik' && $toStatus === 'Rusak') {
                $rawMaterial->decrement('stok_baik', $quantity);
                $rawMaterial->increment('stok_rusak', $quantity);
            } elseif ($fromStatus === 'Rusak' && $toStatus === 'Baik') {
                $rawMaterial->decrement('stok_rusak', $quantity);
                $rawMaterial->increment('stok_baik', $quantity);
            }

            return RawMaterialConditionAdjustment::create([
                'raw_material_id' => $rawMaterial->id,
                'raw_material_receipt_id' => $firstReceiptId,
                'from_status' => $fromStatus,
                'to_status' => $toStatus,
                'quantity' => $quantity,
                'adjusted_at' => $data['adjusted_at'],
                'notes' => $data['notes'] ?? null,
            ])->load('receipt.supplier');
        });
    }

    public function storeShipmentWithItems(array $shipmentData, array $items): Shipment
    {
        return DB::transaction(function () use ($shipmentData, $items): Shipment {
            $normalizedItems = collect($items)
                ->map(function (array $item): array {
                    return [
                        'product_id' => (int) $item['product_id'],
                        'quantity' => (int) $item['quantity'],
                    ];
                })
                ->filter(fn(array $item): bool => $item['product_id'] > 0 && $item['quantity'] > 0)
                ->groupBy('product_id')
                ->map(fn(Collection $group): array => [
                    'product_id' => (int) $group->first()['product_id'],
                    'quantity' => $group->sum('quantity'),
                ])
                ->values();

            if ($normalizedItems->isEmpty()) {
                throw ValidationException::withMessages([
                    'items' => 'Minimal satu item distribusi harus diisi.',
                ]);
            }

            $products = Product::query()
                ->whereIn('id', $normalizedItems->pluck('product_id')->all(), 'and', false)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($normalizedItems as $item) {
                $product = $products->get($item['product_id']);

                if (! $product || ($product->stok ?? 0) < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => 'Stok barang jadi tidak mencukupi.',
                    ]);
                }
            }

            $shipment = Shipment::create($shipmentData);

            foreach ($normalizedItems as $item) {
                $product = $products->get($item['product_id']);

                ShipmentItem::create([
                    'shipment_id' => $shipment->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                ]);

                $product->decrement('stok', $item['quantity']);
            }

            return $shipment->load('distributor', 'items.product');
        });
    }
}
