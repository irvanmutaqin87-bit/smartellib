<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bayar_denda', function (Blueprint $table) {
            $table->unsignedInteger('id', true);

            $table->unsignedInteger('denda_id');

            $table->decimal('jumlah_bayar', 10, 2);
            $table->timestamp('tanggal_bayar')->useCurrent();
            $table->string('metode_bayar', 50)->nullable();
            $table->string('bukti_pembayaran')->nullable();

            $table->timestamps();

            $table->foreign('denda_id')
                ->references('id')
                ->on('denda')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bayar_denda');
    }
};