<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- KPI Cards -->
            <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-4">
                <!-- Stok Bahan Baku -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Stok Bahan Baku</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">1,245 kg</p>
                            </div>
                            <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-green-600 dark:text-green-400">+5% dari minggu lalu</p>
                    </div>
                </div>

                <!-- Produksi Bulan Ini -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Produksi Bulan Ini</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">850 L</p>
                            </div>
                            <div class="rounded-full bg-green-100 p-3 dark:bg-green-900">
                                <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-green-600 dark:text-green-400">+12% dari bulan lalu</p>
                    </div>
                </div>

                <!-- Pengiriman Aktif -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengiriman Aktif</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">12</p>
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
                        <p class="mt-4 text-xs text-gray-600 dark:text-gray-400">3 dalam perjalanan</p>
                    </div>
                </div>

                <!-- Distributor Aktif -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Distributor Aktif</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">24</p>
                            </div>
                            <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900">
                                <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 19H9a6 6 0 016-6v0a6 6 0 016 6v1"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-green-600 dark:text-green-400">Semua dalam keadaan baik</p>
                    </div>
                </div>
            </div>

            <!-- Charts and Activity Section -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Grafik Performa Supplier -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg lg:col-span-2 dark:bg-gray-800">
                    <div class="p-6">
                        <h3 class="mb-6 text-lg font-medium text-gray-900 dark:text-gray-100">Performa Supplier (Score
                            WSM)</h3>
                        <div class="space-y-4">
                            <!-- Supplier 1 -->
                            <div>
                                <div class="mb-2 flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">PT Agro
                                        Madura</span>
                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100">85.4/100</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                    <div class="h-2 rounded-full bg-green-600" style="width: 85.4%"></div>
                                </div>
                            </div>
                            <!-- Supplier 2 -->
                            <div>
                                <div class="mb-2 flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">CV Jamu
                                        Alami</span>
                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100">72.1/100</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                    <div class="h-2 rounded-full bg-yellow-500" style="width: 72.1%"></div>
                                </div>
                            </div>
                            <!-- Supplier 3 -->
                            <div>
                                <div class="mb-2 flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Mitra Tanaman
                                        Herbal</span>
                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100">68.5/100</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                    <div class="h-2 rounded-full bg-orange-500" style="width: 68.5%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas Terakhir -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Aktivitas Terakhir</h3>
                        <div class="space-y-4">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                                        <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Produksi Dimulai</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Jamu Kunyit Asam - 20 Mei 2026
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                                        <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Pengiriman Diterima
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SHP-002 ke Apotek Bugar - 18
                                        Mei 2026</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900">
                                        <svg class="h-4 w-4 text-yellow-600 dark:text-yellow-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Penerimaan Bahan
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">50 kg Kunyit dari PT Agro - 17
                                        Mei 2026</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
