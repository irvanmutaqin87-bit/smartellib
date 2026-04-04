<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_buku', function (Blueprint $table) {

            // PRIMARY KEY (INT)
            $table->unsignedInteger('id', true);

            // FOREIGN KEY (INT)
            $table->unsignedInteger('anggota_id');
            $table->unsignedInteger('buku_id');

            $table->enum('jenis_aktivitas', [
                'baca',
                'pinjam',
                'kembalikan',
                'download'
            ]);

            $table->timestamp('waktu_mulai')->useCurrent();
            $table->timestamp('waktu_selesai')->nullable();

            $table->timestamps();

            // RELASI
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
        Schema::dropIfExists('riwayat_buku');
    }
};