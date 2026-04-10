<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatBuku extends Model
{
    protected $table = 'riwayat_buku';

    protected $primaryKey = 'id'; // FIX

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'jenis_aktivitas',
        'waktu_mulai',
        'waktu_selesai'
    ];

    public $timestamps = true; // karena pakai created_at

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}