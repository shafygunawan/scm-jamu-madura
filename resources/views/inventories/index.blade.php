<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Manajemen Stok Gudang') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ tab: 'bahan_baku' }">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if ($lowStock->isNotEmpty())
                <div class="rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/30 dark:text-red-200"
                    role="alert">
                    <span class="font-medium">Peringatan!</span>
                    <span>
                        {{ $lowStock->pluck('nama')->join(', ') }} berada di bawah batas minimum {{ $threshold }}.
                    </span>
                </div>
            @endif

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

            <div x-show="tab === 'bahan_baku'"
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="mb-4 flex items-center justify-between p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Stok Bahan Baku</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('inventories.raw-materials.create') }}"
                            class="inline-block rounded-md bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">+
                            Tambah Bahan</a>
                        <a href="{{ route('inventories.receive') }}"
                            class="inline-block rounded-md bg-green-600 px-4 py-2 text-white transition hover:bg-green-700">Penerimaan
                            Barang</a>
                    </div>
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
                                <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
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
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('inventories.raw-materials.edit', $rawMaterial) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                        <form action="{{ route('inventories.raw-materials.destroy', $rawMaterial) }}"
                                            method="POST" class="ms-3 inline-block"
                                            onsubmit="return confirm('Hapus bahan baku ini?')">
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
                                        ada bahan baku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="tab === 'barang_jadi'" x-cloak
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="mb-4 flex items-center justify-between p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Stok Barang Jadi</h3>
                    <a href="{{ route('inventories.product.create') }}"
                        class="inline-block rounded-md bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">+
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
                                    Stok Tersedia</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            @forelse ($products as $product)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $product->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $product->stok }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('inventories.products.edit', $product) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                        <form action="{{ route('inventories.products.destroy', $product) }}"
                                            method="POST" class="ms-3 inline-block"
                                            onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Belum
                                        ada produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
