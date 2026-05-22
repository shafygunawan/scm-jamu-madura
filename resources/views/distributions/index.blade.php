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
            @if (session('success'))
                <div class="rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex border-b border-gray-200 dark:border-gray-700">
                <button @click="tab = 'pengiriman'"
                    :class="tab === 'pengiriman' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="border-b-2 px-4 py-2 text-sm font-medium">Tracking Pengiriman</button>
                <button @click="tab = 'distributor'"
                    :class="tab === 'distributor' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="border-b-2 px-4 py-2 text-sm font-medium">Master Data Distributor</button>
            </div>

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
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Distributor</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Status Pengiriman</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Pembayaran</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Item</th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                @forelse ($shipments as $shipment)
                                    <tr>
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $shipment->tanggal_pengiriman }}</td>
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $shipment->distributor?->nama ?? '-' }}</td>
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $shipment->status }}</td>
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $shipment->status_pembayaran }}</td>
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $shipment->items->sum('quantity') }} item</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <a href="{{ route('distributions.items', $shipment) }}"
                                                class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300">Lihat
                                                Item</a>
                                            <a href="{{ route('distributions.edit', $shipment) }}"
                                                class="ms-3 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Update
                                                Status</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada pengiriman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

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
                                    Alamat</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Kontak</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            @forelse ($distributors as $distributor)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $distributor->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $distributor->alamat }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $distributor->kontak }}</td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('distributions.distributor.edit', $distributor) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                        <form action="{{ route('distributions.distributor.destroy', $distributor) }}"
                                            method="POST" class="ms-3 inline-block"
                                            onsubmit="return confirm('Hapus distributor ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Belum
                                        ada distributor.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
