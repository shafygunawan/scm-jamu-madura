<?php

namespace App\Http\Controllers;

use App\Models\EvaluationCriteria;
use App\Models\RawMaterial;
use App\Models\Supplier;
use App\Services\WsmService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(protected WsmService $wsm) {}

    public function index(Request $request): View
    {
        $suppliers = Supplier::query()->orderBy('nama', 'asc')->get();
        $rankings = collect();

        $rawMaterialId = $request->query('raw_material_id');
        if ($rawMaterialId) {
            $rankings = $this->wsm->rankForRawMaterial((int) $rawMaterialId);
            $scores = $rankings->mapWithKeys(fn($r, $i) => [$r->supplier->id => ['score' => $r->score, 'rank' => $i + 1]]);
        } else {
            $scores = collect();
        }

        $rawMaterials = RawMaterial::query()->orderBy('nama', 'asc')->get();
        $criteria = EvaluationCriteria::query()->orderBy('id', 'asc')->get();

        return view('suppliers.index', compact('suppliers', 'rankings', 'rawMaterials', 'scores', 'criteria'));
    }

    public function setPreferred(Request $request, int $id): RedirectResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->preferred = ! ($supplier->preferred ?? false);
        $supplier->save();

        return back()->with('success', 'Status preferred supplier diperbarui');
    }

    public function create(): View
    {
        return view('suppliers.create', [
            'supplier' => new Supplier,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kontak' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'dokumen_legal' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('dokumen_legal')) {
            $data['dokumen_legal'] = $request->file('dokumen_legal')->store('supplier-documents', 'public');
        }

        $data['preferred'] = false;

        Supplier::create($data);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier): View
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kontak' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'dokumen_legal' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('dokumen_legal')) {
            if ($supplier->dokumen_legal && Storage::disk('public')->exists($supplier->dokumen_legal)) {
                Storage::disk('public')->delete($supplier->dokumen_legal);
            }

            $data['dokumen_legal'] = $request->file('dokumen_legal')->store('supplier-documents', 'public');
        }

        $supplier->update($data);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        if ($supplier->dokumen_legal && Storage::disk('public')->exists($supplier->dokumen_legal)) {
            Storage::disk('public')->delete($supplier->dokumen_legal);
        }

        Supplier::destroy($supplier->id);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }

    public function katalog(Request $request): View
    {
        return view('suppliers.katalog');
    }
}
