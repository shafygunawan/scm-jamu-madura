<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Katalog Bahan Baku</h2>
            <a href="{{ route('suppliers.index') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 flex items-center justify-between">
                        <div></div>
                        @if (auth()->check() && in_array(auth()->user()->role, ['Admin', 'Manager']))
                            <a href="{{ route('suppliers.katalog.create') }}"
                                class="inline-block rounded-md bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">+
                                Tambah Entri</a>
                        @endif
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Supplier</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Jenis Bahan</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Harga/Unit</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Lead Time (hari)</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Status</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                @forelse ($catalog as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $item->supplier->nama ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $item->rawMaterial->nama ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                            {{ 'Rp ' . number_format($item->harga, 0, ',', '.') }} /
                                            {{ $item->rawMaterial?->unit ?? 'kg' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $item->lead_time }}</td>
                                        <td class="px-4 py-3"><span
                                                class="rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800 dark:bg-green-900 dark:text-green-200">Tersedia</span>
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm font-medium">
                                            @if (auth()->check() && in_array(auth()->user()->role, ['Admin', 'Manager']))
                                                <a href="{{ route('suppliers.katalog.edit', $item) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                                <form action="{{ route('suppliers.katalog.destroy', $item) }}"
                                                    method="POST" class="ms-3 inline-block"
                                                    onsubmit="return confirm('Hapus entri katalog ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                                </form>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">Tidak
                                            ada data katalog.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
