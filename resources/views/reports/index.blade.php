<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Laporan & Ekspor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Buat Laporan Baru</h3>

                    <form action="{{ route('reports.export') }}" method="GET" class="space-y-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-1">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis
                                    Laporan</label>
                                <select name="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="inventory">Laporan Stok (Bahan Baku & Barang Jadi)</option>
                                    <option value="production">Laporan Produksi</option>
                                    <option value="distribution">Laporan Distribusi & Pembayaran</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="submit"
                                class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-white transition hover:bg-red-700">
                                Export PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Stok</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $rawMaterials->count() }} bahan
                            baku, {{ $products->count() }} produk jadi.</p>
                    </div>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Produksi</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $productionBatches->count() }} batch
                            produksi tercatat.</p>
                    </div>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Distribusi</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $shipments->count() }} pengiriman
                            tercatat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
