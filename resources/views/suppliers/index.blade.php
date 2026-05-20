<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Katalog Multi-Supplier') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('suppliers.katalog') }}"
                    class="inline-block rounded-md bg-green-600 px-4 py-2 text-white transition hover:bg-green-700">📦
                    Katalog Bahan Baku</a>
                <a href="{{ route('suppliers.create') }}"
                    class="inline-block rounded-md bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">+
                    Tambah Supplier</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            <!-- Konfigurasi WSM -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="border-b border-gray-200 p-6 dark:border-gray-700">
                    <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Konfigurasi WSM</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bobot
                                Harga</label>
                            <input type="text" value="0.4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bobot
                                Kualitas</label>
                            <input type="text" value="0.3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bobot Lead
                                Waktu</label>
                            <input type="text" value="0.2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bobot
                                Performa</label>
                            <input type="text" value="0.1"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button
                            class="rounded-md bg-gray-800 px-4 py-2 text-white transition hover:bg-gray-700 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">
                            Simpan & Hitung Ulang WSM
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabel Supplier -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Nama Supplier</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Kontak</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Skor WSM</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Ranking</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Status</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($suppliers as $supplier)
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
                                            {{ $score ? number_format($score * 100, 2) : '-' }}</td>
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
                                            <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                            @if (auth()->check() && in_array(auth()->user()->role, ['Admin', 'Manager']))
                                                <form action="{{ route('suppliers.preferred', $supplier->id) }}"
                                                    method="POST" class="ms-2 inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-sm text-amber-600 hover:underline">
                                                        @if ($supplier->preferred)
                                                            Unset Preferred
                                                        @else
                                                            Set Preferred
                                                        @endif
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
