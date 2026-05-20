<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductionBatch;
use App\Models\RawMaterial;
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

        if ($type === 'inventory') {
            $payload = [
                'type' => $type,
                'rawMaterials' => RawMaterial::query()->orderBy('nama', 'asc')->get(),
                'products' => Product::query()->orderBy('nama', 'asc')->get(),
            ];
        } elseif ($type === 'production') {
            $payload = [
                'type' => $type,
                'productionBatches' => ProductionBatch::with('product')->latest('tanggal')->latest('id')->get(),
            ];
        } else {
            $payload = [
                'type' => $type,
                'shipments' => Shipment::with('distributor')->latest('tanggal_pengiriman')->latest('id')->get(),
            ];
        }

        $pdf = Pdf::loadView('reports.pdf', $payload)->setPaper('a4', 'portrait');

        return $pdf->stream("report_{$type}.pdf");
    }
}
