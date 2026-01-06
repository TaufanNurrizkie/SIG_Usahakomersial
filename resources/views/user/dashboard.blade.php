@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-500 text-sm mb-1">Total Usaha</p>
                <div class="text-2xl font-bold text-blue-600">{{ $totalUsaha }}</div>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                <i class="bi bi-shop text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-500 text-sm mb-1">Menunggu Verifikasi</p>
                <div class="text-2xl font-bold text-yellow-600">{{ $usahaMenunggu }}</div>
            </div>
            <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg">
                <i class="bi bi-hourglass-split text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-500 text-sm mb-1">Disetujui</p>
                <div class="text-2xl font-bold text-green-600">{{ $usahaDisetujui }}</div>
            </div>
            <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                <i class="bi bi-check-circle text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-500 text-sm mb-1">Ditolak</p>
                <div class="text-2xl font-bold text-red-600">{{ $usahaDitolak }}</div>
            </div>
            <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                <i class="bi bi-x-circle text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 gap-4 mb-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 bg-white">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('user.usaha.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="bi bi-plus-circle me-2"></i>Ajukan Usaha Baru
                </a>
                <a href="{{ route('user.usaha.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-blue-600 rounded-md font-semibold text-xs text-blue-600 uppercase tracking-widest hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="bi bi-shop me-2"></i>Lihat Usaha Saya
                </a>
                <a href="{{ route('peta') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="bi bi-map me-2"></i>Lihat Peta Usaha
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Submissions -->
<div class="grid grid-cols-1 gap-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="px-4 py-3 bg-white border-b border-gray-200 flex justify-between items-center">
            <span class="flex items-center"><i class="bi bi-clock-history me-2"></i>Usaha Terbaru Saya</span>
            <a href="{{ route('user.usaha.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
        </div>
        <div class="p-0 bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">Nama Usaha</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Kelurahan</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usahaTerbaru as $usaha)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $usaha->nama_usaha }}</td>
                                <td class="px-6 py-4"><span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $usaha->kategori->nama_kategori }}</span></td>
                                <td class="px-6 py-4">{{ $usaha->kelurahan->nama_kelurahan }}</td>
                                <td class="px-6 py-4">
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
                                    <span class="{{ $bgClass }} text-xs font-medium px-2.5 py-0.5 rounded">
                                        {{ $usaha->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $usaha->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('user.usaha.show', $usaha) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <i class="bi bi-inbox text-4xl block mb-2 text-gray-300"></i>
                                    Anda belum memiliki usaha
                                    <br>
                                    <a href="{{ route('user.usaha.create') }}" class="inline-flex items-center px-4 py-2 mt-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <i class="bi bi-plus-circle me-2"></i>Ajukan Usaha Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
