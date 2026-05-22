<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Product;
use App\Models\Shipment;
use App\Services\InventoryStockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DistributionController extends Controller
{
    public function __construct(private InventoryStockService $stockService) {}

    public function index(): View
    {
        $shipments = Shipment::with(['distributor', 'items.product'])->latest('tanggal_pengiriman')->latest('id')->get();
        $distributors = Distributor::query()->orderBy('nama', 'asc')->get();

        return view('distributions.index', compact('shipments', 'distributors'));
    }

    public function create(): View
    {
        $distributors = Distributor::query()->orderBy('nama', 'asc')->get();
        $products = Product::query()->orderBy('nama', 'asc')->get();

        return view('distributions.create', compact('distributors', 'products'));
    }

    public function edit(Shipment $shipment): View
    {
        $shipment->load(['distributor', 'items.product']);
        $distributors = Distributor::query()->orderBy('nama', 'asc')->get();

        return view('distributions.edit', compact('shipment', 'distributors'));
    }

    public function shipmentItems(Shipment $shipment): View
    {
        $shipment->load(['distributor', 'items.product']);

        return view('distributions.items', compact('shipment'));
    }

    public function storeShipment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'distributor_id' => ['required', 'integer', 'exists:distributors,id'],
            'tanggal_pengiriman' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['Diproses', 'Dikirim', 'Diterima', 'Batal'])],
            'status_pembayaran' => ['required', Rule::in(['Lunas', 'DP', 'Pending'])],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $shipment = $this->stockService->storeShipmentWithItems([
            'distributor_id' => $data['distributor_id'],
            'tanggal_pengiriman' => $data['tanggal_pengiriman'] ?? null,
            'status' => $data['status'],
            'status_pembayaran' => $data['status_pembayaran'],
        ], $data['items']);

        return redirect()->route('distributions.index')->with('success', 'Pengiriman berhasil disimpan.');
    }

    public function distributorCreate(): View
    {
        return view('distributions.distributor_create', [
            'distributor' => new Distributor,
        ]);
    }

    public function distributorStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'kontak' => ['required', 'string', 'max:255'],
        ]);

        Distributor::create($data);

        return redirect()->route('distributions.index')->with('success', 'Distributor berhasil ditambahkan.');
    }

    public function distributorEdit(Distributor $distributor): View
    {
        return view('distributions.distributor_edit', compact('distributor'));
    }

    public function distributorUpdate(Request $request, Distributor $distributor): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'kontak' => ['required', 'string', 'max:255'],
        ]);

        $distributor->update($data);

        return redirect()->route('distributions.index')->with('success', 'Distributor berhasil diperbarui.');
    }

    public function distributorDestroy(Distributor $distributor): RedirectResponse
    {
        Distributor::destroy($distributor->id);

        return redirect()->route('distributions.index')->with('success', 'Distributor berhasil dihapus.');
    }

    public function updateShipment(Request $request, Shipment $shipment): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['Diproses', 'Dikirim', 'Diterima', 'Batal'])],
            'status_pembayaran' => ['required', Rule::in(['Lunas', 'DP', 'Pending'])],
            'tanggal_pengiriman' => ['nullable', 'date'],
        ]);

        $shipment->update($data);

        return redirect()->route('distributions.index')->with('success', 'Status pengiriman berhasil diperbarui.');
    }
}
