<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_mulai',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_mulai' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_kembali' => 'date',
    ];

    // =========================
    // RELASI
    // =========================
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'peminjaman_id');
    }

    // =========================
    // HELPER
    // =========================
    public function isAktif()
    {
        return in_array($this->status, ['dipinjam', 'terlambat']);
    }

    public function isTerlambat()
    {
        return Carbon::today()->gt(Carbon::parse($this->tanggal_jatuh_tempo))
            && is_null($this->tanggal_kembali);
    }

    public function sudahKembali()
    {
        return !is_null($this->tanggal_kembali) || $this->status === 'dikembalikan';
    }

    public function bolehReview()
    {
        return $this->status === 'dikembalikan';
    }
}