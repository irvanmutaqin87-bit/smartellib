<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'antrian_peminjaman';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'posisi_antrian',
        'status',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}