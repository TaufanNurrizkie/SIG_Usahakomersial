<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $usaha->nama_usaha }}</title>
    <!-- Tailwind CSS (✅ no space!) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,0..200&display=swap"
        rel="stylesheet" />

    <!-- Leaflet CSS (✅ no space!) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                    },
                    fontFamily: {
                        display: ["Public Sans", "sans-serif"]
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Leaflet marker fix */
        .leaflet-popup-content {
            margin: 8px 12px !important;
            line-height: 1.4 !important;
        }
    </style>
</head>

    <!-- Top Navigation -->
    <header
        class="sticky top-0 z-50 w-full bg-white/95 dark:bg-[#111418]/95 backdrop-blur-sm border-b border-[#f0f2f4] dark:border-gray-800">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-10 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="text-primary size-8 flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl">map</span>
                    </div>
                    <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">
                        Kertapati</h2>
                </div>
                <div class="hidden lg:flex flex-1 justify-end gap-9 items-center">
                    <nav class="flex items-center gap-9">
                        <a class="text-[#111418] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors"
                            href="/">Beranda</a>
                        <a class="text-[#111418] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors"
                            href="/">Peta Usaha</a>
                        <a class="text-[#111418] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors"
                            href="/">Statistik</a>
                        <a class="text-[#111418] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors"
                            href="/">Tentang</a>
                    </nav>
                    <div class="flex gap-2">
                        <a href="/register"
                            class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors shadow-sm">
                            <span class="truncate">Daftar Usaha</span>
                        </a>
                        <a href="/login"
                            class="flex items-center justify-center rounded-lg h-9 px-4 border border-[#e5e7eb] dark:border-gray-700 bg-white dark:bg-transparent text-[#111418] dark:text-white text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <span class="truncate">Masuk</span>
                        </a>
                    </div>
                </div>
                <button class="lg:hidden p-2 text-gray-600">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </header>


<body class="bg-gray-100">

<div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ================= LEFT CONTENT ================= --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $usaha->nama_usaha }}
            </h1>

            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-600">
                {{ $usaha->kategori?->nama_kategori ?? 'Tanpa Kategori' }}
            </span>
        </div>

        {{-- Image --}}
        <div class="w-full overflow-hidden rounded-xl border">
            <img
                src="{{ asset('storage/' . $usaha->foto_usaha) }}"
                alt="{{ $usaha->nama_usaha }}"
                class="w-full h-[320px] object-cover"
            >
        </div>

        {{-- Info --}}
        <div class="grid sm:grid-cols-2 gap-6 text-sm">
            <div>
                <p class="font-semibold text-gray-700 mb-1">Alamat</p>
                <p class="text-gray-600">
                    {{ $usaha->alamat ?? '-' }}
                </p>
            </div>

            <div>
                <p class="font-semibold text-gray-700 mb-1">Koordinat</p>
                <p class="text-gray-600">
                    Latitude: {{ $usaha->latitude }} <br>
                    Longitude: {{ $usaha->longitude }}
                </p>
            </div>
        </div>

        {{-- Description --}}
        <div>
            <p class="font-semibold text-gray-700 mb-2">Deskripsi</p>
            <p class="text-gray-600 leading-relaxed">
                {{ $usaha->deskripsi ?? 'Tidak ada deskripsi.' }}
            </p>
        </div>
    </div>

    {{-- ================= RIGHT SIDEBAR ================= --}}
    <div class="space-y-4">

        {{-- Map --}}
        <div class="bg-white rounded-xl shadow-sm border p-4">
            <p class="font-semibold text-gray-700 mb-3">Peta Lokasi</p>
            <div id="map" class="h-64 rounded-lg overflow-hidden"></div>
        </div>

        {{-- Navigation --}}
        <div class="bg-white rounded-xl shadow-sm border p-4 space-y-3">
            <p class="font-semibold text-gray-700">Navigasi</p>

            <a
                href="https://www.google.com/maps?q={{ $usaha->latitude }},{{ $usaha->longitude }}"
                target="_blank"
                class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition"
            >
                Petunjuk Arah
            </a>

            <a
                href="{{ url()->previous() }}"
                class="block text-center border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50 transition"
            >
                Kembali
            </a>
        </div>
    </div>

</div>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    const map = L.map('map', {
        zoomControl: false
    }).setView(
        [{{ $usaha->latitude }}, {{ $usaha->longitude }}],
        15
    );

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    L.marker([{{ $usaha->latitude }}, {{ $usaha->longitude }}])
        .addTo(map)
        .bindPopup(`<b>{{ $usaha->nama_usaha }}</b>`)
        .openPopup();
</script>

</body>
</html>
