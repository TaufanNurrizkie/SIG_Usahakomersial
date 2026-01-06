@extends('layouts.app')

@section('title', 'Edit Kategori Usaha')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.kategori.index') }}" class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:text-indigo-600 hover:border-indigo-600 transition-all shadow-sm">
            <i class="bi bi-arrow-left text-lg"></i>
        </a>
        <h2 class="text-xl font-bold text-slate-800">Edit Kategori Usaha</h2>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 max-w-2xl">
    <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label for="nama_kategori" class="block text-sm font-medium text-slate-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('nama_kategori') border-red-500 @enderror" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
            @error('nama_kategori')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.kategori.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 text-sm font-medium transition-colors">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-all">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
