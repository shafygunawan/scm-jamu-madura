<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Buat Batch Produksi</h2>
            <a href="{{ route('productions.index') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto grid max-w-7xl gap-6 sm:px-6 md:grid-cols-3 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="mb-4 flex items-center justify-between p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Stok Bahan Baku</h3>
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
                                    Stok Tersedia</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            @forelse ($rawMaterials as $rawMaterial)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $rawMaterial->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $rawMaterial->stok }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        @if (($rawMaterial->stok ?? 0) < $threshold)
                                            <span
                                                class="rounded-full bg-red-100 px-2 text-xs font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-200">Kritis</span>
                                        @else
                                            <span
                                                class="rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-200">Aman</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Belum
                                        ada bahan baku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-span-2 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('productions.store') }}" method="POST" x-data="{ items: [{ id: '', qty: 1 }] }">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                    Produksi</label>
                                <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">

                                @if ($errors->get('tanggal'))
                                    <ul class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">
                                        @foreach ((array) $errors->get('tanggal') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produk
                                    Target</label>
                                <select name="product_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                            {{ $product->nama }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->get('product_id'))
                                    <ul class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">
                                        @foreach ((array) $errors->get('product_id') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Batch
                                    (Unit)</label>
                                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">

                                @if ($errors->get('quantity'))
                                    <ul class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">
                                        @foreach ((array) $errors->get('quantity') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status
                                    Awal</label>
                                <select name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="Diproses">Diproses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>

                                @if ($errors->get('status'))
                                    <ul class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">
                                        @foreach ((array) $errors->get('status') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bahan
                                        Baku</label>
                                    <button type="button" @click="items.push({ id: '', qty: 1 })"
                                        class="text-sm text-indigo-600 hover:underline">+ Tambah bahan</button>
                                </div>

                                @if ($errors->get('raw_materials'))
                                    <ul class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">
                                        @foreach ((array) $errors->get('raw_materials') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                <template x-for="(item, index) in items" :key="index">
                                    <div class="grid grid-cols-1 gap-3 md:grid-cols-12">
                                        <div class="md:col-span-7">
                                            <select :name="`raw_materials[${index}][id]`" x-model="item.id"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                                <option value="">-- Pilih Bahan --</option>
                                                @foreach ($rawMaterials as $rawMaterial)
                                                    <option value="{{ $rawMaterial->id }}">{{ $rawMaterial->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="md:col-span-4">
                                            <input type="number" step="0.01" min="0.01"
                                                :name="`raw_materials[${index}][qty]`" x-model="item.qty"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                                placeholder="Qty">
                                        </div>
                                        <div class="flex items-center justify-end md:col-span-1">
                                            <button type="button" @click="items.splice(index, 1)"
                                                x-show="items.length > 1"
                                                class="text-sm text-red-600 hover:underline">Hapus</button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('productions.index') }}"
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
