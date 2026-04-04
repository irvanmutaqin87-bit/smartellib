<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {

            // PRIMARY KEY INT
            $table->unsignedInteger('id', true);

            // FOREIGN KEY KE USERS (INT JUGA)
            $table->unsignedInteger('user_id')->unique();

            // DATA TAMBAHAN ANGGOTA
            $table->string('no_hp', 20);
            $table->text('alamat');

            $table->timestamps();

            // RELASI
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
