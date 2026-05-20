<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }} - {{ $role }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Admin Dashboard -->
            @if ($role === 'Admin')
                <!-- KPI Cards -->
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $totalUsers }}</p>
                                </div>
                                <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 19H9a6 6 0 016-6v0a6 6 0 016 6v1"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Suppliers</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $totalSuppliers }}</p>
                                </div>
                                <div class="rounded-full bg-green-100 p-3 dark:bg-green-900">
                                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Shipments</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $totalShipments }}</p>
                                </div>
                                <div class="rounded-full bg-yellow-100 p-3 dark:bg-yellow-900">
                                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Low Stock Products -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Low Stock Products
                            </h3>
                            @if ($lowStockProducts->count() > 0)
                                <div class="space-y-3">
                                    @foreach ($lowStockProducts as $product)
                                        <div
                                            class="flex items-center justify-between border-b pb-3 dark:border-gray-700">
                                            <span
                                                class="text-sm text-gray-700 dark:text-gray-300">{{ $product->nama }}</span>
                                            <span
                                                class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-200">{{ $product->stok }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">All products have sufficient stock
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Low Stock Raw Materials -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Low Stock Raw
                                Materials</h3>
                            @if ($lowStockRawMaterials->count() > 0)
                                <div class="space-y-3">
                                    @foreach ($lowStockRawMaterials as $material)
                                        <div
                                            class="flex items-center justify-between border-b pb-3 dark:border-gray-700">
                                            <span
                                                class="text-sm text-gray-700 dark:text-gray-300">{{ $material->nama }}</span>
                                            <span
                                                class="inline-flex items-center rounded-full bg-orange-100 px-3 py-1 text-xs font-medium text-orange-800 dark:bg-orange-900 dark:text-orange-200">{{ $material->stok }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">All raw materials have sufficient
                                    stock</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Manager Dashboard -->
            @elseif ($role === 'Manager')
                <!-- KPI Cards -->
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Productions
                                    </p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $pendingProductions }}</p>
                                </div>
                                <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Low Stock Alerts</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $lowStockAlerts }}</p>
                                </div>
                                <div class="rounded-full bg-red-100 p-3 dark:bg-red-900">
                                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Suppliers -->
                <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <h3 class="mb-6 text-lg font-medium text-gray-900 dark:text-gray-100">Top Suppliers (WSM Score)
                        </h3>
                        <div class="space-y-4">
                            @forelse ($topSuppliers as $supplier)
                                <div>
                                    <div class="mb-2 flex items-center justify-between">
                                        <span
                                            class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $supplier->nama }}</span>
                                        <span
                                            class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ number_format($supplier->ratings_sum_skor ?? 0, 1) }}/100</span>
                                    </div>
                                    <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="{{ ($supplier->ratings_sum_skor ?? 0) >= 80 ? 'bg-green-600' : (($supplier->ratings_sum_skor ?? 0) >= 60 ? 'bg-yellow-500' : 'bg-red-600') }} h-2 rounded-full"
                                            style="width: {{ min($supplier->ratings_sum_skor ?? 0, 100) }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">No suppliers found</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Produksi Dashboard -->
            @elseif ($role === 'Produksi')
                <!-- KPI Cards -->
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Tasks</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $pendingProductions->count() }}</p>
                                </div>
                                <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed This
                                        Month</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $completedThisMonth }}</p>
                                </div>
                                <div class="rounded-full bg-green-100 p-3 dark:bg-green-900">
                                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Production
                                        (Month)</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $totalProductionThisMonth }}</p>
                                </div>
                                <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900">
                                    <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Productions -->
                <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Pending Production Tasks
                        </h3>
                        @if ($pendingProductions->count() > 0)
                            <div class="space-y-3">
                                @foreach ($pendingProductions as $production)
                                    <div
                                        class="flex items-center justify-between rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $production->product->nama ?? 'Unknown' }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $production->tanggal->format('d M Y') }} - Qty:
                                                {{ $production->jumlah }}</p>
                                        </div>
                                        <span
                                            class="{{ $production->status === 'Dalam Proses' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }} inline-flex items-center rounded-full px-3 py-1 text-xs font-medium">{{ $production->status }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No pending tasks</p>
                        @endif
                    </div>
                </div>

                <!-- Gudang Dashboard -->
            @elseif ($role === 'Gudang')
                <!-- KPI Cards -->
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Product Stock
                                    </p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ number_format($totalProducts, 0) }}</p>
                                </div>
                                <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4m8 4l-8 4m8-4v10l-8 4m0-10L4 7m0 10v10l8 4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Low Stock Products
                                    </p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $lowStockProductsCount }}</p>
                                </div>
                                <div class="rounded-full bg-red-100 p-3 dark:bg-red-900">
                                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Incoming Shipments
                                    </p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $totalIncomingShipments }}</p>
                                </div>
                                <div class="rounded-full bg-yellow-100 p-3 dark:bg-yellow-900">
                                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Low Stock Products -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Low Stock Products
                            </h3>
                            @if ($lowStockProducts->count() > 0)
                                <div class="space-y-3">
                                    @foreach ($lowStockProducts as $product)
                                        <div
                                            class="flex items-center justify-between border-b pb-3 dark:border-gray-700">
                                            <span
                                                class="text-sm text-gray-700 dark:text-gray-300">{{ $product->nama }}</span>
                                            <span
                                                class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-200">{{ $product->stok }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">All products have sufficient stock
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Incoming Shipments -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Incoming Shipments
                            </h3>
                            @if ($incomingShipments->count() > 0)
                                <div class="space-y-3">
                                    @foreach ($incomingShipments->take(5) as $shipment)
                                        <div
                                            class="flex items-center justify-between border-b pb-3 dark:border-gray-700">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $shipment->distributor->nama ?? 'Unknown' }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $shipment->tanggal_pengiriman->format('d M Y') }}</p>
                                            </div>
                                            <span
                                                class="{{ $shipment->status === 'Terkirim' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }} inline-flex items-center rounded-full px-2 py-1 text-xs font-medium">{{ $shipment->status }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">No incoming shipments</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Distributor Dashboard -->
            @elseif ($role === 'Distributor')
                <!-- KPI Cards -->
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Shipments</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $totalShipments }}</p>
                                </div>
                                <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Delivered</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $deliveredCount }}</p>
                                </div>
                                <div class="rounded-full bg-green-100 p-3 dark:bg-green-900">
                                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $pendingCount }}</p>
                                </div>
                                <div class="rounded-full bg-yellow-100 p-3 dark:bg-yellow-900">
                                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipments List -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Your Shipments</h3>
                        @if ($shipments->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="border-b border-gray-200 dark:border-gray-700">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                Distributor</th>
                                            <th
                                                class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                Date</th>
                                            <th
                                                class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                Status</th>
                                            <th
                                                class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($shipments as $shipment)
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $shipment->distributor->nama ?? 'Unknown' }}</td>
                                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $shipment->tanggal_pengiriman->format('d M Y') }}</td>
                                                <td class="px-4 py-3 text-sm"><span
                                                        class="{{ $shipment->status === 'Terkirim' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }} inline-flex items-center rounded-full px-2 py-1 text-xs font-medium">{{ $shipment->status }}</span>
                                                </td>
                                                <td class="px-4 py-3 text-sm"><span
                                                        class="{{ $shipment->status_pembayaran === 'Lunas' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }} inline-flex items-center rounded-full px-2 py-1 text-xs font-medium">{{ $shipment->status_pembayaran }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No shipments assigned</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
