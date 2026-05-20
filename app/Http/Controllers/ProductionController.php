<?php

namespace App\Http\Controllers;

use App\Models\ProductionBatch;
use App\Models\RawMaterial;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        $batches = ProductionBatch::all();

        return view('productions.index', compact('batches'));
    }

    public function create()
    {
        $rawMaterials = RawMaterial::all();

        return view('productions.create', compact('rawMaterials'));
    }

    public function edit($id)
    {
        return view('productions.edit', ['id' => $id]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'raw_materials' => 'nullable|array',
            'raw_materials.*.id' => 'required_with:raw_materials|integer|exists:raw_materials,id',
            'raw_materials.*.qty' => 'required_with:raw_materials|numeric|min:0.01',
        ]);

        $product = \App\Models\Product::findOrFail($data['product_id']);

        // Check raw material availability
        $requirements = collect($data['raw_materials'] ?? []);
        foreach ($requirements as $req) {
            $rm = \App\Models\RawMaterial::findOrFail($req['id']);
            if (($rm->stok ?? 0) < $req['qty']) {
                return back()->withErrors(['raw_materials' => "Stok untuk {$rm->nama} tidak mencukupi"])->withInput();
            }
        }

        // Deduct raw materials
        foreach ($requirements as $req) {
            $rm = \App\Models\RawMaterial::findOrFail($req['id']);
            $rm->stok = ($rm->stok ?? 0) - $req['qty'];
            $rm->save();
        }

        // Increase product stock
        $product->stok = ($product->stok ?? 0) + $data['quantity'];
        $product->save();

        $batch = ProductionBatch::create([
            'product_id' => $data['product_id'],
            'tanggal' => now()->toDateString(),
            'jumlah' => $data['quantity'],
            'status' => 'Selesai',
        ]);

        return redirect()->route('productions.index')->with('success', 'Production batch created and stock updated');
    }
}
