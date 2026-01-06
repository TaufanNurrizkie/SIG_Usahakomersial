<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Peta Usaha Komersial Kecamatan</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Google Fonts (Material Symbols) -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,0..200&display=swap" rel="stylesheet"/>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        #map {
            height: 100vh;
            width: 100%;
        }
        
        .map-controls {
            position: absolute;
            top: 20px;
            left: 60px;
            z-index: 1000;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            width: 320px;
        }
        
        .map-header {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .legend {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
            font-size: 0.85rem;
        }
        
        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 50%;
        }
        
        .leaflet-popup-content {
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        
        .popup-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        
        .popup-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            color: white;
            margin-bottom: 5px;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body>
    <!-- Map -->
    <div id="map"></div>
    
    <!-- Controls -->
    <div class="map-controls">
        <h5 class="mb-3">
            <i class="bi bi-geo-alt-fill text-primary me-2"></i>Peta Usaha Komersial
        </h5>
        
        <div class="mb-3">
            <label class="form-label small fw-bold">Filter Kategori</label>
            <select id="filter-kategori" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label small fw-bold">Filter Kelurahan</label>
            <select id="filter-kelurahan" class="form-select form-select-sm">
                <option value="">Semua Kelurahan</option>
                @foreach($kelurahans as $kelurahan)
                    <option value="{{ $kelurahan->id }}">{{ $kelurahan->nama_kelurahan }}</option>
                @endforeach
            </select>
        </div>
        
        <hr>
        
        <div class="legend">
            <p class="small fw-bold mb-2">Legenda Kategori</p>
            <div class="legend-item"><div class="legend-color" style="background:#e74c3c"></div> Kuliner</div>
            <div class="legend-item"><div class="legend-color" style="background:#3498db"></div> Retail</div>
            <div class="legend-item"><div class="legend-color" style="background:#2ecc71"></div> Jasa</div>
            <div class="legend-item"><div class="legend-color" style="background:#9b59b6"></div> Produksi</div>
            <div class="legend-item"><div class="legend-color" style="background:#e91e63"></div> Kesehatan</div>
            <div class="legend-item"><div class="legend-color" style="background:#ff9800"></div> Pendidikan</div>
            <div class="legend-item"><div class="legend-color" style="background:#00bcd4"></div> Teknologi</div>
            <div class="legend-item"><div class="legend-color" style="background:#795548"></div> Lainnya</div>
        </div>
        
        <div class="mt-3 text-center">
            <span id="marker-count" class="badge bg-primary">0 usaha</span>
        </div>
    </div>
    
    <!-- Header Buttons -->
    <div class="map-header">
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                <i class="bi bi-speedometer2 me-1"></i>Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary me-2">
                <i class="bi bi-box-arrow-in-right me-1"></i>Login
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary">
                <i class="bi bi-person-plus me-1"></i>Register
            </a>
        @endauth
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Initialize map (centered on Kertapati, Palembang)
        const map = L.map('map').setView([-2.9761, 104.7758], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Helper untuk icon category (sama seperti Landing Page)
        function getIconForCategory(cat) {
            if (!cat) return { icon: 'store', color: '#6b7280' };
            const n = cat.toLowerCase();
            if (n.includes('kuliner') || n.includes('makan')) return { icon: 'restaurant' };
            if (n.includes('dagang') || n.includes('toko')) return { icon: 'shopping_bag' };
            if (n.includes('jasa')) return { icon: 'build' };
            if (n.includes('umkm') || n.includes('industri')) return { icon: 'storefront' };
            return { icon: 'store' };
        }

        let markers = [];
        
        function loadMarkers() {
            const kategori = document.getElementById('filter-kategori').value;
            const kelurahan = document.getElementById('filter-kelurahan').value;
            
            let url = '/api/peta-usaha?';
            if (kategori) url += `kategori=${kategori}&`;
            if (kelurahan) url += `kelurahan=${kelurahan}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Clear existing markers
                    markers.forEach(marker => map.removeLayer(marker));
                    markers = [];
                    
                    if (data.success && data.data.length > 0) {
                        data.data.forEach(usaha => {
                            // Get icon string
                            const { icon } = getIconForCategory(usaha.kategori);

                            const markerIcon = L.divIcon({
                                className: 'custom-marker',
                                html: `
                                    <div style="
                                        background:${usaha.color}; 
                                        width:36px; height:36px; 
                                        border-radius:50%; 
                                        border:2px solid white; 
                                        box-shadow:0 3px 8px rgba(0,0,0,0.3);
                                        display:flex; align-items:center; justify-content:center;
                                    ">
                                        <span class="material-symbols-outlined" style="font-size:18px; color:white;">${icon}</span>
                                    </div>
                                `,
                                iconSize: [36, 36],
                                iconAnchor: [18, 18],
                                popupAnchor: [0, -18]
                            });
                            
                            const marker = L.marker([usaha.latitude, usaha.longitude], { icon: markerIcon })
                                .addTo(map);
                            
                            let popupContent = `
                                <div style="min-width:200px">
                                    <div class="popup-title">${usaha.nama_usaha}</div>
                                    <div class="popup-badge" style="background:${usaha.color}">${usaha.kategori}</div>
                                    <p style="margin:5px 0; font-size:0.9rem;">
                                        <i class="bi bi-geo-alt"></i> ${usaha.kelurahan}
                                    </p>
                            `;
                            
                            if (usaha.foto_usaha) {
                                popupContent += `<img src="${usaha.foto_usaha}" style="width:100%; border-radius:8px; margin-top:8px;">`;
                            }
                            
                            popupContent += '</div>';
                            
                            marker.bindPopup(popupContent);
                            markers.push(marker);
                        });
                        
                        document.getElementById('marker-count').textContent = `${data.data.length} usaha`;
                        
                        // Fit bounds if there are markers
                        if (markers.length > 0) {
                            const group = L.featureGroup(markers);
                            map.fitBounds(group.getBounds().pad(0.1));
                        }
                    } else {
                        document.getElementById('marker-count').textContent = '0 usaha';
                    }
                })
                .catch(error => {
                    console.error('Error loading markers:', error);
                });
        }
        
        // Filter change handlers
        document.getElementById('filter-kategori').addEventListener('change', loadMarkers);
        document.getElementById('filter-kelurahan').addEventListener('change', loadMarkers);
        
        // Initial load
        loadMarkers();
    </script>
</body>
</html>
