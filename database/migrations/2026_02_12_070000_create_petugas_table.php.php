<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petugas', function (Blueprint $table) {

            // PRIMARY KEY INT
            $table->unsignedInteger('id', true); 
            // true = auto increment + primary key

            // FOREIGN KEY KE USERS (INT JUGA)
            $table->unsignedInteger('user_id');

            $table->string('no_hp', 20);

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
        Schema::dropIfExists('petugas');
    }
};