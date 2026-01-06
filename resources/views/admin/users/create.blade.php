@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="bi bi-person-plus text-indigo-600"></i> Tambah User Baru
            </h3>
        </div>

        <!-- Body -->
        <div class="p-6 sm:p-8">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-600">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                            class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-4 py-2.5 text-base @error('name') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" 
                            required>
                        @error('name')
                            <p class="mt-2 text-sm font-semibold text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email <span class="text-red-600">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com"
                            class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-4 py-2.5 text-base @error('email') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" 
                            required>
                        @error('email')
                            <p class="mt-2 text-sm font-semibold text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password <span class="text-red-600">*</span></label>
                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter"
                            class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-4 py-2.5 text-base @error('password') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" 
                            required>
                        @error('password')
                            <p class="mt-2 text-sm font-semibold text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password <span class="text-red-600">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password"
                            class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-4 py-2.5 text-base" 
                            required>
                    </div>
                    
                    <!-- Role -->
                    <div class="md:col-span-2">
                        <label for="role" class="block text-sm font-bold text-gray-700 mb-2">Role Pengguna <span class="text-red-600">*</span></label>
                        <select id="role" name="role" 
                            class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-4 py-2.5 text-base @error('role') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" 
                            required>
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-2 text-sm font-semibold text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <!-- Divider -->
                <div class="border-t border-gray-200 my-8"></div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <a href="{{ route('admin.users.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 border border-gray-300 text-sm font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:text-gray-900 focus:outline-none transition-colors">
                        <i class="bi bi-arrow-left mr-2"></i> Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-2.5 border border-transparent text-sm font-bold rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-[1.02]">
                        <i class="bi bi-save mr-2"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection