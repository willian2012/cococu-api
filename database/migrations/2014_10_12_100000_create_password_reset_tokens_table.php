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
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('email', 191)->unique(); // Ajusta la longitud según tus necesidades
            $table->string('token', 191);
            $table->timestamps(); // Esto añade created_at y updated_at automáticamente
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};
