<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Manajemen Distribusi') }}
            </h2>
            <a href="{{ route('distributions.create') }}"
                class="inline-block rounded-md bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">+ Buat
                Pengiriman</a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ tab: 'pengiriman' }">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-200 dark:border-gray-700">
                <button @click="tab = 'pengiriman'"
                    :class="tab === 'pengiriman' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="border-b-2 px-4 py-2 text-sm font-medium">
                    Tracking Pengiriman
                </button>
                <button @click="tab = 'distributor'"
                    :class="tab === 'distributor' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="border-b-2 px-4 py-2 text-sm font-medium">
                    Master Data Distributor
                </button>
            </div>

            <!-- Tab: Tracking Pengiriman -->
            <div x-show="tab === 'pengiriman'"
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Pengiriman</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        ID Pengiriman</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Distributor Tujuan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Status Pengiriman</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Pembayaran</th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                <tr>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        SHP-001</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">20
                                        Mei 2026</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        Toko Sehat Selalu (Surabaya)</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span
                                            class="inline-flex rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            Sedang Dikirim
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span
                                            class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            DP / Termin 1
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('distributions.create') }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Update
                                            Status</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        SHP-002</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">18
                                        Mei 2026</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        Apotek Bugar (Malang)</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Diterima
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Lunas
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <a href="#" class="cursor-not-allowed text-gray-400">Selesai</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tab: Master Data Distributor -->
            <div x-show="tab === 'distributor'" x-cloak
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="mb-4 flex items-center justify-between p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Master Data Distributor</h3>
                    <a href="{{ route('distributions.distributor.create') }}"
                        class="inline-block rounded-md bg-green-600 px-4 py-2 text-white transition hover:bg-green-700">+
                        Tambah Distributor</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Nama Distributor</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Kota/Lokasi</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Kontak</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Tipe</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Status</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Toko Sehat
                                    Selalu</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Surabaya</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">08123456789</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Retail</td>
                                <td class="px-6 py-4"><span
                                        class="rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800 dark:bg-green-900 dark:text-green-200">Aktif</span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('distributions.distributor.create') }}"
                                        class="text-xs text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Apotek Bugar
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Malang</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">08234567890</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Apotek</td>
                                <td class="px-6 py-4"><span
                                        class="rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800 dark:bg-green-900 dark:text-green-200">Aktif</span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('distributions.distributor.create') }}"
                                        class="text-xs text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Klinik Sehat
                                    Jaya</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Bandung</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">08345678901</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Klinik</td>
                                <td class="px-6 py-4"><span
                                        class="rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800 dark:bg-green-900 dark:text-green-200">Aktif</span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('distributions.distributor.create') }}"
                                        class="text-xs text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
