@extends('layouts.app')

@section('title', 'Ajukan Usaha Baru')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-plus-circle text-indigo-500"></i> Form Pengajuan Usaha Baru
            </h3>
        </div>

        <!-- Body -->
        <div class="p-6 sm:p-8">
            <form action="{{ route('user.usaha.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Usaha -->
                    <div class="md:col-span-2">
                        <label for="nama_usaha" class="block text-sm font-bold text-gray-700 mb-1">Nama Usaha <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha') }}" placeholder="Masukkan nama usaha Anda"
                            class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-4 py-2.5 text-base @error('nama_usaha') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" 
                            required>
                        @error('nama_usaha')
                            <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Kategori -->
                    <div>
                        <label for="kategori_id" class="block text-sm font-bold text-gray-700 mb-1">Kategori Usaha <span class="text-red-500">*</span></label>
                        <select id="kategori_id" name="kategori_id" class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-4 py-2.5 text-base @error('kategori_id') border-red-500 focus:border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Kelurahan -->
                    <div>
                        <label for="kelurahan_id" class="block text-sm font-bold text-gray-700 mb-1">Kelurahan <span class="text-red-500">*</span></label>
                        <select id="kelurahan_id" name="kelurahan_id" class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-4 py-2.5 text-base @error('kelurahan_id') border-red-500 focus:border-red-500 @enderror" required>
                            <option value="">Pilih Kelurahan</option>
                            @foreach($kelurahans as $kelurahan)
                                <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id') == $kelurahan->id ? 'selected' : '' }}>
                                    {{ $kelurahan->nama_kelurahan }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelurahan_id')
                            <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Foto Usaha -->
                    <div>
                        <label for="foto_usaha" class="block text-sm font-bold text-gray-700 mb-1">Foto Usaha</label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg hover:border-indigo-500 transition-colors p-2">
                            <input type="file" id="foto_usaha" name="foto_usaha" class="w-full h-full absolute inset-0 opacity-0 cursor-pointer z-10" accept="image/*">
                            <div class="flex items-center justify-center w-full h-full bg-white rounded-lg">
                                <div class="text-center p-4">
                                    <i class="bi bi-cloud-upload text-2xl text-gray-400 mb-1"></i>
                                    <p class="text-xs text-gray-500 font-medium">Klik untuk upload foto</p>
                                    <p class="text-[10px] text-gray-400">JPG, PNG (Max 2MB)</p>
                                </div>
                            </div>
                        </div>
                        @error('foto_usaha')
                            <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <!-- Peta & Koordinat (UPDATE BAGIAN INI) -->
                <div class="mt-8">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi Usaha <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500 mb-3">Klik pada peta ATAU ketik koordinat secara manual.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <!-- Map Area -->
                        <div class="md:col-span-3">
                            <div id="map" class="w-full h-80 rounded-xl border-2 border-gray-200 shadow-inner focus-within:border-indigo-500 transition-colors z-0"></div>
                        </div>
                        
                        <!-- Coordinates Manual Input -->
                        <div class="md:col-span-1 flex flex-col gap-3">
                            <!-- Input Latitude (Editable) -->
                            <div>
                                <label for="latitude" class="text-xs font-semibold text-gray-500 uppercase mb-1 block">Latitude</label>
                                <input type="number" id="latitude" name="latitude" step="any" value="{{ old('latitude') }}"
                                    class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-900 font-mono text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-3 py-2 @error('latitude') border-red-500 @enderror" 
                                    placeholder="-6.1234">
                            </div>
                            
                            <!-- Input Longitude (Editable) -->
                            <div>
                                <label for="longitude" class="text-xs font-semibold text-gray-500 uppercase mb-1 block">Longitude</label>
                                <input type="number" id="longitude" name="longitude" step="any" value="{{ old('longitude') }}"
                                    class="w-full rounded-lg bg-white border-2 border-gray-200 text-gray-900 font-mono text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all px-3 py-2 @error('longitude') border-red-500 @enderror" 
                                    placeholder="106.1234">
                            </div>
                            
                            <!-- Helper Text -->
                            <div class="mt-auto p-3 bg-indigo-50 rounded-lg border border-indigo-100">
                                <p class="text-xs text-indigo-700 leading-relaxed">
                                    <i class="bi bi-info-circle-fill mr-1"></i>
                                    Koordinat terisi otomatis jika Anda klik peta.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @error('latitude')
                        <p class="mt-1.5 text-xs font-semibold text-red-600 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> Lokasi wajib ditentukan
                        </p>
                    @enderror
                </div>
                
                <!-- Dokumen Pendukung -->
                <div class="mt-8">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Dokumen Pendukung</label>
                    
                    <div id="dokumen-container" class="space-y-4">
                        <!-- Initial Row -->
                        <div class="dokumen-row grid grid-cols-1 md:grid-cols-12 gap-3 items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="md:col-span-3">
                                <label class="text-xs font-bold text-gray-500 mb-1 block">Jenis Dokumen</label>
                                <select name="jenis_dokumen[]" class="w-full rounded-lg border-2 border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none px-3 py-2 bg-white">
                                    <option value="KTP">KTP</option>
                                    <option value="foto_lokasi">Foto Lokasi</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="md:col-span-8">
                                <label class="text-xs font-bold text-gray-500 mb-1 block">File</label>
                                <input type="file" name="dokumen[]" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-xs file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100" accept=".jpg,.jpeg,.png,.pdf">
                                <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, PDF (Max 2MB)</p>
                            </div>
                            <!-- Hidden remove for first row -->
                            <div class="md:col-span-1 flex items-center justify-center">
                                <div class="text-gray-300"><i class="bi bi-lock"></i></div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="mt-3 inline-flex items-center gap-2 px-4 py-2 border border-indigo-200 text-indigo-700 bg-white hover:bg-indigo-50 rounded-lg text-sm font-medium transition-colors w-full md:w-auto" id="add-dokumen">
                        <i class="bi bi-plus-circle"></i> Tambah Dokumen Lain
                    </button>
                </div>
                
                <hr class="my-8 border-gray-200">
                
                <!-- Buttons -->
                <div class="flex flex-col-reverse sm:flex-row justify-between gap-4">
                    <a href="{{ route('user.usaha.index') }}" class="inline-flex justify-center items-center px-6 py-2.5 border border-gray-300 text-sm font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-colors">
                        <i class="bi bi-arrow-left mr-2"></i> Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center px-8 py-2.5 border border-transparent text-sm font-bold rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-[1.01]">
                        <i class="bi bi-send mr-2"></i> Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize map (Default Jakarta)
    const map = L.map('map').setView([-6.2088, 106.8456], 12);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    
    let marker;
    let markerAdded = false;
    
    // Ambil elemen input
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    // Fungsi untuk memperbarui marker dari input manual
    function updateMapFromInput() {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);

        if (!isNaN(lat) && !isNaN(lng)) {
            const latlng = { lat, lng };
            
            if (marker) {
                marker.setLatLng(latlng);
            } else {
                marker = L.marker(latlng).addTo(map);
                markerAdded = true;
            }
            
            // Pindahkan pandangan peta ke koordinat baru
            map.setView(latlng, 16);
        }
    }

    // Fungsi untuk memperbarui input dari klik peta
    function updateInputFromMap(latlng) {
        const lat = latlng.lat.toFixed(8);
        const lng = latlng.lng.toFixed(8);
        
        latInput.value = lat;
        lngInput.value = lng;
    }

    // Event Listener: Klik pada Peta
    map.on('click', function(e) {
        const latlng = e.latlng;
        
        // Update Input Form
        updateInputFromMap(latlng);
        
        // Update Marker
        if (marker) {
            marker.setLatLng(latlng);
        } else {
            marker = L.marker(latlng).addTo(map);
            markerAdded = true;
        }
        
        // Efek visual pada border peta
        const mapEl = document.getElementById('map');
        mapEl.classList.add('border-indigo-500', 'ring-2', 'ring-indigo-200');
        setTimeout(() => {
            mapEl.classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-200');
        }, 1000);
    });
    
    // Event Listener: Input Manual (Type & Change)
    latInput.addEventListener('input', updateMapFromInput);
    lngInput.addEventListener('input', updateMapFromInput);

    // Restore data saat reload (Validation Error / Edit)
    @if(old('latitude') && old('longitude'))
        const oldLat = {{ old('latitude') }};
        const oldLng = {{ old('longitude') }};
        
        // Pastikan marker ada di peta
        if (!isNaN(oldLat) && !isNaN(oldLng)) {
            marker = L.marker([oldLat, oldLng]).addTo(map);
            markerAdded = true;
            map.setView([oldLat, oldLng], 16);
            
            // Pastikan input juga terisi dengan benar
            // (Biasanya blade old() sudah mengisi value, tapi ini untuk memastikan marker sinkron)
        }
    @endif
    
    // Add document row logic
    document.getElementById('add-dokumen').addEventListener('click', function() {
        const container = document.getElementById('dokumen-container');
        const newRow = document.createElement('div');
        
        newRow.className = 'dokumen-row grid grid-cols-1 md:grid-cols-12 gap-3 items-start p-4 bg-gray-50 rounded-lg border border-gray-200 relative';
        newRow.innerHTML = `
            <div class="md:col-span-3">
                <label class="text-xs font-bold text-gray-500 mb-1 block">Jenis Dokumen</label>
                <select name="jenis_dokumen[]" class="w-full rounded-lg border-2 border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none px-3 py-2 bg-white">
                    <option value="KTP">KTP</option>
                    <option value="foto_lokasi">Foto Lokasi</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div class="md:col-span-8">
                <label class="text-xs font-bold text-gray-500 mb-1 block">File</label>
                <input type="file" name="dokumen[]" class="block w-full text-sm text-slate-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-xs file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100" accept=".jpg,.jpeg,.png,.pdf">
                <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, PDF (Max 2MB)</p>
            </div>
            <div class="md:col-span-1 flex items-start justify-center pt-5">
                <button type="button" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition-colors remove-dokumen" title="Hapus Dokumen">
                    <i class="bi bi-trash-fill text-lg"></i>
                </button>
            </div>
        `;
        
        container.appendChild(newRow);
    });
    
    // Remove document row logic (Event Delegation)
    document.getElementById('dokumen-container').addEventListener('click', function(e) {
        const button = e.target.closest('.remove-dokumen');
        if (button) {
            const row = button.closest('.dokumen-row');
            if (row) {
                if(confirm('Hapus baris dokumen ini?')) {
                    row.remove();
                }
            }
        }
    });
</script>
@endpush