<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Shipment;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with('distributor')->get();

        return view('distributions.index', compact('shipments'));
    }

    public function create()
    {
        $distributors = Distributor::all();

        return view('distributions.create', compact('distributors'));
    }

    public function distributorCreate()
    {
        return view('distributions.distributor_create');
    }

    public function storeShipment(Request $request)
    {
        $data = $request->validate([
            'distributor_id' => 'required|integer',
            'address' => 'required|string',
            'status' => 'required|string',
        ]);

        Shipment::create($data);

        return redirect()->route('distributions.index')->with('success', 'Shipment recorded');
    }
}
