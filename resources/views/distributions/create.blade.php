<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Buat Pengiriman</h2>
            <a href="{{ route('distributions.index') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('distributions.store') }}" method="POST">
                        @csrf
                        @php
                            $oldItems = old('items', [['product_id' => '', 'quantity' => 1]]);
                        @endphp

                        <div class="space-y-4" x-data="{ items: @js($oldItems) }">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Distributor
                                    Tujuan</label>
                                <select name="distributor_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">-- Pilih Distributor --</option>
                                    @foreach ($distributors as $distributor)
                                        <option value="{{ $distributor->id }}" @selected(old('distributor_id') == $distributor->id)>
                                            {{ $distributor->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                    Pengiriman</label>
                                <input type="date" name="tanggal_pengiriman"
                                    value="{{ old('tanggal_pengiriman', now()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status
                                    Pengiriman</label>
                                <select name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    @foreach (['Diproses', 'Dikirim', 'Diterima', 'Batal'] as $status)
                                        <option value="{{ $status }}" @selected(old('status', 'Diproses') === $status)>
                                            {{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status
                                    Pembayaran</label>
                                <select name="status_pembayaran"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    @foreach (['Lunas', 'DP', 'Pending'] as $statusPembayaran)
                                        <option value="{{ $statusPembayaran }}" @selected(old('status_pembayaran', 'Pending') === $statusPembayaran)>
                                            {{ $statusPembayaran }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <div class="mb-3 flex items-center justify-between">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item
                                        Distribusi</label>
                                    <button type="button" @click="items.push({ product_id: '', quantity: 1 })"
                                        class="rounded-md bg-emerald-600 px-3 py-1.5 text-sm text-white hover:bg-emerald-700">+
                                        Tambah Item</button>
                                </div>

                                <template x-for="(item, index) in items" :key="index">
                                    <div
                                        class="mb-3 grid gap-3 rounded-lg border border-gray-200 p-4 md:grid-cols-5 dark:border-gray-700">
                                        <div class="md:col-span-3">
                                            <label
                                                class="block text-xs font-medium uppercase text-gray-500 dark:text-gray-400">Barang
                                                Jadi</label>
                                            <select :name="`items[${index}][product_id]`" x-model="item.product_id"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                                <option value="">-- Pilih Barang Jadi --</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-medium uppercase text-gray-500 dark:text-gray-400">Jumlah</label>
                                            <input type="number" min="1" step="1"
                                                :name="`items[${index}][quantity]`" x-model="item.quantity"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" @click="items.splice(index, 1)"
                                                x-show="items.length > 1"
                                                class="rounded-md border border-red-300 px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:border-red-700 dark:text-red-400 dark:hover:bg-red-900/20">Hapus</button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('distributions.index') }}"
                                class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300">Batal</a>
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
