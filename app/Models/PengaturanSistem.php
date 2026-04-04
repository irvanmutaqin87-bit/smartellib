<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSistem extends Model
{
    protected $table = 'pengaturan_sistem';

    protected $fillable = [
        'lama_peminjaman',
        'batas_peminjaman',
        'denda_per_hari',
        'metode_pembayaran_denda',
        'nama_ewallet',
        'nomor_pembayaran',
        'qr_pembayaran',
        'catatan_pembayaran',
    ];

    protected $casts = [
        'lama_peminjaman' => 'integer',
        'batas_peminjaman' => 'integer',
        'denda_per_hari' => 'decimal:2',
    ];

    public static function aktif()
    {
        return self::first() ?? self::create([
            'lama_peminjaman' => 7,
            'batas_peminjaman' => 3,
            'denda_per_hari' => 1000,
            'metode_pembayaran_denda' => 'QRIS',
            'nama_ewallet' => 'GoPay',
            'nomor_pembayaran' => null,
            'qr_pembayaran' => null,
            'catatan_pembayaran' => 'Silakan bayar sesuai nominal denda lalu upload bukti pembayaran.',
        ]);
    }
}