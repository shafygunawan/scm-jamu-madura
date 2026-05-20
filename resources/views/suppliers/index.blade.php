<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Katalog Multi-Supplier') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('wsm-criteria.index') }}"
                    class="inline-block rounded-md bg-amber-600 px-4 py-2 text-white transition hover:bg-amber-700">Kelola
                    Kriteria WSM</a>
                <a href="{{ route('suppliers.katalog') }}"
                    class="inline-block rounded-md bg-gray-600 px-4 py-2 text-white transition hover:bg-gray-700">Lihat
                    Katalog</a>
                <a href="{{ route('suppliers.create') }}"
                    class="inline-block rounded-md bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">+
                    Tambah Supplier</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="border-b border-gray-200 p-6 dark:border-gray-700">
                    <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Evaluasi Supplier WSM</h3>
                    <form action="{{ route('suppliers.index') }}" method="GET"
                        class="flex flex-col gap-3 md:flex-row md:items-end">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bahan Baku</label>
                            <select name="raw_material_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">-- Pilih bahan baku --</option>
                                @foreach ($rawMaterials as $rawMaterial)
                                    <option value="{{ $rawMaterial->id }}" @selected(request('raw_material_id') == $rawMaterial->id)>
                                        {{ $rawMaterial->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="rounded-md bg-gray-800 px-4 py-2 text-white transition hover:bg-gray-700 dark:bg-gray-200 dark:text-gray-800">Hitung
                            Ranking</button>
                    </form>
                </div>
            </div>

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Nama Supplier</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Kontak</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Skor WSM</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Ranking</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Status</th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                @forelse ($suppliers as $supplier)
                                    @php
                                        $meta = $scores->get($supplier->id) ?? null;
                                        $score = $meta['score'] ?? null;
                                        $rank = $meta['rank'] ?? null;
                                    @endphp
                                    <tr>
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $supplier->nama }}</td>
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $supplier->kontak }}</td>
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $score ? number_format($score, 4) : '-' }}</td>
                                        <td
                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $rank ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @if ($supplier->preferred)
                                                <span
                                                    class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 dark:bg-green-900 dark:text-green-200">Preferred</span>
                                            @else
                                                <span
                                                    class="inline-flex rounded-full bg-gray-100 px-2 text-xs font-semibold leading-5 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Reguler</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <a href="{{ route('suppliers.edit', $supplier) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                            @if (auth()->check() && in_array(auth()->user()->role, ['Admin', 'Manager']))
                                                <form action="{{ route('suppliers.preferred', $supplier->id) }}"
                                                    method="POST" class="ms-3 inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-amber-600 hover:underline">{{ $supplier->preferred ? 'Unset Preferred' : 'Set Preferred' }}</button>
                                                </form>
                                                <form action="{{ route('suppliers.destroy', $supplier) }}"
                                                    method="POST" class="ms-3 inline-block"
                                                    onsubmit="return confirm('Hapus supplier ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada supplier.</td>
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
