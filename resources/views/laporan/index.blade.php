@extends('layouts.app')

@section('title', 'Laporan Usaha')

@section('content')
<!-- Stats Section -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <!-- Card 1: Total Laporan -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start justify-between transition-transform hover:-translate-y-1">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Laporan</p>
            <div class="text-3xl font-bold text-indigo-600">{{ $stats['total'] }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-collection"></i>
        </div>
    </div>
    
    <!-- Card 2: Menunggu -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start justify-between transition-transform hover:-translate-y-1">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Menunggu</p>
            <div class="text-3xl font-bold text-amber-500">{{ $stats['menunggu_camat'] }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-hourglass-split"></i>
        </div>
    </div>
    
    <!-- Card 3: Disetujui -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start justify-between transition-transform hover:-translate-y-1">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Disetujui</p>
            <div class="text-3xl font-bold text-emerald-500">{{ $stats['disetujui'] }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-check-circle"></i>
        </div>
    </div>
    
    <!-- Card 4: Ditolak -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start justify-between transition-transform hover:-translate-y-1">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Ditolak</p>
            <div class="text-3xl font-bold text-red-500">{{ $stats['ditolak_camat'] }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-red-50 text-red-500 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-x-circle"></i>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="p-5 border-b border-gray-100 bg-gray-50">
        <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2">
            <i class="bi bi-funnel-fill text-indigo-500"></i> Filter Laporan
        </h3>
    </div>
    <div class="p-6">
        <form id="filter-form" action="{{ request()->url() }}" method="GET" class="space-y-4">
            
            <!-- Baris 1: Dropdowns & Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status</label>
                    <select name="status" class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-3 py-2 text-sm">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="menunggu_camat" {{ request('status') == 'menunggu_camat' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui_camat" {{ request('status') == 'disetujui_camat' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak_camat" {{ request('status') == 'ditolak_camat' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kategori</label>
                    <select name="kategori" class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-3 py-2 text-sm">
                        <option value="">Semua</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kelurahan</label>
                    <select name="kelurahan" class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-3 py-2 text-sm">
                        <option value="">Semua</option>
                        @foreach($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ request('kelurahan') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Dari Tanggal</label>
                    <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-3 py-2 text-sm">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Sampai Tanggal</label>
                    <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-3 py-2 text-sm">
                </div>
            </div>

            <!-- Baris 2: Tombol Aksi -->
            <div class="flex justify-end items-center gap-3 pt-2 border-t border-gray-100 mt-2">
                <a href="{{ route(request()->route()->getName()) }}" class="px-4 py-2 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-lg text-xs font-bold uppercase tracking-wide transition-colors flex items-center gap-2">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition-colors shadow-sm shadow-indigo-200 flex items-center gap-2">
                    <i class="bi bi-search"></i> Filter Data
                </button>
                <a href="{{ route(request()->route()->getName() == 'admin.laporan.index' ? 'admin.laporan.export-pdf' : 'camat.laporan.export-pdf', request()->query()) }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition-colors shadow-sm shadow-red-200 flex items-center gap-2 ml-2">
                    <i class="bi bi-file-earmark-pdf"></i> Download PDF
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 font-bold bg-gray-50 text-center">#</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Nama Usaha</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Pemohon</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Kategori</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Kelurahan</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Status</th>
                    <th class="px-6 py-4 font-bold bg-gray-50 text-right">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usahas as $index => $usaha)
                    <tr class="bg-white border-b border-gray-100 hover:bg-indigo-50/30 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs text-gray-400 text-center">{{ $usahas->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $usaha->nama_usaha }}</td>
                        <td class="px-6 py-4">{{ $usaha->user->name }}</td>
                        <td class="px-6 py-4">{{ $usaha->kategori->nama_kategori }}</td>
                        <td class="px-6 py-4">{{ $usaha->kelurahan->nama_kelurahan }}</td>
                        <td class="px-6 py-4">
                            @php
                                // Mapping warna status
                                $statusMap = [
                                    'primary'   => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'warning'   => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'info'      => 'bg-cyan-100 text-cyan-800 border-cyan-200',
                                    'success'   => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'danger'    => 'bg-red-100 text-red-800 border-red-200',
                                    'secondary' => 'bg-gray-100 text-gray-800 border-gray-200',
                                ];
                                $badgeClass = $statusMap[$usaha->status_color] ?? $statusMap['secondary'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                {{ $usaha->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-mono text-xs">{{ $usaha->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr class="bg-white border-b border-gray-100">
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="bi bi-inbox text-4xl mb-3 opacity-50"></i>
                                <span class="font-medium">Tidak ada data laporan ditemukan</span>
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
        @apply relative block rounded-lg px-3 py-1.5 text-xs font-bold text-gray-600 transition-all hover:bg-white hover:text-indigo-600 hover:shadow-sm border border-transparent hover:border-gray-200;
    }
    .pagination li.active span {
        @apply z-10 bg-indigo-600 text-white border-indigo-600 shadow-md hover:text-white hover:bg-indigo-600;
    }
    .pagination li.disabled span {
        @apply opacity-50 cursor-not-allowed hover:bg-transparent hover:text-gray-600 hover:shadow-none;
    }
</style>
@endsection