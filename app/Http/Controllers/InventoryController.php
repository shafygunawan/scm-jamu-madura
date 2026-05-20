<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RawMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
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

        return view('inventories.receive', compact('rawMaterials'));
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
            'raw_material_id' => ['required', 'integer', 'exists:raw_materials,id'],
            'quantity' => ['required', 'numeric', 'min:0.01'],
        ]);

        $rm = RawMaterial::findOrFail($data['raw_material_id']);
        $rm->stok = ($rm->stok ?? 0) + $data['quantity'];
        $rm->save();

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
