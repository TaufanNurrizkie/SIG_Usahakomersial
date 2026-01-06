@extends('layouts.app')

@section('title', 'Dashboard Camat')

@section('content')
<!-- Stats Cards -->
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
    <div class="col-span-1">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Izin Diterbitkan</p>
                    <div class="text-3xl font-bold text-green-600">{{ $izinDiterbitkan }}</div>
                </div>
                <div class="p-3 bg-green-100 rounded-full text-green-600">
                    <i class="bi bi-file-earmark-check text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-span-1">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Menunggu Persetujuan</p>
                    <div class="text-3xl font-bold text-yellow-600">{{ $menungguPersetujuan }}</div>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                    <i class="bi bi-hourglass-split text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-span-1">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Total Ditolak</p>
                    <div class="text-3xl font-bold text-red-600">{{ $totalDitolak }}</div>
                </div>
                <div class="p-3 bg-red-100 rounded-full text-red-600">
                    <i class="bi bi-x-circle text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <!-- Pending Approvals -->
    <div class="col-span-1">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-4 py-3 bg-white border-b border-gray-200 flex justify-between items-center">
                <span class="flex items-center"><i class="bi bi-hourglass-split me-2"></i>Menunggu Persetujuan</span>
                <a href="{{ route('camat.usaha.index') }}" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">Lihat Semua</a>
            </div>
            <div class="p-0 bg-white">
                <div class="divide-y divide-gray-200">
                    @forelse($pengajuanMenunggu as $usaha)
                        <a href="{{ route('camat.usaha.show', $usaha) }}" class="block hover:bg-gray-50 transition duration-150 ease-in-out p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-medium text-gray-900 mb-1">{{ $usaha->nama_usaha }}</h6>
                                    <small class="text-gray-500">
                                        {{ $usaha->kategori->nama_kategori }} - {{ $usaha->kelurahan->nama_kelurahan }}
                                    </small>
                                </div>
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Menunggu</span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-4 text-gray-500">
                            <i class="bi bi-check-circle text-4xl block mb-2"></i>
                            Tidak ada pengajuan menunggu
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Permits -->
    <div class="col-span-1">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-4 py-3 bg-white border-b border-gray-200 flex justify-between items-center">
                <span class="flex items-center"><i class="bi bi-file-earmark-check me-2"></i>Izin Terbaru</span>
                <a href="{{ route('camat.usaha.riwayat') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">Lihat Semua</a>
            </div>
            <div class="p-0 bg-white">
                <div class="divide-y divide-gray-200">
                    @forelse($izinTerbaru as $usaha)
                        <a href="{{ route('camat.usaha.show', $usaha) }}" class="block hover:bg-gray-50 transition duration-150 ease-in-out p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-medium text-gray-900 mb-1">{{ $usaha->nama_usaha }}</h6>
                                    <small class="text-gray-500">
                                        {{ $usaha->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Disetujui</span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-4 text-gray-500">
                            <i class="bi bi-inbox text-4xl block mb-2"></i>
                            Belum ada izin diterbitkan
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
