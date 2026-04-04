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
        Schema::create('book_comments', function (Blueprint $table) {

            // PRIMARY KEY INT
            $table->increments('id');

            // FOREIGN KEY INT
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('buku_id');

            // SELF RELATION (REPLY KOMENTAR)
            $table->unsignedInteger('parent_id')->nullable();

            // ISI KOMENTAR
            $table->text('comment');

            $table->timestamps();

            // RELASI
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');

            $table->foreign('buku_id')
                    ->references('id')->on('buku')
                    ->onDelete('cascade');

            // RELASI KE DIRI SENDIRI (REPLY)
            $table->foreign('parent_id')
                    ->references('id')->on('book_comments')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_comments');
    }
};