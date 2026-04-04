<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('denda', function (Blueprint $table) {
            $table->unsignedInteger('id', true);

            $table->unsignedInteger('peminjaman_id');
            $table->unsignedInteger('verifikator_id')->nullable();

            $table->integer('hari_terlambat')->default(0);
            $table->decimal('jumlah_denda', 10, 2)->default(0);

            $table->enum('status_denda', [
                'belum_bayar',
                'menunggu_verifikasi',
                'lunas',
                'ditolak'
            ])->default('belum_bayar');

            $table->string('bukti_pembayaran')->nullable();
            $table->timestamp('tanggal_upload_bukti')->nullable(); // TAMBAHAN
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->text('catatan_verifikasi')->nullable();

            $table->timestamps();

            $table->foreign('peminjaman_id')
                ->references('id')
                ->on('peminjaman')
                ->onDelete('cascade');

            $table->foreign('verifikator_id')
                ->references('id')
                ->on('petugas')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};