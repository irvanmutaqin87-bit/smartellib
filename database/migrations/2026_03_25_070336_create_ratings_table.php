<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {

            // PRIMARY KEY INT
            $table->increments('id');

            // FOREIGN KEY INT
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('buku_id');

            // Nilai rating (1 - 5)
            $table->tinyInteger('rating');

            $table->timestamps();

            // Supaya 1 user hanya bisa kasih 1 rating per buku
            $table->unique(['user_id', 'buku_id']);

            // RELASI
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');

            $table->foreign('buku_id')
                    ->references('id')->on('buku')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};