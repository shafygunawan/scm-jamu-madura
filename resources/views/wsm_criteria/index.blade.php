<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Kriteria WSM') }}
            </h2>
            <a href="{{ route('suppliers.index') }}" class="text-sm text-gray-500 hover:underline">Kembali ke Supplier</a>
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
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('wsm-criteria.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            Nama Kriteria</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            Tipe</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            Bobot</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                    @forelse ($criteria as $criterion)
                                        <tr>
                                            <td
                                                class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $criterion->nama_kriteria }}</td>
                                            <td
                                                class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $criterion->tipe }}</td>
                                            <td
                                                class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                <input type="number" step="0.0001" min="0"
                                                    name="criteria[{{ $criterion->id }}][bobot]"
                                                    value="{{ old('criteria.' . $criterion->id . '.bobot', $criterion->bobot) }}"
                                                    class="w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3"
                                                class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                                Belum ada kriteria.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">Simpan
                                Bobot</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
