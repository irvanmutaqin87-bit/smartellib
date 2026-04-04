<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_sistem', function (Blueprint $table) {
            $table->unsignedInteger('id', true);

            // Pengaturan utama perpustakaan
            $table->integer('lama_peminjaman'); // dalam hari
            $table->integer('batas_peminjaman'); // maksimal buku per anggota
            $table->decimal('denda_per_hari', 10, 2); // nominal denda per hari

            // Pengaturan pembayaran denda
            $table->string('metode_pembayaran_denda', 50)->nullable(); // qris, transfer, ewallet
            $table->string('nama_ewallet', 50)->nullable(); // GoPay, DANA, OVO, dll
            $table->string('nomor_pembayaran', 50)->nullable(); // no HP / no akun
            $table->string('qr_pembayaran')->nullable(); // path gambar QR
            $table->text('catatan_pembayaran')->nullable(); // instruksi tambahan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_sistem');
    }
};