<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Item Distribusi
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $shipment->distributor?->nama ?? '-' }} - {{ $shipment->tanggal_pengiriman }}
                </p>
            </div>
            <a href="{{ route('distributions.index') }}" class="text-sm text-gray-500 hover:underline">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6 grid gap-4 md:grid-cols-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status Pengiriman</p>
                            <p class="mt-1 font-medium">{{ $shipment->status }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status Pembayaran</p>
                            <p class="mt-1 font-medium">{{ $shipment->status_pembayaran }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Pengiriman</p>
                            <p class="mt-1 font-medium">{{ $shipment->tanggal_pengiriman?->format('d-m-Y') ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Barang Jadi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">
                                        Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                @forelse ($shipment->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $item->product?->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $item->quantity }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2"
                                            class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada item distribusi.
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
