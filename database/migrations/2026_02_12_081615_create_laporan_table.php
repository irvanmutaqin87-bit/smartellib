<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {

            // PRIMARY KEY (INT)
            $table->unsignedInteger('id', true);

            $table->enum('jenis_laporan', [
                'peminjaman',
                'pengembalian',
                'denda',
                'anggota',
                'buku'
            ]);

            $table->date('periode_awal');
            $table->date('periode_akhir');

            // JSON fleksibel untuk simpan hasil generate laporan
            $table->json('data_laporan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};