@extends('layouts.app')

@section('title', 'Tambah Kelurahan')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.kelurahan.index') }}" class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:text-indigo-600 hover:border-indigo-600 transition-all shadow-sm">
            <i class="bi bi-arrow-left text-lg"></i>
        </a>
        <h2 class="text-xl font-bold text-slate-800">Tambah Kelurahan</h2>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 max-w-2xl">
    <form action="{{ route('admin.kelurahan.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label for="nama_kelurahan" class="block text-sm font-medium text-slate-700 mb-2">Nama Kelurahan <span class="text-red-500">*</span></label>
            <input type="text" name="nama_kelurahan" id="nama_kelurahan" class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('nama_kelurahan') border-red-500 @enderror" value="{{ old('nama_kelurahan') }}" required placeholder="Contoh: Kelurahan Maju Jaya">
            @error('nama_kelurahan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.kelurahan.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-all">Simpan</button>
        </div>
    </form>
</div>
@endsection
