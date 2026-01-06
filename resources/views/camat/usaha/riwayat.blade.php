@extends('layouts.app')

@section('title', 'Riwayat Izin')

@section('content')
<!-- Header Halaman -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <h2 class="text-xl font-bold text-slate-800">Riwayat Izin</h2>
    <div class="text-sm text-slate-500">
        Daftar usaha yang telah disetujui dan memiliki surat izin
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="p-5 border-b border-gray-100 bg-gray-50">
        <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2">
            <i class="bi bi-funnel-fill text-indigo-500"></i> Filter Riwayat
        </h3>
    </div>
    <div class="p-5">
        <form action="{{ route('camat.usaha.riwayat') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
            
            <!-- Kategori -->
            <div class="md:col-span-4">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kategori</label>
                <select name="kategori" class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-3 py-2 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Kelurahan -->
            <div class="md:col-span-4">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kelurahan</label>
                <select name="kelurahan" class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-3 py-2 text-sm">
                    <option value="">Semua Kelurahan</option>
                    @foreach($kelurahans as $kelurahan)
                        <option value="{{ $kelurahan->id }}" {{ request('kelurahan') == $kelurahan->id ? 'selected' : '' }}>
                            {{ $kelurahan->nama_kelurahan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Aksi -->
            <div class="md:col-span-4 flex items-end gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center justify-center gap-2">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('camat.usaha.riwayat') }}" class="px-4 py-2 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors flex items-center justify-center">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Table Header -->
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
        <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2">
            <i class="bi bi-clock-history text-indigo-500"></i> Daftar Izin Diterbitkan
        </h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 font-bold bg-gray-50">Nama Usaha</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Pemohon</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Kategori</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Kelurahan</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Tanggal Izin</th>
                    <th class="px-6 py-4 font-bold bg-gray-50 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usahas as $usaha)
                    <tr class="bg-white border-b border-gray-100 hover:bg-indigo-50/30 transition-colors">
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $usaha->nama_usaha }}</td>
                        <td class="px-6 py-4">{{ $usaha->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-800 px-2.5 py-0.5 rounded text-xs font-medium border border-gray-200">
                                {{ $usaha->kategori->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $usaha->kelurahan->nama_kelurahan }}</td>
                        <td class="px-6 py-4 font-mono text-xs">{{ $usaha->updated_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            @if($usaha->surat_izin)
                                <a href="{{ asset('storage/' . $usaha->surat_izin) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 rounded-lg text-xs font-bold transition-colors">
                                    <i class="bi bi-file-earmark-pdf"></i> Download PDF
                                </a>
                            @else
                                <span class="text-xs text-gray-400 italic">Tidak ada file</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b border-gray-100">
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="bi bi-inbox text-4xl mb-3 opacity-50"></i>
                                <span class="font-medium">Belum ada riwayat izin diterbitkan</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($usahas->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="text-xs text-gray-500">
                Menampilkan {{ $usahas->firstItem() }} - {{ $usahas->lastItem() }} dari {{ $usahas->total() }}
            </div>
            {{ $usahas->links() }}
        </div>
    @endif
</div>

<!-- CSS Pagination -->
<style>
    .pagination { @apply flex items-center gap-1; }
    .pagination li { @apply list-none; }
    .pagination li a, .pagination li span {
        @apply relative block rounded-lg px-3 py-1.5 text-xs font-medium text-gray-600 transition-all hover:bg-white hover:text-indigo-600 hover:shadow-sm border border-transparent hover:border-gray-200;
    }
    .pagination li.active span {
        @apply z-10 bg-indigo-600 text-white border-indigo-600 shadow-md hover:text-white hover:bg-indigo-600;
    }
    .pagination li.disabled span {
        @apply opacity-50 cursor-not-allowed hover:bg-transparent hover:text-gray-600 hover:shadow-none;
    }
</style>
@endsection