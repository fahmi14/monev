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
        Schema::create('petugass', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_kegiatan')
            ->constrained('kegiatans')
            ->onDelete('cascade');
            $table->string('nama');
            $table->string('email');
            $table->unsignedInteger('open')->default(0);
            $table->unsignedInteger('submit')->default(0);
            $table->unsignedInteger('reject')->default(0);
            $table->unsignedInteger('approve')->default(0);
            $table->unique(['id_kegiatan', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugass');
    }
};
