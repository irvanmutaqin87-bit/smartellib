<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->unsignedInteger('id', true);

            $table->string('kode_buku', 20)->unique();
            $table->string('judul', 100);
            $table->string('penulis', 100);
            $table->string('penerbit', 100);
            $table->year('tahun_terbit');
            $table->integer('stok')->default(0);
            $table->integer('total_halaman');
            $table->text('deskripsi')->nullable();
            $table->string('file_buku', 255)->nullable();
            $table->string('cover', 255)->nullable();

            // FK ke kategori
            $table->unsignedInteger('kategori_id')->nullable();

            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategori')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};