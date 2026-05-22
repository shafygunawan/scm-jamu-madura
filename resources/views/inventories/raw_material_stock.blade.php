<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Detail Stok Bahan Baku
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $rawMaterial->nama }}</p>
            </div>
            <a href="{{ route('inventories.index') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Stok Total</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ $rawMaterial->stok }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Stok Baik</p>
                    <p class="mt-2 text-2xl font-semibold text-emerald-600 dark:text-emerald-400">
                        {{ $rawMaterial->stok_baik }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Stok Rusak</p>
                    <p class="mt-2 text-2xl font-semibold text-red-600 dark:text-red-400">{{ $rawMaterial->stok_rusak }}
                    </p>
                </div>
            </div>

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="mb-4 text-lg font-medium">Stok per Supplier</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Supplier</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Stok Baik</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Stok Rusak</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                @forelse ($supplierBreakdown as $breakdown)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $breakdown['supplier']?->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $breakdown['good_quantity'] }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $breakdown['damaged_quantity'] }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $breakdown['total_quantity'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada penerimaan untuk bahan baku ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="mb-4 text-lg font-medium">Riwayat Penerimaan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Supplier</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Total</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Baik</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Rusak</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Sisa Baik</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Sisa Rusak</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                @forelse ($receipts as $receipt)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $receipt->received_at?->format('d-m-Y') }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $receipt->supplier?->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $receipt->quantity }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $receipt->good_quantity }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $receipt->damaged_quantity }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $receipt->remaining_good_quantity }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $receipt->remaining_damaged_quantity }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada riwayat penerimaan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="mb-4 text-lg font-medium">Mutasi Kondisi</h3>
                    <form action="{{ route('inventories.raw-materials.condition-adjustments.store', $rawMaterial) }}"
                        method="POST" class="mb-6 rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                        @csrf
                        <div class="grid gap-4 md:grid-cols-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari</label>
                                <select name="from_status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    @foreach (['Baik', 'Rusak'] as $status)
                                        <option value="{{ $status }}" @selected(old('from_status', 'Baik') === $status)>
                                            {{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ke</label>
                                <select name="to_status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    @foreach (['Baik', 'Rusak'] as $status)
                                        <option value="{{ $status }}" @selected(old('to_status', 'Rusak') === $status)>
                                            {{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                                <input type="number" min="0.01" step="0.01" name="quantity"
                                    value="{{ old('quantity', 1) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="adjusted_at"
                                    value="{{ old('adjusted_at', now()->toDateString()) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                            <input type="text" name="notes" value="{{ old('notes') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Simpan
                                Mutasi</button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Dari</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Ke</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Jumlah</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                @forelse ($rawMaterial->conditionAdjustments as $adjustment)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $adjustment->adjusted_at?->format('d-m-Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $adjustment->from_status }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $adjustment->to_status }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $adjustment->quantity }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $adjustment->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada mutasi kondisi.
                                        </td>
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
