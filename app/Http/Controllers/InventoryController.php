<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\RawMaterialReceipt;
use App\Models\Supplier;
use App\Services\InventoryStockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function __construct(private InventoryStockService $stockService) {}

    public function index(): View
    {
        $rawMaterials = RawMaterial::query()->orderBy('nama', 'asc')->get();
        $products = Product::query()->orderBy('nama', 'asc')->get();

        $threshold = config('inventory.low_stock_threshold', 10);
        $lowStock = $rawMaterials->filter(fn($rm) => ($rm->stok ?? 0) < $threshold)->values();

        return view('inventories.index', compact('rawMaterials', 'products', 'lowStock', 'threshold'));
    }

    public function receive(): View
    {
        $rawMaterials = RawMaterial::query()->orderBy('nama', 'asc')->get();
        $suppliers = Supplier::query()->orderBy('nama', 'asc')->get();

        return view('inventories.receive', compact('rawMaterials', 'suppliers'));
    }

    public function rawMaterialStock(RawMaterial $rawMaterial): View
    {
        $rawMaterial->load('conditionAdjustments.receipt.supplier');

        $receipts = RawMaterialReceipt::query()
            ->with('supplier')
            ->where('raw_material_id', $rawMaterial->id)
            ->orderBy('received_at')
            ->orderBy('id')
            ->get();

        $supplierBreakdown = $receipts
            ->groupBy('supplier_id')
            ->map(function ($receiptGroup): array {
                $firstReceipt = $receiptGroup->first();

                return [
                    'supplier' => $firstReceipt?->supplier,
                    'good_quantity' => (float) $receiptGroup->sum('remaining_good_quantity'),
                    'damaged_quantity' => (float) $receiptGroup->sum('remaining_damaged_quantity'),
                    'total_quantity' => (float) $receiptGroup->sum(fn(RawMaterialReceipt $receipt): float => (float) $receipt->remaining_good_quantity + (float) $receipt->remaining_damaged_quantity),
                ];
            })
            ->values();

        return view('inventories.raw_material_stock', [
            'rawMaterial' => $rawMaterial,
            'receipts' => $receipts,
            'supplierBreakdown' => $supplierBreakdown,
        ]);
    }

    public function storeRawMaterialConditionAdjustment(Request $request, RawMaterial $rawMaterial): RedirectResponse
    {
        $data = $request->validate([
            'from_status' => ['required', Rule::in(['Baik', 'Rusak'])],
            'to_status' => ['required', Rule::in(['Baik', 'Rusak'])],
            'quantity' => ['required', 'numeric', 'min:0.01'],
            'adjusted_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $this->stockService->adjustRawMaterialCondition([
            'raw_material_id' => $rawMaterial->id,
            'from_status' => $data['from_status'],
            'to_status' => $data['to_status'],
            'quantity' => $data['quantity'],
            'adjusted_at' => $data['adjusted_at'],
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
            ->route('inventories.raw-materials.stock', $rawMaterial)
            ->with('success', 'Mutasi kondisi bahan baku berhasil disimpan.');
    }

    public function productCreate(): View
    {
        return view('inventories.product_create', [
            'product' => new Product,
        ]);
    }

    public function storeReceive(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
            'raw_material_id' => ['required', 'integer', 'exists:raw_materials,id'],
            'received_at' => ['required', 'date'],
            'good_quantity' => ['required', 'numeric', 'min:0'],
            'damaged_quantity' => ['nullable', 'numeric', 'min:0'],
        ]);

        $this->stockService->recordRawMaterialReceipt([
            'supplier_id' => $data['supplier_id'],
            'raw_material_id' => $data['raw_material_id'],
            'received_at' => $data['received_at'],
            'good_quantity' => $data['good_quantity'],
            'damaged_quantity' => $data['damaged_quantity'] ?? 0,
        ]);

        return redirect()->route('inventories.index')->with('success', 'Stok bahan baku berhasil diperbarui.');
    }

    public function rawMaterialCreate(): View
    {
        return view('inventories.raw_material_form', [
            'rawMaterial' => new RawMaterial,
        ]);
    }

    public function rawMaterialStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'numeric', 'min:0'],
        ]);

        $data['stok_baik'] = $data['stok'];
        $data['stok_rusak'] = 0;

        RawMaterial::create($data);

        return redirect()->route('inventories.index')->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    public function rawMaterialEdit(RawMaterial $rawMaterial): View
    {
        return view('inventories.raw_material_form', compact('rawMaterial'));
    }

    public function rawMaterialUpdate(Request $request, RawMaterial $rawMaterial): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'numeric', 'min:0'],
        ]);

        $data['stok_baik'] = $data['stok'];
        $data['stok_rusak'] = 0;

        $rawMaterial->update($data);

        return redirect()->route('inventories.index')->with('success', 'Bahan baku berhasil diperbarui.');
    }

    public function rawMaterialDestroy(RawMaterial $rawMaterial): RedirectResponse
    {
        RawMaterial::destroy($rawMaterial->id);

        return redirect()->route('inventories.index')->with('success', 'Bahan baku berhasil dihapus.');
    }

    public function productStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        Product::create($data);

        return redirect()->route('inventories.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function productEdit(Product $product): View
    {
        return view('inventories.product_create', compact('product'));
    }

    public function productUpdate(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($data);

        return redirect()->route('inventories.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function productDestroy(Product $product): RedirectResponse
    {
        Product::destroy($product->id);

        return redirect()->route('inventories.index')->with('success', 'Produk berhasil dihapus.');
    }
}
