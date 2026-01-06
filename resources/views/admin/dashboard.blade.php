@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Stats Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <!-- Card 1: Total Usaha -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start justify-between transition-transform hover:-translate-y-1">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Usaha</p>
            <div class="text-3xl font-bold text-indigo-600">{{ $totalUsaha }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-shop"></i>
        </div>
    </div>
    
    <!-- Card 2: Menunggu Verifikasi -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start justify-between transition-transform hover:-translate-y-1">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Menunggu Verifikasi</p>
            <div class="text-3xl font-bold text-amber-500">{{ $usahaMenunggu }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-hourglass-split"></i>
        </div>
    </div>
    
    <!-- Card 3: Disetujui -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start justify-between transition-transform hover:-translate-y-1">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Disetujui</p>
            <div class="text-3xl font-bold text-emerald-500">{{ $usahaDiverifikasi }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-check-circle"></i>
        </div>
    </div>
    
    <!-- Card 4: Total Users -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start justify-between transition-transform hover:-translate-y-1">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Users</p>
            <div class="text-3xl font-bold text-sky-500">{{ $totalUsers }}</div>
        </div>
        <div class="w-12 h-12 rounded-lg bg-sky-50 text-sky-500 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-people"></i>
        </div>
    </div>
</div>

<!-- Middle Section: Chart & Status Summary -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <!-- Chart (Mengambil 2/3 kolom di layar besar) -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-100 flex flex-col">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h6 class="font-semibold text-slate-800 flex items-center gap-2">
                <i class="bi bi-bar-chart text-indigo-500"></i> Usaha per Kategori
            </h6>
        </div>
        <div class="p-6 flex-1 min-h-[300px]">
            <canvas id="kategoriChart"></canvas>
        </div>
    </div>
    
    <!-- Status Summary (Mengambil 1/3 kolom di layar besar) -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 flex flex-col">
        <div class="p-6 border-b border-slate-100">
            <h6 class="font-semibold text-slate-800 flex items-center gap-2">
                <i class="bi bi-pie-chart text-indigo-500"></i> Status Usaha
            </h6>
        </div>
        <div class="p-6 flex-1">
            <div class="flex justify-between items-center py-3 border-b border-slate-50">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                    <span class="text-sm text-slate-600">Menunggu</span>
                </div>
                <strong class="text-slate-800">{{ $usahaMenunggu }}</strong>
            </div>
            <div class="flex justify-between items-center py-3 border-b border-slate-50">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span class="text-sm text-slate-600">Disetujui</span>
                </div>
                <strong class="text-slate-800">{{ $usahaDiverifikasi }}</strong>
            </div>
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="text-sm text-slate-600">Ditolak</span>
                </div>
                <strong class="text-slate-800">{{ $usahaDitolak }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Recent Submissions Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h6 class="font-semibold text-slate-800 flex items-center gap-2">
            <i class="bi bi-clock-history text-indigo-500"></i> Pengajuan Terbaru
        </h6>
        <a href="{{ route('admin.usaha.index') }}" class="text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
            Lihat Semua
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                <tr>
                    <th class="px-6 py-4">Nama Usaha</th>
                    <th class="px-6 py-4">Pemohon</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Kelurahan</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pengajuanTerbaru as $usaha)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $usaha->nama_usaha }}</td>
                        <td class="px-6 py-4">{{ $usaha->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                {{ $usaha->kategori->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $usaha->kelurahan->nama_kelurahan }}</td>
                        <td class="px-6 py-4">{{ $usaha->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.usaha.show', $usaha) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="bi bi-inbox text-4xl mb-3 opacity-50"></i>
                                <span>Tidak ada pengajuan baru</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('kategoriChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($kategoriLabels) !!},
            datasets: [{
                label: 'Jumlah Usaha',
                data: {!! json_encode($kategoriData) !!},
                backgroundColor: [
                    'rgba(231, 76, 60, 0.8)',
                    'rgba(52, 152, 219, 0.8)',
                    'rgba(46, 204, 113, 0.8)',
                    'rgba(155, 89, 182, 0.8)',
                    'rgba(233, 30, 99, 0.8)',
                    'rgba(255, 152, 0, 0.8)',
                    'rgba(0, 188, 212, 0.8)',
                    'rgba(121, 85, 72, 0.8)',
                ],
                borderRadius: 8,
                borderSkipped: false, // Supaya sudut bawah juga rounded
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { family: "'Segoe UI', sans-serif" },
                    bodyFont: { family: "'Segoe UI', sans-serif" }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1,
                        color: '#64748b',
                        font: { family: "'Segoe UI', sans-serif" }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: { family: "'Segoe UI', sans-serif" }
                    }
                }
            }
        }
    });
</script>
@endpush