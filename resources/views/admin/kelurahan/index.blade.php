@extends('layouts.app')

@section('title', 'Kelola Kelurahan')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <h2 class="text-xl font-bold text-slate-800">Kelola Kelurahan</h2>
    <a href="{{ route('admin.kelurahan.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-all">
        <i class="bi bi-plus-circle text-lg"></i>
        <span>Tambah Kelurahan</span>
    </a>
</div>

<!-- List -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Nama Kelurahan
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($kelurahans as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium text-slate-900">{{ $item->nama_kelurahan }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.kelurahan.edit', $item) }}" class="p-1.5 text-amber-600 border border-amber-200 rounded-lg hover:bg-amber-50 transition-colors" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                
                                <form action="{{ route('admin.kelurahan.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelurahan ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="bi bi-inbox text-4xl text-slate-300 mb-3 d-block"></i>
                                <span class="text-slate-500 font-medium">Tidak ada data kelurahan ditemukan</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
