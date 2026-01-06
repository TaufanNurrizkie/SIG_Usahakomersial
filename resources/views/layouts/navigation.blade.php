{{-- Navigation menu based on user role --}}

@auth
    @if(auth()->user()->hasRole('admin'))
        {{-- Admin Panel Header --}}
        <div class="px-4 py-2 mt-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
            Admin Panel
        </div>
        
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('admin.dashboard') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-speedometer2 text-lg"></i>
            <span>Dashboard</span>
        </a>
        
        {{-- Pengajuan Usaha --}}
        <a href="{{ route('admin.usaha.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('admin.usaha.*') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-shop text-lg"></i>
            <span>Pengajuan Usaha</span>
        </a>
        
        {{-- Kelola User --}}
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('admin.users.*') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-people text-lg"></i>
            <span>Kelola User</span>
        </a>
        
        {{-- Master Data --}}
        <div class="px-4 py-2 mt-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
            Master Data
        </div>

        <a href="{{ route('admin.kelurahan.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('admin.kelurahan.*') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-geo-alt text-lg"></i>
            <span>Kelurahan</span>
        </a>

        <a href="{{ route('admin.kategori.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('admin.kategori.*') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-tags text-lg"></i>
            <span>Kategori Usaha</span>
        </a>
        
        {{-- Laporan --}}
        <a href="{{ route('admin.laporan.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('admin.laporan.*') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-file-earmark-text text-lg"></i>
            <span>Laporan</span>
        </a>
    @endif
    
    @if(auth()->user()->hasRole('operator'))
        {{-- Operator Panel Header --}}
        <div class="px-4 py-2 mt-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
            Operator Panel
        </div>
        
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('admin.dashboard') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-speedometer2 text-lg"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('admin.usaha.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('admin.usaha.*') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-shop text-lg"></i>
            <span>Pengajuan Usaha</span>
        </a>
        
        <a href="{{ route('admin.laporan.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('admin.laporan.*') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-file-earmark-text text-lg"></i>
            <span>Laporan</span>
        </a>
    @endif
    
    @if(auth()->user()->hasRole('camat'))
        {{-- Camat Panel Header --}}
        <div class="px-4 py-2 mt-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
            Camat Panel
        </div>
        
        <a href="{{ route('camat.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('camat.dashboard') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-speedometer2 text-lg"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('camat.usaha.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('camat.usaha.index') || request()->routeIs('camat.usaha.show') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-clipboard-check text-lg"></i>
            <span>Persetujuan Usaha</span>
        </a>
        
        <a href="{{ route('camat.usaha.riwayat') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('camat.usaha.riwayat') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-clock-history text-lg"></i>
            <span>Riwayat Izin</span>
    </a>
    @endif
    
    @if(auth()->user()->hasRole('user'))
        {{-- User Panel Header --}}
        <div class="px-4 py-2 mt-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
            Menu Usaha
        </div>
        
        <a href="{{ route('user.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('user.dashboard') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-speedometer2 text-lg"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('user.usaha.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('user.usaha.index') || request()->routeIs('user.usaha.show') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-shop text-lg"></i>
            <span>Usaha Saya</span>
        </a>
        
        <a href="{{ route('user.usaha.create') }}" 
           class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-sidebar-hover border-l-4 border-transparent hover:border-indigo-500 transition-all rounded-r-lg {{ request()->routeIs('user.usaha.create') ? 'text-white bg-sidebar-hover border-indigo-500' : '' }}">
            <i class="bi bi-plus-circle text-lg"></i>
            <span>Ajukan Usaha Baru</span>
        </a>
    @endif
@endauth