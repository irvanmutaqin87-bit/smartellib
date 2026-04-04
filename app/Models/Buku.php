<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;
use App\Models\BookComment;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'file_buku',
        'cover',
        'total_halaman',
        'kategori_id',
        'deskripsi'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'buku_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(BookComment::class, 'buku_id', 'id')
                    ->whereNull('parent_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    public function antrianPeminjaman()
    {
        return $this->hasMany(AntrianPeminjaman::class, 'buku_id');
    }

    public function getAverageRatingAttribute()
    {
        return round($this->ratings()->avg('rating') ?? 0, 1);
    }

    public function getTotalRatingAttribute()
    {
        return $this->ratings()->count();
    }
}