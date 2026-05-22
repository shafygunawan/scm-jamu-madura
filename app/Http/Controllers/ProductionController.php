<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductionBatch;
use App\Models\RawMaterial;
use App\Services\InventoryStockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProductionController extends Controller
{
    public function __construct(private InventoryStockService $stockService) {}

    public function index(): View
    {
        $batches = ProductionBatch::with('product')
            ->latest('tanggal')
            ->latest('id')
            ->get();

        return view('productions.index', compact('batches'));
    }

    public function create(): View
    {
        $rawMaterials = RawMaterial::query()->orderBy('nama', 'asc')->get();
        $products = Product::query()->orderBy('nama', 'asc')->get();
        $threshold = config('inventory.low_stock_threshold', 10);

        return view('productions.create', compact('rawMaterials', 'products', 'threshold'));
    }

    public function edit(ProductionBatch $production): View
    {
        $production->load('product');

        return view('productions.edit', compact('production'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'status' => ['nullable', Rule::in(['Diproses', 'Selesai'])],
            'raw_materials' => ['required', 'array', 'min:1'],
            'raw_materials.*.id' => ['required', 'integer', 'exists:raw_materials,id'],
            'raw_materials.*.qty' => ['required', 'numeric', 'min:0.01'],
        ]);

        DB::transaction(function () use ($data): void {
            $product = Product::query()->lockForUpdate()->findOrFail($data['product_id']);
            $this->stockService->consumeRawMaterialsForProduction($data['raw_materials']);

            $product->increment('stok', $data['quantity']);

            ProductionBatch::create([
                'product_id' => $data['product_id'],
                'tanggal' => now()->toDateString(),
                'jumlah' => $data['quantity'],
                'status' => $data['status'] ?? 'Diproses',
            ]);
        });

        return redirect()->route('productions.index')->with('success', 'Batch produksi berhasil disimpan.');
    }

    public function update(Request $request, ProductionBatch $production): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['Diproses', 'Selesai', 'Dibatalkan'])],
        ]);

        $production->update($data);

        return redirect()->route('productions.index')->with('success', 'Status batch produksi berhasil diperbarui.');
    }
}
