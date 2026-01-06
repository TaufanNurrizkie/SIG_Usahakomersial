<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Usaha Komersial</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
        }
        
        .filter-info {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .filter-info span {
            display: inline-block;
            margin-right: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background: #4a5568;
            color: white;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .status {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-menunggu { background: #ffc107; color: #000; }
        .status-disetujui { background: #28a745; color: #fff; }
        .status-ditolak { background: #dc3545; color: #fff; }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        
        .summary {
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Usaha Komersial Kecamatan</h1>
        <p>Sistem Informasi Geografis Pemetaan Usaha</p>
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>
    
    @if(count($filterLabels) > 0)
        <div class="filter-info">
            <strong>Filter yang diterapkan:</strong>
            @if(isset($filterLabels['status']))
                <span>Status: {{ $filterLabels['status'] }}</span>
            @endif
            @if(isset($filterLabels['kategori']))
                <span>Kategori: {{ $filterLabels['kategori'] }}</span>
            @endif
            @if(isset($filterLabels['kelurahan']))
                <span>Kelurahan: {{ $filterLabels['kelurahan'] }}</span>
            @endif
            @if(isset($filterLabels['dari_tanggal']))
                <span>Dari: {{ $filterLabels['dari_tanggal'] }}</span>
            @endif
            @if(isset($filterLabels['sampai_tanggal']))
                <span>Sampai: {{ $filterLabels['sampai_tanggal'] }}</span>
            @endif
        </div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:20%">Nama Usaha</th>
                <th style="width:15%">Pemohon</th>
                <th style="width:12%">Kategori</th>
                <th style="width:15%">Kelurahan</th>
                <th style="width:18%">Koordinat</th>
                <th style="width:10%">Status</th>
                <th style="width:10%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usahas as $index => $usaha)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $usaha->nama_usaha }}</td>
                    <td>{{ $usaha->user->name }}</td>
                    <td>{{ $usaha->kategori->nama_kategori }}</td>
                    <td>{{ $usaha->kelurahan->nama_kelurahan }}</td>
                    <td>{{ $usaha->latitude }}, {{ $usaha->longitude }}</td>
                    <td>
                        <span class="status status-{{ $usaha->status }}">
                            {{ ucfirst(str_replace('_', ' ', $usaha->status)) }}
                        </span>
                    </td>
                    <td>{{ $usaha->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="summary">
        <strong>Total: {{ $usahas->count() }} usaha</strong>
    </div>
    
    <div class="footer">
        <p>Dokumen ini digenerate otomatis oleh sistem</p>
        <p>SIG Usaha Komersial Kecamatan &copy; {{ date('Y') }}</p>
    </div>
</body>
</html>
