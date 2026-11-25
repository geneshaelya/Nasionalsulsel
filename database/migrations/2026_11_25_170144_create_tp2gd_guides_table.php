<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tp2gd_guides', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('tahap_nomor')->index();
            $table->string('judul');
            $table->string('ringkasan');
            $table->text('deskripsi');
            $table->json('persyaratan')->nullable();
            $table->string('instansi_terkait')->nullable();
            $table->string('estimasi_waktu')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tp2gd_guides');
    }
};
