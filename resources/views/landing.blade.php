<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Kertapati - Layanan Perizinan Usaha</title>

    <!-- Tailwind CSS (✅ no space!) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,0..200&display=swap" rel="stylesheet"/>

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
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        /* Leaflet marker fix */
        .leaflet-popup-content {
            margin: 8px 12px !important;
            line-height: 1.4 !important;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white antialiased overflow-x-hidden">

    <!-- Top Navigation -->
    <header class="sticky top-0 z-50 w-full bg-white/95 dark:bg-[#111418]/95 backdrop-blur-sm border-b border-[#f0f2f4] dark:border-gray-800">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-10 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="text-primary size-8 flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl">map</span>
                    </div>
                    <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Kertapati</h2>
                </div>
                <div class="hidden lg:flex flex-1 justify-end gap-9 items-center">
                    <nav class="flex items-center gap-9">
                        <a class="text-[#111418] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors" href="#">Beranda</a>
                        <a class="text-[#111418] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors" href="#peta">Peta Usaha</a>
                        <a class="text-[#111418] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors" href="#stats">Statistik</a>
                        <a class="text-[#111418] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors" href="#faq">Tentang</a>
                    </nav>
                    <div class="flex gap-2">
                        <a href="/register" class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors shadow-sm">
                            <span class="truncate">Daftar Usaha</span>
                        </a>
                        <a href="/login" class="flex items-center justify-center rounded-lg h-9 px-4 border border-[#e5e7eb] dark:border-gray-700 bg-white dark:bg-transparent text-[#111418] dark:text-white text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
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

    <main class="flex flex-col items-center">
        <!-- Hero Section -->
        <section class="w-full max-w-[1280px] px-4 sm:px-10 py-12 lg:py-20">
            <div class="@container">
                <div class="flex flex-col-reverse lg:flex-row gap-10 lg:gap-16 items-center">
                    <div class="flex flex-col gap-6 flex-1 text-left">
                        <div class="flex flex-col gap-4">
                            <div class="inline-flex w-fit items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/20 text-primary text-xs font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-sm">verified</span>
                                Resmi Pemerintah Kecamatan
                            </div>
                            <h1 class="text-[#111418] dark:text-white text-4xl lg:text-5xl font-black leading-tight tracking-[-0.033em]">
                                Sistem Pemetaan Usaha Komersial Kecamatan Kertapati
                            </h1>
                            <h2 class="text-[#637588] dark:text-gray-400 text-lg font-normal leading-relaxed max-w-xl">
                                Layanan digital pendataan & perizinan usaha terpadu di Kertapati, Palembang. Ajukan izin dan pantau perkembangan usaha Anda secara online.
                            </h2>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button class="flex min-w-[140px] cursor-pointer items-center justify-center rounded-lg h-12 px-6 bg-primary text-white text-base font-bold shadow-lg shadow-blue-500/20 hover:bg-primary/90 hover:shadow-xl transition-all">
                                <span class="truncate">Ajukan Usaha</span>
                            </button>
                            <a href="#peta" class="flex min-w-[140px] cursor-pointer items-center justify-center rounded-lg h-12 px-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-[#111418] dark:text-white text-base font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                <span class="truncate">Lihat Peta Usaha</span>
                            </a>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2">
                        <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl">
                            <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 to-transparent z-10"></div>
                            <div class="w-full h-full bg-cover bg-center" style='background-image: url("https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1000&auto=format&fit=crop");'></div>
                            <div class="absolute bottom-6 left-6 right-6 p-4 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md rounded-xl shadow-lg z-20 border border-white/50 dark:border-gray-700/50">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg text-green-600 dark:text-green-400">
                                        <span class="material-symbols-outlined">trending_up</span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase">Pertumbuhan UMKM</p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">+12% di Kecamatan Kertapati Tahun Ini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-- Stats Section -->
<section id="stats" class="w-full bg-[#f8f9fa] dark:bg-gray-900 border-y border-gray-100 dark:border-gray-800">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-10 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

            <!-- Total Usaha -->
            <div class="flex flex-col gap-1 p-5 rounded-xl hover:bg-white dark:hover:bg-gray-800 transition-colors">
                <div class="flex items-center gap-2 text-primary mb-2">
                    <span class="material-symbols-outlined">storefront</span>
                    <p class="text-sm font-bold uppercase tracking-wide">Total Usaha</p>
                </div>
                <p class="text-[#111418] dark:text-white text-3xl font-black">
                    {{ number_format($stats['usaha_terdaftar']) }}
                </p>
                <p class="text-sm text-gray-500">Terdaftar resmi</p>
            </div>

            <!-- Kategori -->
            <div class="flex flex-col gap-1 p-5 rounded-xl hover:bg-white dark:hover:bg-gray-800 transition-colors">
                <div class="flex items-center gap-2 text-primary mb-2">
                    <span class="material-symbols-outlined">category</span>
                    <p class="text-sm font-bold uppercase tracking-wide">Kategori</p>
                </div>
                <p class="text-[#111418] dark:text-white text-3xl font-black">
                    {{ number_format($stats['kategori']) }}
                </p>
                <p class="text-sm text-gray-500">Sektor bisnis</p>
            </div>

            <!-- Kelurahan -->
            <div class="flex flex-col gap-1 p-5 rounded-xl hover:bg-white dark:hover:bg-gray-800 transition-colors">
                <div class="flex items-center gap-2 text-primary mb-2">
                    <span class="material-symbols-outlined">location_city</span>
                    <p class="text-sm font-bold uppercase tracking-wide">Kelurahan</p>
                </div>
                <p class="text-[#111418] dark:text-white text-3xl font-black">
                    {{ number_format($stats['kelurahan']) }}
                </p>
                <p class="text-sm text-gray-500">Wilayah cakupan</p>
            </div>

        </div>
    </div>
</section>


        <!-- Map Section -->
        <section id="peta" class="w-full max-w-[1280px] px-4 sm:px-10 py-16">
            <div class="flex flex-col gap-4 mb-8">
                <h3 class="text-[#111418] dark:text-white text-2xl lg:text-3xl font-bold leading-tight">Peta Sebaran Usaha</h3>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl">Pantau lokasi usaha, zonasi komersial, dan data UMKM di seluruh kelurahan Kecamatan Kertapati.</p>
            </div>

            <div class="w-full rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="flex flex-col lg:flex-row">
                    <div class="w-full lg:w-2/3 h-[450px] relative">
                        <div id="kertapati-map" class="w-full h-full"></div>
                    </div>

                    <div class="w-full lg:w-1/3 p-8 flex flex-col justify-center gap-6 bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Fitur Peta</h4>
                            <ul class="space-y-3">
                                <li class="flex items-center gap-3 text-gray-600 dark:text-gray-300">
                                    <span class="material-symbols-outlined text-primary">layers</span>
                                    Layer Zonasi & Kelurahan
                                </li>
                                <li class="flex items-center gap-3 text-gray-600 dark:text-gray-300">
                                    <span class="material-symbols-outlined text-primary">search</span>
                                    Cari Berdasarkan Nama Usaha
                                </li>
                                <li class="flex items-center gap-3 text-gray-600 dark:text-gray-300">
                                    <span class="material-symbols-outlined text-primary">filter_alt</span>
                                    Filter Kategori Usaha
                                </li>
                            </ul>
                        </div>
                        <a href="/peta" class="flex items-center justify-center gap-2 rounded-lg h-12 w-full bg-primary text-white font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-blue-500/20">
                            <span class="material-symbols-outlined">map</span>
                            Buka Peta Lengkap
    </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Flow Section -->
        <section class="w-full max-w-[1280px] px-4 sm:px-10 py-16 lg:py-24">
            <div class="text-center mb-12 max-w-2xl mx-auto">
                <span class="text-primary font-bold text-sm tracking-widest uppercase mb-2 block">Alur Pendaftaran</span>
                <h3 class="text-[#111418] dark:text-white text-3xl font-bold mb-4">6 Langkah Mudah Mendaftarkan Usaha</h3>
                <p class="text-gray-600 dark:text-gray-400">Ikuti panduan langkah demi langkah ini untuk mendapatkan izin usaha resmi di Kecamatan Kertapati.</p>
            </div>
            <div class="relative">
                <div class="hidden lg:block absolute top-1/2 left-0 w-full h-1 bg-gray-200 dark:bg-gray-700 -translate-y-1/2 z-0 rounded-full"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8 relative z-10">
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-16 h-16 rounded-full bg-white dark:bg-gray-800 border-4 border-blue-100 dark:border-gray-700 flex items-center justify-center text-primary mb-4 shadow-md group-hover:border-primary transition-colors">
                            <span class="material-symbols-outlined text-2xl">person_add</span>
                        </div>
                        <h5 class="font-bold text-gray-900 dark:text-white mb-1">1. Registrasi</h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Buat akun pengguna baru</p>
                    </div>
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-16 h-16 rounded-full bg-white dark:bg-gray-800 border-4 border-blue-100 dark:border-gray-700 flex items-center justify-center text-primary mb-4 shadow-md group-hover:border-primary transition-colors">
                            <span class="material-symbols-outlined text-2xl">edit_document</span>
                        </div>
                        <h5 class="font-bold text-gray-900 dark:text-white mb-1">2. Isi Data</h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Lengkapi profil usaha</p>
                    </div>
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-16 h-16 rounded-full bg-white dark:bg-gray-800 border-4 border-blue-100 dark:border-gray-700 flex items-center justify-center text-primary mb-4 shadow-md group-hover:border-primary transition-colors">
                            <span class="material-symbols-outlined text-2xl">pin_drop</span>
                        </div>
                        <h5 class="font-bold text-gray-900 dark:text-white mb-1">3. Lokasi</h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tentukan titik koordinat</p>
                    </div>
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-16 h-16 rounded-full bg-white dark:bg-gray-800 border-4 border-blue-100 dark:border-gray-700 flex items-center justify-center text-primary mb-4 shadow-md group-hover:border-primary transition-colors">
                            <span class="material-symbols-outlined text-2xl">upload_file</span>
                        </div>
                        <h5 class="font-bold text-gray-900 dark:text-white mb-1">4. Upload</h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Unggah dokumen syarat</p>
                    </div>
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-16 h-16 rounded-full bg-white dark:bg-gray-800 border-4 border-blue-100 dark:border-gray-700 flex items-center justify-center text-primary mb-4 shadow-md group-hover:border-primary transition-colors">
                            <span class="material-symbols-outlined text-2xl">verified_user</span>
                        </div>
                        <h5 class="font-bold text-gray-900 dark:text-white mb-1">5. Verifikasi</h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pengecekan oleh petugas</p>
                    </div>
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-16 h-16 rounded-full bg-primary border-4 border-blue-200 dark:border-blue-900 flex items-center justify-center text-white mb-4 shadow-lg shadow-blue-500/30">
                            <span class="material-symbols-outlined text-2xl">assignment_turned_in</span>
                        </div>
                        <h5 class="font-bold text-gray-900 dark:text-white mb-1">6. Selesai</h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Izin resmi diterbitkan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ & Requirements -->
        <section id="faq" class="w-full bg-white dark:bg-gray-800 py-16 border-t border-gray-100 dark:border-gray-700">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
                    <div>
                        <h3 class="text-2xl font-bold text-[#111418] dark:text-white mb-6">Persyaratan Dokumen</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Sebelum mengajukan permohonan, pastikan Anda telah menyiapkan dokumen berikut dalam format digital (PDF/JPG).</p>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3 p-4 rounded-lg bg-[#f8f9fa] dark:bg-gray-700/50">
                                <span class="material-symbols-outlined text-green-500 mt-0.5">check_circle</span>
                                <div>
                                    <h6 class="font-bold text-sm text-gray-900 dark:text-white">KTP & NPWP Pemilik</h6>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Scan KTP asli dan kartu NPWP yang masih berlaku.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3 p-4 rounded-lg bg-[#f8f9fa] dark:bg-gray-700/50">
                                <span class="material-symbols-outlined text-green-500 mt-0.5">check_circle</span>
                                <div>
                                    <h6 class="font-bold text-sm text-gray-900 dark:text-white">Foto Lokasi Usaha</h6>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Foto tampak depan dan dalam tempat usaha.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3 p-4 rounded-lg bg-[#f8f9fa] dark:bg-gray-700/50">
                                <span class="material-symbols-outlined text-green-500 mt-0.5">check_circle</span>
                                <div>
                                    <h6 class="font-bold text-sm text-gray-900 dark:text-white">Surat Keterangan Domisili</h6>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Dari Kelurahan setempat (jika diperlukan).</p>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-8 p-4 border-l-4 border-primary bg-blue-50 dark:bg-blue-900/10">
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                <strong>Dasar Hukum:</strong> Peraturan Daerah Kota Palembang No. X Tahun 20XX tentang Penataan dan Pembinaan Pusat Perbelanjaan dan Toko Swalayan.
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-[#111418] dark:text-white mb-6">Bantuan & FAQ</h3>
                        <div class="space-y-4">
                            <details class="group" open>
                                <summary class="flex cursor-pointer items-center justify-between gap-1.5 rounded-lg bg-gray-50 dark:bg-gray-700 p-4 text-gray-900 dark:text-white">
                                    <h2 class="font-bold">Berapa lama proses verifikasi?</h2>
                                    <span class="material-symbols-outlined transition duration-300 group-open:-rotate-180">expand_more</span>
                                </summary>
                                <p class="mt-4 px-4 leading-relaxed text-gray-700 dark:text-gray-300">
                                    Proses verifikasi data biasanya memakan waktu 3-5 hari kerja setelah dokumen lengkap diterima oleh sistem.
                                </p>
                            </details>
                            <details class="group">
                                <summary class="flex cursor-pointer items-center justify-between gap-1.5 rounded-lg bg-gray-50 dark:bg-gray-700 p-4 text-gray-900 dark:text-white">
                                    <h2 class="font-bold">Apakah layanan ini dipungut biaya?</h2>
                                    <span class="material-symbols-outlined transition duration-300 group-open:-rotate-180">expand_more</span>
                                </summary>
                                <p class="mt-4 px-4 leading-relaxed text-gray-700 dark:text-gray-300">
                                    Pendaftaran melalui Sistem Pemetaan Usaha Kertapati tidak dipungut biaya (Gratis). Biaya retribusi hanya berlaku sesuai peraturan daerah untuk jenis izin tertentu.
                                </p>
                            </details>
                            <details class="group">
                                <summary class="flex cursor-pointer items-center justify-between gap-1.5 rounded-lg bg-gray-50 dark:bg-gray-700 p-4 text-gray-900 dark:text-white">
                                    <h2 class="font-bold">Bagaimana jika data saya ditolak?</h2>
                                    <span class="material-symbols-outlined transition duration-300 group-open:-rotate-180">expand_more</span>
                                </summary>
                                <p class="mt-4 px-4 leading-relaxed text-gray-700 dark:text-gray-300">
                                    Jika data ditolak, Anda akan menerima notifikasi beserta alasannya. Anda dapat memperbaiki data dan mengunggah ulang dokumen melalui dashboard pengguna.
                                </p>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA -->
        <section class="w-full bg-primary py-16 relative overflow-hidden">
            <div class="absolute inset-0 bg-primary"></div>
            <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="relative max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6 tracking-tight">Siap Mengembangkan Usaha Anda?</h2>
                <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Bergabunglah sekarang untuk mendaftarkan usaha Anda agar terdata secara resmi, mudah ditemukan, dan mendukung pembangunan ekonomi wilayah.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-slate-900 bg-white rounded-xl hover:bg-slate-50 transition-colors shadow-xl shadow-white/10 hover:shadow-2xl hover:shadow-white/20">
                        Daftar Sekarang
                    </a>
                    <a href="#peta" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white border border-white/20 rounded-xl hover:bg-white/10 transition-colors">
                        Lihat Peta Sebaran
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="w-full bg-[#111418] text-white pt-16 pb-8">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <span class="material-symbols-outlined text-3xl text-primary">map</span>
                            <span class="text-xl font-bold">Kertapati Smart Map</span>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed mb-6">
                            Sistem informasi geografis dan pelayanan perizinan terpadu Kecamatan Kertapati, Palembang.
                        </p>
                        <div class="flex gap-4">
                            <a class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-colors" href="#">
                                <span class="material-symbols-outlined text-sm">public</span>
                            </a>
                            <a class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-colors" href="#">
                                <span class="material-symbols-outlined text-sm">mail</span>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-6">Kontak Kami</h4>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary shrink-0">location_on</span>
                                Jl. Ki Marogan No. 1, Kertapati, Kota Palembang, Sumatera Selatan
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary shrink-0">call</span>
                                (0711) 123456
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary shrink-0">email</span>
                                layanan@kertapati.go.id
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-6">Tautan Cepat</h4>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li><a class="hover:text-primary transition-colors" href="#">Beranda</a></li>
                            <li><a class="hover:text-primary transition-colors" href="#peta">Peta Usaha</a></li>
                            <li><a class="hover:text-primary transition-colors" href="#">Cek Status Izin</a></li>
                            <li><a class="hover:text-primary transition-colors" href="#stats">Statistik Wilayah</a></li>
                            <li><a class="hover:text-primary transition-colors" href="#">Login Admin</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-6">Jam Operasional</h4>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li class="flex justify-between border-b border-gray-800 pb-2">
                                <span>Senin - Kamis</span>
                                <span>08.00 - 16.00</span>
                            </li>
                            <li class="flex justify-between border-b border-gray-800 pb-2">
                                <span>Jumat</span>
                                <span>08.00 - 16.30</span>
                            </li>
                            <li class="flex justify-between pt-2">
                                <span>Sabtu - Minggu</span>
                                <span class="text-red-400">Tutup</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-gray-500">© {{ date('Y') }} Kecamatan Kertapati. All rights reserved.</p>
                    <div class="flex gap-6 text-sm text-gray-500">
                        <a class="hover:text-white" href="#">Kebijakan Privasi</a>
                        <a class="hover:text-white" href="#">Syarat & Ketentuan</a>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <!-- ✅ Leaflet JS (no space!) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi peta
            const map = L.map('kertapati-map', {
                zoomControl: false
            }).setView([-2.9761, 104.7758], 13);

            // Tambahkan zoom control di pojok kanan atas
            L.control.zoom({ position: 'topright' }).addTo(map);

            // Tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Data dari Laravel
            const usahas = @json($usahas);

            // Helper
            function getIconForCategory(cat) {
                const n = cat.toLowerCase();
                if (n.includes('kuliner') || n.includes('makan')) return { icon: 'restaurant', color: '#ef4444' };
                if (n.includes('dagang') || n.includes('toko')) return { icon: 'shopping_bag', color: '#3b82f6' };
                if (n.includes('jasa')) return { icon: 'build', color: '#eab308' };
                if (n.includes('umkm') || n.includes('industri')) return { icon: 'storefront', color: '#22c55e' };
                return { icon: 'store', color: '#6b7280' };
            }

            // Tambahkan marker
            usahas.forEach(biz => {
                const { icon, color } = getIconForCategory(biz.kategori);

                const iconHtml = `
                    <div style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;position:relative;">
                        <div style="
                            width:32px;height:32px;border-radius:50%;
                            background:${color};
                            border:2px solid white;
                            box-shadow:0 2px 6px rgba(0,0,0,0.3);
                            display:flex;align-items:center;justify-content:center;
                            transition:transform 0.2s;
                        " class="marker-dot">
                            <span class="material-symbols-outlined" style="font-size:16px;color:white;">${icon}</span>
                        </div>
                        <div style="
                            position:absolute;bottom:-4px;left:50%;transform:translateX(-50%);
                            width:8px;height:4px;background:black;border-radius:2px;opacity:0.2;
                        "></div>
                    </div>
                `;

                const customIcon = L.divIcon({
                    className: 'custom-marker',
                    html: iconHtml,
                    iconSize: [40, 44],
                    iconAnchor: [20, 40],
                    popupAnchor: [0, -40]
                });

                const marker = L.marker([biz.latitude, biz.longitude], { icon: customIcon }).addTo(map);

                marker.bindPopup(`
                    <div class="max-w-xs">
                        <strong class="text-blue-600 dark:text-blue-400">${biz.nama_usaha}</strong><br>
                        <small class="text-gray-500">${biz.kategori}</small><br>
                        <small class="text-gray-600 dark:text-gray-400">${biz.kelurahan}</small>
                    </div>
                `, { className: 'leaflet-popup-custom' });
            });

            // Jika tidak ada data → tampilkan pesan
            if (usahas.length === 0) {
                const center = L.marker([-2.9761, 104.7758], {
                    icon: L.divIcon({
                        className: 'empty-marker',
                        html: '<div class="text-center text-gray-500 text-sm">Belum ada usaha yang disetujui.</div>',
                        iconSize: [200, 40]
                    })
                }).addTo(map);
                center.bindPopup("Saat ini belum ada data usaha yang ditampilkan di peta.").openPopup();
            }
        });
    </script>
</body>
</html>