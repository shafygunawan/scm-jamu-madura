<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RawMaterial;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $rawMaterials = RawMaterial::all();
        $products = Product::all();

        return view('reports.index', compact('rawMaterials', 'products'));
    }

    public function exportPdf(Request $request)
    {
        $type = $request->query('type', 'inventory');

        $data = [];
        if ($type === 'inventory') {
            $data['rawMaterials'] = RawMaterial::all();
            $view = 'reports.inventory_pdf';
        } else {
            $data['products'] = Product::all();
            $view = 'reports.products_pdf';
        }

        if (class_exists(Pdf::class)) {
            $pdf = Pdf::loadView($view, $data);

            return $pdf->stream("report_{$type}.pdf");
        }

        // Fallback: render HTML view if DomPDF not installed
        return view($view, $data);
    }
}
