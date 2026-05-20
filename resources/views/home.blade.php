<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0 dark:bg-gray-900">
        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-8 text-center shadow-md sm:max-w-md sm:rounded-lg dark:bg-gray-800">

            <!-- Icon/Visual Status (Opsional, bikin UI lebih hidup) -->
            <div
                class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-200">
                <svg class="h-6 w-6 animate-spin" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>

            <!-- Teks Peringatan -->
            <h2 class="mt-4 text-xl font-semibold text-gray-900 dark:text-gray-100">
                Mengalihkan Halaman
            </h2>

            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Anda akan di-redirect dalam <span id="countdown"
                    class="font-bold text-blue-600 dark:text-blue-400">5</span> detik.
            </p>

            <!-- Tombol Manual Bantuan -->
            <div class="mt-6 border-t border-gray-100 pt-4 dark:border-gray-700">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Jika halaman tidak berpindah otomatis, <a id="redirect-link" href="#"
                        class="font-medium text-blue-500 hover:underline">klik di sini</a>.
                </p>
            </div>

        </div>
    </div>

    <!-- Script Countdown & Redirect -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Tentukan tujuan URL dan waktu hitung mundur (detik)
            const urlTujuan = "{{ route('dashboard') }}";
            let sisaWaktu = 5;

            const countdownElement = document.getElementById("countdown");
            const redirectLink = document.getElementById("redirect-link");

            // Set link manual cadangan
            redirectLink.href = urlTujuan;

            // 2. Jalankan interval hitung mundur
            const interval = setInterval(() => {
                sisaWaktu--;
                countdownElement.textContent = sisaWaktu;

                if (sisaWaktu <= 0) {
                    clearInterval(interval);
                    window.location.href = urlTujuan; // Eksekusi redirect
                }
            }, 1000);
        });
    </script>
</body>

</html>
