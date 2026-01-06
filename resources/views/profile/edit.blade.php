@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="w-full space-y-8">

    <!-- PROFILE HEADER -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col sm:flex-row sm:items-center gap-6">
        <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
            <i class="bi bi-person-circle text-5xl"></i>
        </div>

        <div>
            <h2 class="text-2xl font-semibold text-slate-800">
                {{ Auth::user()->name }}
            </h2>
            <p class="text-sm text-slate-500">
                {{ Auth::user()->email }}
            </p>
            <span class="inline-block mt-2 text-xs px-3 py-1 rounded-full bg-emerald-100 text-emerald-700">
                Akun Aktif
            </span>
        </div>
    </div>

    <!-- GRID CONTENT -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

        <!-- UPDATE PROFILE -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                <i class="bi bi-person-lines-fill text-indigo-600"></i>
                <h3 class="font-semibold text-slate-800">
                    Informasi Profil
                </h3>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- UPDATE PASSWORD -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                <i class="bi bi-shield-lock-fill text-indigo-600"></i>
                <h3 class="font-semibold text-slate-800">
                    Ubah Password
                </h3>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

    </div>

    <!-- DELETE ACCOUNT FULL WIDTH -->
    <div class="bg-white rounded-2xl shadow-sm border border-red-200">
        <div class="px-6 py-4 border-b border-red-100 flex items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill text-red-600"></i>
            <h3 class="font-semibold text-red-600">
                Zona Berbahaya
            </h3>
        </div>
        <div class="p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>
@endsection
