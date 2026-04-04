<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrian_peminjaman', function (Blueprint $table) {
            $table->unsignedInteger('id', true);

            $table->unsignedInteger('buku_id');
            $table->unsignedInteger('anggota_id');

            $table->integer('posisi_antrian');

            $table->enum('status', [
                'menunggu',
                'diproses',
                'selesai',
                'dibatalkan'
            ])->default('menunggu');

            $table->timestamps();

            $table->foreign('buku_id')
                ->references('id')
                ->on('buku')
                ->onDelete('cascade');

            $table->foreign('anggota_id')
                ->references('id')
                ->on('anggota')
                ->onDelete('cascade');

            // OPTIONAL BIAR GAK DOBEL ANTRI BUKU YANG SAMA
            $table->unique(['buku_id', 'anggota_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrian_peminjaman');
    }
};