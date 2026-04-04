<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BayarDenda extends Model
{
    use HasFactory;

    protected $table = 'bayar_denda';

    protected $fillable = [
        'denda_id',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'jumlah_bayar' => 'decimal:2',
    ];

    public function denda()
    {
        return $this->belongsTo(Denda::class, 'denda_id');
    }
}