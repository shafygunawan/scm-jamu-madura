<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductionBatch;
use App\Models\RawMaterial;
use App\Models\RawMaterialReceipt;
use App\Models\Shipment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $rawMaterials = RawMaterial::query()->orderBy('nama', 'asc')->get();
        $products = Product::query()->orderBy('nama', 'asc')->get();
        $productionBatches = ProductionBatch::with('product')->latest('tanggal')->latest('id')->get();
        $shipments = Shipment::with('distributor')->latest('tanggal_pengiriman')->latest('id')->get();

        return view('reports.index', compact('rawMaterials', 'products', 'productionBatches', 'shipments'));
    }

    public function exportPdf(Request $request)
    {
        $data = $request->validate([
            'type' => ['nullable', 'in:inventory,production,distribution'],
        ]);

        $type = $data['type'] ?? 'inventory';
        $generatedAt = now();

        if ($type === 'inventory') {
            $rawMaterials = RawMaterial::with('receipts.supplier')->orderBy('nama', 'asc')->get();

            $rawMaterialBreakdowns = $rawMaterials->mapWithKeys(function (RawMaterial $rawMaterial): array {
                $receiptGroups = $rawMaterial->receipts->groupBy('supplier_id')->map(function ($receiptGroup): array {
                    $firstReceipt = $receiptGroup->first();

                    return [
                        'supplier_name' => $firstReceipt?->supplier?->nama ?? '-',
                        'good_quantity' => (float) $receiptGroup->sum('remaining_good_quantity'),
                        'damaged_quantity' => (float) $receiptGroup->sum('remaining_damaged_quantity'),
                        'total_quantity' => (float) $receiptGroup->sum(fn(RawMaterialReceipt $receipt): float => (float) $receipt->remaining_good_quantity + (float) $receipt->remaining_damaged_quantity),
                    ];
                })->values();

                return [
                    $rawMaterial->id => $receiptGroups,
                ];
            });

            $payload = [
                'type' => $type,
                'generatedAt' => $generatedAt,
                'rawMaterials' => $rawMaterials,
                'rawMaterialBreakdowns' => $rawMaterialBreakdowns,
                'products' => Product::query()->orderBy('nama', 'asc')->get(),
            ];
        } elseif ($type === 'production') {
            $payload = [
                'type' => $type,
                'generatedAt' => $generatedAt,
                'productionBatches' => ProductionBatch::with('product')->latest('tanggal')->latest('id')->get(),
            ];
        } else {
            $payload = [
                'type' => $type,
                'generatedAt' => $generatedAt,
                'shipments' => Shipment::with(['distributor', 'items.product'])->latest('tanggal_pengiriman')->latest('id')->get(),
            ];
        }

        $pdf = Pdf::loadView('reports.pdf', $payload)->setPaper('a4', 'portrait');

        return $pdf->stream("report_{$type}.pdf");
    }
}
