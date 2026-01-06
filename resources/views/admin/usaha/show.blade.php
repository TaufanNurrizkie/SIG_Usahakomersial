@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@php
    // Helper untuk warna badge status
    $statusBadgeClass = '';
    switch ($usaha->status) {
        case 'menunggu':
            $statusBadgeClass = 'bg-amber-100 text-amber-800 border-amber-200';
            break;
        case 'disetujui':
            $statusBadgeClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
            break;
        case 'ditolak':
            $statusBadgeClass = 'bg-red-100 text-red-800 border-red-200';
            break;
        default:
            $statusBadgeClass = 'bg-slate-100 text-slate-800 border-slate-200';
    }
@endphp

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Kolom Kiri (Konten Utama) - Span 8 -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Informasi Usaha -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-shop text-indigo-500"></i> Informasi Usaha
                    </h3>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusBadgeClass }}">
                        {{ $usaha->status_label }}
                    </span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Usaha -->
                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Usaha</label>
                            <p class="text-lg font-bold text-slate-900 mt-1">{{ $usaha->nama_usaha }}</p>
                        </div>

                        <!-- Pemohon -->
                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pemohon</label>
                            <p class="text-slate-700 mt-1">{{ $usaha->user->name }} <span
                                    class="text-slate-400 text-sm">({{ $usaha->user->email }})</span></p>
                        </div>

                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Deskripsi
                            </label>
                            <p class="text-slate-700 mt-1 break-words whitespace-pre-line">
                                {{ $usaha->deskripsi }}
                            </p>
                        </div>


                        <!-- Alamat -->
                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Alamat</label>
                            <p class="text-slate-700 mt-1">{{ $usaha->alamat }}</p>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</label>
                            <div class="mt-1">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $usaha->kategori->nama_kategori }}
                                </span>
                            </div>
                        </div>

                        <!-- Kelurahan -->
                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelurahan</label>
                            <p class="text-slate-700 mt-1">{{ $usaha->kelurahan->nama_kelurahan }}</p>
                        </div>

                        <!-- Koordinat -->
                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Koordinat</label>
                            <p class="text-slate-700 font-mono text-sm mt-1">{{ $usaha->latitude }},
                                {{ $usaha->longitude }}</p>
                        </div>

                        <!-- Tanggal -->
                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal
                                Pengajuan</label>
                            <p class="text-slate-700 mt-1">{{ $usaha->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Catatan Penolakan Alert -->
                    @if ($usaha->catatan_penolakan)
                        <div class="mt-6 flex items-start gap-3 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                            <i class="bi bi-exclamation-circle-fill text-red-500 text-xl mt-0.5"></i>
                            <div>
                                <h4 class="text-sm font-bold text-red-800">Catatan Penolakan:</h4>
                                <p class="text-sm text-red-700 mt-1">{{ $usaha->catatan_penolakan }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Peta Lokasi -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-geo-alt text-indigo-500"></i> Lokasi Usaha
                    </h3>
                </div>
                <div class="p-0 relative">
                    <div id="map" class="w-full h-[300px] z-0"></div>
                </div>
            </div>

            <!-- Dokumen Pendukung -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-file-earmark text-indigo-500"></i> Dokumen Pendukung
                    </h3>
                </div>
                <div class="p-6">
                    @if ($usaha->dokumens->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach ($usaha->dokumens as $dokumen)
                                <div
                                    class="border border-slate-200 rounded-xl p-4 text-center hover:border-indigo-300 hover:shadow-md transition-all group">
                                    <div
                                        class="w-12 h-12 mx-auto bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center mb-3 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                        <i class="bi bi-file-earmark-text text-2xl"></i>
                                    </div>
                                    <p class="text-sm font-medium text-slate-800 truncate mb-2"
                                        title="{{ $dokumen->jenis_label }}">{{ $dokumen->jenis_label }}</p>
                                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank"
                                        class="inline-flex items-center text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                        <i class="bi bi-download mr-1"></i> Lihat Dokumen
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="bi bi-file-earmark-x text-4xl text-slate-300 mb-2 d-block"></i>
                            <p class="text-slate-500 text-sm">Tidak ada dokumen yang diunggah</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Kolom Kanan (Sidebar Aksi) - Span 4 -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Foto Usaha -->
            @if ($usaha->foto_usaha)
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                            <i class="bi bi-image text-indigo-500"></i> Foto Usaha
                        </h3>
                    </div>
                    <div class="p-0">
                        <img src="{{ asset('storage/' . $usaha->foto_usaha) }}" class="w-full h-auto object-cover"
                            alt="Foto Usaha">
                    </div>
                </div>
            @endif

            <!-- Aksi: Setujui & Tolak (Hanya jika status menunggu) -->
            @if ($usaha->status === 'menunggu_admin')
                <!-- Form Setujui -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 bg-emerald-600 border-b border-emerald-700">
                        <h3 class="font-semibold text-white flex items-center gap-2">
                            <i class="bi bi-check-circle"></i> Setujui Pengajuan
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-slate-500 mb-4">Pengajuan akan diverifikasi dan diteruskan ke Camat untuk
                            persetujuan akhir.</p>
                        <form action="{{ route('admin.usaha.approve', $usaha) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 rounded-lg transition-colors shadow-sm shadow-emerald-200">
                                <i class="bi bi-check-lg"></i> Setujui Usaha
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Form Tolak -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 bg-red-600 border-b border-red-700">
                        <h3 class="font-semibold text-white flex items-center gap-2">
                            <i class="bi bi-x-circle"></i> Tolak Pengajuan
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.usaha.reject', $usaha) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="catatan_penolakan" class="block text-sm font-medium text-slate-700 mb-2">Catatan
                                    Penolakan <span class="text-red-500">*</span></label>
                                <textarea name="catatan_penolakan" id="catatan_penolakan" rows="3" required
                                    class="w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm p-2.5"
                                    placeholder="Tuliskan alasan penolakan..."></textarea>
                            </div>
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 rounded-lg transition-colors shadow-sm shadow-red-200">
                                <i class="bi bi-x-lg"></i> Tolak Usaha
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Surat Izin (Jika sudah disetujui) -->
            @if ($usaha->surat_izin)
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                            <i class="bi bi-file-pdf text-red-500"></i> Surat Izin
                        </h3>
                    </div>
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-3">
                            <i class="bi bi-file-pdf text-3xl text-red-500"></i>
                        </div>
                        <p class="text-sm text-slate-600 mb-4">Surat izin resmi telah diterbitkan.</p>
                        <a href="{{ asset('storage/' . $usaha->surat_izin) }}" target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2 border border-red-200 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg text-sm font-medium transition-colors">
                            <i class="bi bi-download"></i> Download Surat
                        </a>
                    </div>
                </div>
            @endif

            <!-- Tombol Kembali -->
            <a href="{{ route('admin.usaha.index') }}"
                class="block w-full text-center border border-slate-300 text-slate-600 hover:bg-slate-50 hover:text-slate-800 font-medium py-3 rounded-xl transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Pastikan z-index peta benar
        const mapContainer = document.getElementById('map');
        if (mapContainer) {
            mapContainer.style.zIndex = "0";
        }

        const map = L.map('map').setView([{{ $usaha->latitude }}, {{ $usaha->longitude }}], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([{{ $usaha->latitude }}, {{ $usaha->longitude }}])
            .addTo(map)
            .bindPopup('<div style="font-family: sans-serif;"><strong>{{ $usaha->nama_usaha }}</strong></div>')
            .openPopup();
    </script>
@endpush
