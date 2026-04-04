<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'jenis_laporan',
        'periode_awal',
        'periode_akhir',
        'data_laporan'
    ];

    protected $casts = [
        'data_laporan' => 'array',
        'periode_awal' => 'date',
        'periode_akhir' => 'date'
    ];

    public $timestamps = true;
}
