<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Denda</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1e293b; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 4px 0; font-size: 11px; color: #475569; }
        .meta { margin-bottom: 14px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 6px; }
        th { background: #f1f5f9; text-align: left; }
    </style>
</head>
<body>

    <div class="header">
        <h1>SMARTELLIB</h1>
        <p>Sistem Manajemen Perpustakaan Digital</p>
        <h2>LAPORAN DENDA</h2>
    </div>

    <div class="meta">
        <strong>Dicetak pada:</strong> {{ now()->format('d F Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Judul Buku</th>
                <th>Hari Terlambat</th>
                <th>Jumlah Denda</th>
                <th>Status</th>
                <th>Tgl Dibuat</th>
                <th>Tgl Verifikasi</th>
                <th>Verifikator</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->peminjaman->anggota->user->nama ?? '-' }}</td>
                    <td>{{ $item->peminjaman->buku->judul ?? '-' }}</td>
                    <td>{{ $item->hari_terlambat ?? 0 }} hari</td>
                    <td>Rp {{ number_format($item->jumlah_denda ?? 0, 0, ',', '.') }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $item->status_denda)) }}</td>
                    <td>{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->tanggal_verifikasi ? \Carbon\Carbon::parse($item->tanggal_verifikasi)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->verifikator->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>