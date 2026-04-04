<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatBuku extends Model
{
    protected $table = 'riwayat_buku';

    protected $primaryKey = 'id_riwayat';

    protected $fillable = [
        'id_anggota',
        'id_buku',
        'jenis_aktivitas',
        'waktu_mulai',
        'waktu_selesai'
    ];

    // Tidak pakai timestamps default Laravel
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}
