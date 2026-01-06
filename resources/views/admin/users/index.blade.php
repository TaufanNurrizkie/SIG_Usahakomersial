@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <h2 class="text-xl font-bold text-slate-800">Kelola User</h2>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-all">
        <i class="bi bi-plus-circle text-lg"></i>
        <span>Tambah User</span>
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-6">
    <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
        <div class="md:col-span-4">
            <label for="role" class="block text-sm font-medium text-slate-700 mb-2">Filter Role</label>
            <select name="role" id="role" class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-8 flex gap-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
            <a href="{{ route('admin.users.index') }}" class="border border-slate-300 text-slate-600 hover:bg-slate-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Users List -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Bergabung
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-sm font-bold mr-3">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-slate-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @foreach($user->roles as $role)
                                @php
                                    $badgeClass = 'bg-slate-100 text-slate-800'; // Default
                                    if ($role->name === 'admin') {
                                        $badgeClass = 'bg-red-100 text-red-800 border border-red-200';
                                    } elseif ($role->name === 'camat') {
                                        $badgeClass = 'bg-indigo-100 text-indigo-800 border border-indigo-200';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-1.5 text-amber-600 border border-amber-200 rounded-lg hover:bg-amber-50 transition-colors" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                
                                <!-- Delete Form (Only if not self) -->
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="bi bi-inbox text-4xl text-slate-300 mb-3 d-block"></i>
                                <span class="text-slate-500 font-medium">Tidak ada data user ditemukan</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4 flex items-center justify-between">
            <div class="text-sm text-slate-600">
                Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} data
            </div>
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- CSS Tambahan untuk Pagination Laravel agar terlihat seperti Tailwind -->
<style>
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