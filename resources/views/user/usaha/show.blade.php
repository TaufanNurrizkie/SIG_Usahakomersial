@extends('layouts.app')

@section('title', 'Detail Usaha')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
    <div class="lg:col-span-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
            <div class="px-4 py-3 bg-white border-b border-gray-200 flex justify-between items-center">
                <span class="flex items-center"><i class="bi bi-shop me-2"></i>{{ $usaha->nama_usaha }}</span>
                <?php
                    $statusClasses = [
                        'primary' => 'bg-blue-100 text-blue-800',
                        'warning' => 'bg-yellow-100 text-yellow-800',
                        'info' => 'bg-cyan-100 text-cyan-800',
                        'success' => 'bg-green-100 text-green-800',
                        'danger' => 'bg-red-100 text-red-800',
                        'secondary' => 'bg-gray-100 text-gray-800',
                    ];
                    $bgClass = $statusClasses[$usaha->status_color] ?? $statusClasses['secondary'];
                ?>
                <span class="{{ $bgClass }} text-xs font-medium px-2.5 py-0.5 rounded">{{ $usaha->status_label }}</span>
            </div>
            <div class="p-4 bg-white">
                @if($usaha->catatan_penolakan)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3">
                        <strong><i class="bi bi-exclamation-circle me-2"></i>Catatan Penolakan:</strong>
                        <p class="mb-0 mt-1">{{ $usaha->catatan_penolakan }}</p>
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-500 text-xs text-muted small">Kategori</label>
                        <p class="mb-0 text-gray-900"><span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $usaha->kategori->nama_kategori }}</span></p>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs text-muted small">Kelurahan</label>
                        <p class="mb-0 text-gray-900">{{ $usaha->kelurahan->nama_kelurahan }}</p>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs text-muted small">Koordinat</label>
                        <p class="mb-0 text-gray-900">{{ $usaha->latitude }}, {{ $usaha->longitude }}</p>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs text-muted small">Tanggal Pengajuan</label>
                        <p class="mb-0 text-gray-900">{{ $usaha->created_at->format('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
            <div class="px-4 py-3 bg-white border-b border-gray-200 flex items-center">
                <i class="bi bi-geo-alt me-2"></i>Lokasi
            </div>
            <div class="p-0 bg-white">
                <div id="map" style="height: 300px;"></div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-4 py-3 bg-white border-b border-gray-200 flex items-center">
                <i class="bi bi-file-earmark me-2"></i>Dokumen
            </div>
            <div class="p-4 bg-white">
                @if($usaha->dokumens->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($usaha->dokumens as $dokumen)
                            <div class="border border-gray-200 rounded p-3 text-center">
                                <i class="bi bi-file-earmark-text text-4xl text-blue-600 block mb-2"></i>
                                <p class="mb-1 text-sm text-gray-700">{{ $dokumen->jenis_label }}</p>
                                <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="inline-flex items-center px-2.5 py-1.5 border border-blue-600 text-xs font-medium rounded text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="bi bi-download me-1"></i>Lihat
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 mb-0 text-center">Tidak ada dokumen</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-4">
        @if($usaha->foto_usaha)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="px-4 py-3 bg-white border-b border-gray-200 flex items-center">
                    <i class="bi bi-image me-2"></i>Foto Usaha
                </div>
                <div class="p-0 bg-white">
                    <img src="{{ asset('storage/' . $usaha->foto_usaha) }}" class="w-full h-auto rounded-b-lg" alt="Foto">
                </div>
            </div>
        @endif
        
        @if($usaha->surat_izin)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="px-4 py-3 bg-green-600 text-white border-b border-green-700 flex items-center">
                    <i class="bi bi-file-pdf me-2"></i>Surat Izin
                </div>
                <div class="p-4 bg-white text-center">
                    <i class="bi bi-file-pdf text-4xl text-red-600 block mb-2"></i>
                    <a href="{{ asset('storage/' . $usaha->surat_izin) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="bi bi-download me-1"></i>Download Surat Izin
                    </a>
                </div>
            </div>
        @endif
        
        <div class="grid grid-cols-1 gap-2">
            @if(in_array($usaha->status, ['menunggu', 'ditolak']))
                <a href="{{ route('user.usaha.edit', $usaha) }}" class="inline-flex justify-center items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="bi bi-pencil me-2"></i>Edit Usaha
                </a>
            @endif
            <a href="{{ route('user.usaha.index') }}" class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const map = L.map('map').setView([{{ $usaha->latitude }}, {{ $usaha->longitude }}], 16);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    L.marker([{{ $usaha->latitude }}, {{ $usaha->longitude }}])
        .addTo(map)
        .bindPopup('<strong>{{ $usaha->nama_usaha }}</strong>')
        .openPopup();
</script>
@endpush
