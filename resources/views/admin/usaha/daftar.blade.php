@extends('layouts.app')

@section('title', 'Usaha Terdaftar')

@section('content')
<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-6">
    <form action="{{ route('admin.usaha.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
        
        <!-- Filter Status -->
        <div class="md:col-span-3">
            <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
            <select name="status" id="status" class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                <option value="menunggu" {{ request('status', 'menunggu') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <!-- Filter Kategori -->
        <div class="md:col-span-3">
            <label for="kategori" class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
            <select name="kategori" id="kategori" class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter Kelurahan -->
        <div class="md:col-span-3">
            <label for="kelurahan" class="block text-sm font-medium text-slate-700 mb-2">Kelurahan</label>
            <select name="kelurahan" id="kelurahan" class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                <option value="">Semua Kelurahan</option>
                @foreach($kelurahans as $kelurahan)
                    <option value="{{ $kelurahan->id }}" {{ request('kelurahan') == $kelurahan->id ? 'selected' : '' }}>
                        {{ $kelurahan->nama_kelurahan }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Buttons -->
        <div class="md:col-span-3 flex gap-2">
            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center justify-center gap-2">
                <i class="bi bi-search"></i> Filter
            </button>
            <a href="{{ route('admin.usaha.index') }}" class="px-4 py-2 border border-slate-300 text-slate-700 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Usaha List -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Nama Usaha
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Pemohon
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Kategori
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Kelurahan
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($usahas as $usaha)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium text-slate-900">{{ $usaha->nama_usaha }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $usaha->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                {{ $usaha->kategori->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $usaha->kelurahan->nama_kelurahan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @php
                                // Logika sederhana untuk memetakan warna badge
                                $statusClass = '';
                                switch($usaha->status) {
                                    case 'menunggu':
                                        $statusClass = 'bg-amber-100 text-amber-800';
                                        break;
                                    case 'disetujui':
                                        $statusClass = 'bg-emerald-100 text-emerald-800';
                                        break;
                                    case 'ditolak':
                                        $statusClass = 'bg-red-100 text-red-800';
                                        break;
                                    default:
                                        $statusClass = 'bg-slate-100 text-slate-800';
                                }
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                {{ $usaha->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $usaha->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.usaha.show', $usaha) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <i class="bi bi-eye mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-slate-50 p-4 rounded-full mb-3">
                                    <i class="bi bi-inbox text-3xl text-slate-400"></i>
                                </div>
                                <span class="text-slate-500 font-medium">Tidak ada data usaha ditemukan</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($usahas->hasPages())
        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4 flex items-center justify-between">
            <div class="text-sm text-slate-600">
                Menampilkan {{ $usahas->firstItem() }} sampai {{ $usahas->lastItem() }} dari {{ $usahas->total() }} data
            </div>
            {{ $usahas->links() }}
        </div>
    @endif
</div>

<!-- CSS Tambahan untuk Pagination Laravel agar terlihat seperti Tailwind -->
<style>
    /* Mengubah tampilan default pagination Laravel */
    .pagination {
        @apply flex items-center gap-1;
    }
    .pagination li {
        @apply list-none;
    }
    .pagination li a, .pagination li span {
        @apply relative block rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 transition-all hover:bg-white hover:text-indigo-600 hover:shadow-sm border border-transparent hover:border-slate-200;
    }
    .pagination li.active span {
        @apply z-10 bg-indigo-600 text-white border-indigo-600 shadow-md;
    }
    .pagination li.disabled span {
        @apply opacity-50 cursor-not-allowed hover:bg-transparent hover:text-slate-600 hover:shadow-none;
    }
</style>
@endsection