<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'no_hp',
        'alamat'
    ];

    public $timestamps = true;

    // =========================
    // RELASI
    // =========================
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }

    public function antrianPeminjaman()
    {
        return $this->hasMany(AntrianPeminjaman::class, 'anggota_id');
    }

    // =========================
    // HELPER
    // =========================
    public function peminjamanAktif()
    {
        return $this->peminjaman()->whereIn('status', ['dipinjam', 'terlambat']);
    }

    public function dendaBelumLunas()
    {
        return Denda::whereHas('peminjaman', function ($q) {
            $q->where('anggota_id', $this->id);
        })->whereIn('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'ditolak']);
    }

    public function masihPunyaDendaAktif()
    {
        return $this->dendaBelumLunas()->exists();
    }
}