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
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">PT Agro
                                        Madura</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">Kunyit Segar</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">Rp 12.000/kg</td>
                                    <td class="px-4 py-3"><span
                                            class="rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800 dark:bg-green-900 dark:text-green-200">Tersedia</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">CV Jamu
                                        Alami</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">Beras Merah</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">Rp 8.000/kg</td>
                                    <td class="px-4 py-3"><span
                                            class="rounded-full bg-green-100 px-2 text-xs font-semibold text-green-800 dark:bg-green-900 dark:text-green-200">Tersedia</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
