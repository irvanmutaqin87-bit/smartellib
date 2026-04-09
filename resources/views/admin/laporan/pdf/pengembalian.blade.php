<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian</title>
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
        <h2>LAPORAN PENGEMBALIAN</h2>
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
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Terlambat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $item)
                @php
                    $terlambatHari = 0;
                    if ($item->tanggal_kembali && $item->tanggal_jatuh_tempo) {
                        $tglKembali = \Carbon\Carbon::parse($item->tanggal_kembali);
                        $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                        $terlambatHari = max(0, $jatuhTempo->diffInDays($tglKembali, false));
                    }
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->anggota->user->nama ?? '-' }}</td>
                    <td>{{ $item->buku->judul ?? '-' }}</td>
                    <td>{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $terlambatHari }} hari</td>
                    <td>Dikembalikan</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>