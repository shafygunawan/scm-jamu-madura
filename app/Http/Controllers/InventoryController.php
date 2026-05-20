<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RawMaterial;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $rawMaterials = RawMaterial::all();
        $products = Product::all();

        $threshold = config('inventory.low_stock_threshold', 10);
        $lowStock = $rawMaterials->filter(fn ($rm) => ($rm->stok ?? 0) < $threshold)->values();

        return view('inventories.index', compact('rawMaterials', 'products', 'lowStock', 'threshold'));
    }

    public function receive()
    {
        $rawMaterials = RawMaterial::all();

        return view('inventories.receive', compact('rawMaterials'));
    }

    public function productCreate()
    {
        return view('inventories.product_create');
    }

    public function storeReceive(Request $request)
    {
        $data = $request->validate([
            'raw_material_id' => 'required|integer',
            'quantity' => 'required|numeric|min:0.01',
        ]);

        $rm = RawMaterial::findOrFail($data['raw_material_id']);
        $rm->stok = ($rm->stok ?? 0) + $data['quantity'];
        $rm->save();

        return redirect()->route('inventories.index')->with('success', 'Stock updated');
    }
}
