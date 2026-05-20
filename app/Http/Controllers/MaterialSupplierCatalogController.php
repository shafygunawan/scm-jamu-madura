<?php

namespace App\Http\Controllers;

use App\Models\MaterialSupplierCatalog;
use App\Models\RawMaterial;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterialSupplierCatalogController extends Controller
{
    public function create(): View
    {
        $suppliers = Supplier::orderBy('nama')->get();
        $rawMaterials = RawMaterial::orderBy('nama')->get();

        return view('suppliers.katalog.create', compact('suppliers', 'rawMaterials'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
            'raw_material_id' => ['required', 'integer', 'exists:raw_materials,id'],
            'harga' => ['required', 'numeric', 'min:0'],
            'lead_time' => ['nullable', 'integer', 'min:0'],
        ]);

        MaterialSupplierCatalog::create($data);

        return redirect()->route('suppliers.katalog')->with('success', 'Entri katalog berhasil ditambahkan.');
    }

    public function edit(MaterialSupplierCatalog $catalog): View
    {
        $suppliers = Supplier::orderBy('nama')->get();
        $rawMaterials = RawMaterial::orderBy('nama')->get();

        return view('suppliers.katalog.edit', compact('catalog', 'suppliers', 'rawMaterials'));
    }

    public function update(Request $request, MaterialSupplierCatalog $catalog): RedirectResponse
    {
        $data = $request->validate([
            'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
            'raw_material_id' => ['required', 'integer', 'exists:raw_materials,id'],
            'harga' => ['required', 'numeric', 'min:0'],
            'lead_time' => ['nullable', 'integer', 'min:0'],
        ]);

        $catalog->update($data);

        return redirect()->route('suppliers.katalog')->with('success', 'Entri katalog berhasil diperbarui.');
    }

    public function destroy(MaterialSupplierCatalog $catalog): RedirectResponse
    {
        $catalog->delete();

        return back()->with('success', 'Entri katalog berhasil dihapus.');
    }
}
