@extends('layouts.app')

@section('title', 'Usaha Saya')

@section('content')
<!-- Header Section -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Usaha Saya</h2>
        <p class="text-sm text-slate-500">Kelola dan pantau status pengajuan izin usaha Anda.</p>
    </div>
    <a href="{{ route('user.usaha.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-all">
        <i class="bi bi-plus-circle text-lg"></i>
        <span>Ajukan Usaha Baru</span>
    </a>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 font-bold bg-gray-50">Nama Usaha</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Kategori</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Kelurahan</th>
                    <th class="px-6 py-4 font-bold bg-gray-50">Status</th>
                    <th class="px-6 py-4 font-bold bg-gray-50 text-right">Tanggal</th>
                    <th class="px-6 py-4 font-bold bg-gray-50 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usahas as $usaha)
                    <tr class="bg-white border-b border-gray-100 hover:bg-indigo-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $usaha->nama_usaha }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-slate-100 text-slate-800 px-2.5 py-0.5 rounded-full text-xs font-medium border border-slate-200">
                                {{ $usaha->kategori->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $usaha->kelurahan->nama_kelurahan }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusMap = [
                                    'primary'   => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'warning'   => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'info'      => 'bg-sky-100 text-sky-800 border-sky-200',
                                    'success'   => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'danger'    => 'bg-red-100 text-red-800 border-red-200',
                                    'secondary' => 'bg-slate-100 text-slate-800 border-slate-200',
                                ];
                                $badgeClass = $statusMap[$usaha->status_color] ?? $statusMap['secondary'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                {{ $usaha->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-mono text-xs">{{ $usaha->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Tombol Detail -->
                                <a href="{{ route('user.usaha.show', $usaha) }}" class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition-colors" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <!-- Tombol Edit & Hapus (Hanya jika Menunggu/Ditolak) -->
                                @if(in_array($usaha->status, ['menunggu', 'ditolak']))
                                    <a href="{{ route('user.usaha.edit', $usaha) }}" class="p-2 text-amber-600 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg transition-colors" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('user.usaha.destroy', $usaha) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus usaha ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition-colors" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif

                                <!-- Tombol Download PDF (Jika Sudah Ada Izin) -->
                                @if($usaha->surat_izin)
                                    <a href="{{ asset('storage/' . $usaha->surat_izin) }}" target="_blank" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition-colors" title="Download Surat Izin">
                                        <i class="bi bi-file-pdf"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b border-gray-100">
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-gray-100 p-4 rounded-full mb-4">
                                    <i class="bi bi-inbox text-4xl text-gray-400"></i>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900 mb-2">Anda belum memiliki usaha</h4>
                                <p class="text-sm text-gray-500 mb-6">Mulai ajukan usaha pertama Anda untuk mendapatkan izin resmi.</p>
                                <a href="{{ route('user.usaha.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                                    <i class="bi bi-plus-circle"></i> Ajukan Usaha Pertama
                                </a>
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