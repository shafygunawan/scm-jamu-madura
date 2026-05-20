<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Manajemen Stok Gudang') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ tab: 'bahan_baku' }">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            <!-- Notifikasi Threshold -->
            <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <span class="font-medium">Peringatan!</span> Stok Jahe Merah telah mencapai batas minimum (Tersisa: 5
                kg). Segera lakukan pengadaan.
            </div>

            <div class="flex border-b border-gray-200 dark:border-gray-700">
                <button @click="tab = 'bahan_baku'"
                    :class="tab === 'bahan_baku' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="border-b-2 px-4 py-2 text-sm font-medium">
                    Bahan Baku
                </button>
                <button @click="tab = 'barang_jadi'"
                    :class="tab === 'barang_jadi' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="border-b-2 px-4 py-2 text-sm font-medium">
                    Barang Jadi
                </button>
            </div>

            <!-- Tabel Bahan Baku -->
            <div x-show="tab === 'bahan_baku'"
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="mb-4 flex items-center justify-between p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Stok Bahan Baku</h3>
                    <a href="{{ route('inventories.receive') }}"
                        class="inline-block rounded-md bg-green-600 px-4 py-2 text-white transition hover:bg-green-700">+
                        Penerimaan Barang</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Nama Bahan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Kategori</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Stok Tersedia</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Minimum</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Kunyit</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Rempah</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">120 kg</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">20 kg</td>
                                <td class="px-6 py-4"><span
                                        class="rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800">Aman</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Jahe Merah</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Rempah</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">5 kg</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">10 kg</td>
                                <td class="px-6 py-4"><span
                                        class="rounded-full bg-red-100 px-2 text-xs font-semibold text-red-800">Kritis</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Barang Jadi -->
            <div x-show="tab === 'barang_jadi'" x-cloak
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="mb-4 flex items-center justify-between p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Stok Barang Jadi</h3>
                    <a href="{{ route('inventories.product.create') }}"
                        class="inline-block rounded-md bg-green-600 px-4 py-2 text-white transition hover:bg-green-700">+
                        Tambah Barang Jadi</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Nama Produk</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Kemasan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Stok Tersedia</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Harga Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Jamu Kunyit Asam
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Botol 500ml</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">300 Botol</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Rp 15.000</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Jamu Beras
                                    Kencur</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Botol 500ml</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">120 Botol</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Rp 15.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
