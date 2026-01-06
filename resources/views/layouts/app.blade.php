<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIG Usaha Komersial') }} - @yield('title', 'Dashboard')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Mengonfigurasi warna Tailwind agar sesuai dengan desain asli (opsional) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#667eea',
                        secondary: '#764ba2',
                        sidebar: '#1e293b',
                        'sidebar-hover': '#334155',
                    }
                }
            }
        }
    </script>

    <!-- Bootstrap Icons (Masih kompatibel dengan Tailwind) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        /* Styles khusus yang sulit dihandle oleh utility classes Tailwind standar */
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        /* Konfigurasi tinggi peta Leaflet */
        #map {
            height: 400px;
            z-index: 1; /* Mencegah peta menutupi dropdown/modal */
        }

        /* Transisi halus untuk scrollbar jika diperlukan */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9; 
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Overlay untuk Mobile Sidebar -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden glass transition-opacity"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-sidebar text-white z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0 shadow-xl flex flex-col">
        <!-- Brand -->
        <div class="p-6 bg-gradient-to-br from-[#667eea] to-[#764ba2] shadow-md shrink-0">
            <h4 class="text-xl font-bold flex items-center gap-2">
                <i class="bi bi-geo-alt-fill"></i> SIG Usaha
            </h4>
            <small class="text-white/80 block mt-1">Kecamatan</small>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4">
            @include('layouts.navigation')
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 min-h-screen flex flex-col transition-all duration-300">
        
        <!-- Top Navbar -->
        <nav class="bg-white border-b border-slate-200 px-4 py-3 sticky top-0 z-30 shadow-sm flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <h5 class="text-lg font-semibold text-slate-800 hidden sm:block">
                    @yield('title', 'Dashboard')
                </h5>
            </div>
            
            <!-- User Dropdown -->
            <div class="relative">
                <button onclick="toggleDropdown()" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 text-slate-700 transition-colors focus:outline-none">
                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">
                        <i class="bi bi-person-circle text-xl"></i>
                    </div>
                    <span class="hidden sm:inline font-medium text-sm">{{ Auth::user()->name }}</span>
                    <i class="bi bi-chevron-down text-xs text-slate-400"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-100 py-1 z-50 transform origin-top-right transition-all">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-indigo-600">
                        <i class="bi bi-person me-2"></i> Profile
                    </a>
                    <div class="border-t border-slate-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 flex items-center">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Content Wrapper -->
        <div class="p-4 md:p-6 lg:p-8 flex-1">
            
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="flex items-center gap-3 p-4 mb-6 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill text-xl text-emerald-500"></i>
                    <div class="text-sm font-medium">{{ session('success') }}</div>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="flex items-center gap-3 p-4 mb-6 bg-red-50 text-red-700 border border-red-200 rounded-xl shadow-sm" role="alert">
                    <i class="bi bi-exclamation-circle-fill text-xl text-red-500"></i>
                    <div class="text-sm font-medium">{{ session('error') }}</div>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endif

            <!-- Main Content Yield -->
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Sidebar Toggle Logic
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            // Toggle class untuk translasi sidebar
            sidebar.classList.toggle('-translate-x-full');
            
            // Toggle overlay hanya di mobile
            if (window.innerWidth < 1024) {
                overlay.classList.toggle('hidden');
            }
        }

        // Dropdown Logic (Pengganti Bootstrap JS Dropdown)
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Tutup dropdown jika klik di luar
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const button = e.target.closest('button');
            
            // Cek apakah klik di luar dropdown dan bukan tombol trigger
            if (!dropdown.contains(e.target) && (!button || !button.onclick)) {
                dropdown.classList.add('hidden');
            }
        });

        // Fix sidebar state saat resize window
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>