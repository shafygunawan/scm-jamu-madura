<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Models\Supplier;
use App\Services\WsmService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct(protected WsmService $wsm) {}

    public function index(Request $request)
    {
        $suppliers = Supplier::all();
        $rankings = collect();

        $rawMaterialId = $request->query('raw_material_id');
        if ($rawMaterialId) {
            $rankings = $this->wsm->rankForRawMaterial((int) $rawMaterialId);
            $scores = $rankings->mapWithKeys(fn($r, $i) => [$r->supplier->id => ['score' => $r->score, 'rank' => $i + 1]]);
        } else {
            $scores = collect();
        }

        $rawMaterials = RawMaterial::all();
        return view('suppliers.index', compact('suppliers', 'rankings', 'rawMaterials', 'scores'));
    }

    public function setPreferred(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->preferred = ! ($supplier->preferred ?? false);
        $supplier->save();

        return back()->with('success', 'Status preferred supplier diperbarui');
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function edit($id)
    {
        return view('suppliers.edit', ['id' => $id]);
    }

    public function katalog(Request $request)
    {
        // keep existing view contract; WSM evaluation done via index when raw_material_id provided
        return view('suppliers.katalog');
    }
}
