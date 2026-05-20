<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Shipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DistributionController extends Controller
{
    public function index(): View
    {
        $shipments = Shipment::with('distributor')->latest('tanggal_pengiriman')->latest('id')->get();
        $distributors = Distributor::query()->orderBy('nama', 'asc')->get();

        return view('distributions.index', compact('shipments', 'distributors'));
    }

    public function create(): View
    {
        $distributors = Distributor::query()->orderBy('nama', 'asc')->get();

        return view('distributions.create', compact('distributors'));
    }

    public function edit(Shipment $shipment): View
    {
        $shipment->load('distributor');
        $distributors = Distributor::query()->orderBy('nama', 'asc')->get();

        return view('distributions.edit', compact('shipment', 'distributors'));
    }

    public function storeShipment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'distributor_id' => ['required', 'integer', 'exists:distributors,id'],
            'tanggal_pengiriman' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['Diproses', 'Dikirim', 'Diterima', 'Batal'])],
            'status_pembayaran' => ['required', Rule::in(['Lunas', 'DP', 'Pending'])],
        ]);

        Shipment::create($data);

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
