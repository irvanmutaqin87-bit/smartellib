<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->unsignedInteger('id', true); 

            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('google_id')->nullable();
            $table->string('password')->nullable();

            $table->enum('role', ['admin','petugas','anggota']);

            $table->enum('status', ['pending','aktif','nonaktif'])
                    ->default('pending');

            $table->string('photo')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
    
};
