<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'denda';

    protected $fillable = [
        'peminjaman_id',
        'verifikator_id',
        'hari_terlambat',
        'jumlah_denda',
        'status_denda',
        'bukti_pembayaran',
        'tanggal_verifikasi',
        'catatan_verifikasi',
    ];

    protected $casts = [
        'tanggal_verifikasi' => 'datetime',
        'jumlah_denda' => 'decimal:2',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(Petugas::class, 'verifikator_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(BayarDenda::class, 'denda_id');
    }

    // =========================
    // HELPER
    // =========================
    public function sudahLunas()
    {
        return $this->status_denda === 'lunas';
    }

    public function perluVerifikasi()
    {
        return $this->status_denda === 'menunggu_verifikasi';
    }

    public function bayarDenda()
    {
        return $this->hasOne(BayarDenda::class, 'denda_id');
    }
}