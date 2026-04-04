<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {

            $table->unsignedInteger('id', true);

            // RELASI
            $table->unsignedInteger('anggota_id');
            $table->unsignedInteger('buku_id');

            // TANGGAL
            $table->timestamp('tanggal_pinjam')->useCurrent();
            $table->date('tanggal_mulai');
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_kembali')->nullable();

            // STATUS
            $table->enum('status', [
                'dipinjam',
                'dikembalikan',
                'terlambat'
            ])->default('dipinjam');

            $table->timestamps();

            // RELASI FK
            $table->foreign('anggota_id')
                ->references('id')
                ->on('anggota')
                ->onDelete('cascade');

            $table->foreign('buku_id')
                ->references('id')
                ->on('buku')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};