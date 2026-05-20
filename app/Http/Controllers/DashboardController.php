<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Product;
use App\Models\ProductionBatch;
use App\Models\RawMaterial;
use App\Models\Shipment;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $data = [];

        match ($user->role) {
            'Admin' => $data = $this->getAdminStats(),
            'Manager' => $data = $this->getManagerStats(),
            'Produksi' => $data = $this->getProductionStats(),
            'Gudang' => $data = $this->getWarehouseStats(),
            'Distributor' => $data = $this->getDistributorStats(),
        };

        return view('dashboard', $data);
    }

    /**
     * Get statistics for Admin role
     */
    private function getAdminStats(): array
    {
        return [
            'role' => 'Admin',
            'totalUsers' => User::count(),
            'totalSuppliers' => Supplier::count(),
            'totalProducts' => Product::count(),
            'totalProductions' => ProductionBatch::count(),
            'totalShipments' => Shipment::count(),
            'totalDistributors' => Distributor::count(),
            'recentProductions' => ProductionBatch::latest()->take(5)->get(),
            'lowStockProducts' => Product::where('stok', '<', 50)->get(),
            'lowStockRawMaterials' => RawMaterial::where('stok', '<', 100)->get(),
        ];
    }

    /**
     * Get statistics for Manager role
     */
    private function getManagerStats(): array
    {
        $topSuppliers = Supplier::withSum('ratings', 'skor')
            ->orderByDesc('ratings_sum_skor')
            ->take(5)
            ->get();

        $pendingProductions = ProductionBatch::where('status', '!=', 'Selesai')
            ->count();

        $lowStockRawMaterials = RawMaterial::where('stok', '<', 100)
            ->count();

        return [
            'role' => 'Manager',
            'totalSuppliers' => Supplier::count(),
            'totalProductions' => ProductionBatch::count(),
            'pendingProductions' => $pendingProductions,
            'totalShipments' => Shipment::count(),
            'topSuppliers' => $topSuppliers,
            'lowStockAlerts' => $lowStockRawMaterials,
            'recentProductions' => ProductionBatch::latest()->take(5)->get(),
        ];
    }

    /**
     * Get statistics for Produksi role
     */
    private function getProductionStats(): array
    {
        $pendingProductions = ProductionBatch::where('status', '!=', 'Selesai')
            ->with('product')
            ->latest()
            ->get();

        $completedThisMonth = ProductionBatch::where('status', 'Selesai')
            ->whereMonth('created_at', now()->month)
            ->count();

        $totalProductionThisMonth = ProductionBatch::whereMonth('created_at', now()->month)
            ->sum('jumlah');

        return [
            'role' => 'Produksi',
            'pendingProductions' => $pendingProductions,
            'completedThisMonth' => $completedThisMonth,
            'totalProductionThisMonth' => $totalProductionThisMonth,
            'lowStockRawMaterials' => RawMaterial::where('stok', '<', 100)->get(),
            'allProducts' => Product::all(),
        ];
    }

    /**
     * Get statistics for Gudang role
     */
    private function getWarehouseStats(): array
    {
        $lowStockProducts = Product::where('stok', '<', 50)->get();
        $lowStockRawMaterials = RawMaterial::where('stok', '<', 100)->get();

        $incomingShipments = Shipment::where('status', '!=', 'Terkirim')
            ->with('distributor')
            ->latest()
            ->get();

        return [
            'role' => 'Gudang',
            'totalProducts' => (int) Product::sum('stok'),
            'totalRawMaterials' => (int) RawMaterial::sum('stok'),
            'lowStockProducts' => $lowStockProducts,
            'lowStockProductsCount' => $lowStockProducts->count(),
            'lowStockRawMaterials' => $lowStockRawMaterials,
            'lowStockRawMaterialsCount' => $lowStockRawMaterials->count(),
            'incomingShipments' => $incomingShipments,
            'totalIncomingShipments' => $incomingShipments->count(),
            'allProducts' => Product::all(),
            'allRawMaterials' => RawMaterial::all(),
        ];
    }

    /**
     * Get statistics for Distributor role
     */
    private function getDistributorStats(): array
    {
        // Distributors can only see their own shipments
        $userId = auth()->id();
        $distributor = Distributor::first();

        $shipments = Shipment::where('distributor_id', $distributor?->id ?? 0)
            ->with('distributor')
            ->latest()
            ->get();

        $deliveredCount = $shipments->where('status', 'Terkirim')->count();
        $pendingCount = $shipments->where('status', '!=', 'Terkirim')->count();

        return [
            'role' => 'Distributor',
            'shipments' => $shipments->take(10),
            'totalShipments' => $shipments->count(),
            'deliveredCount' => $deliveredCount,
            'pendingCount' => $pendingCount,
        ];
    }
}
