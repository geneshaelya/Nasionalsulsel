<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tp2gd_documents', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori', 30)->default('panduan');
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->unsignedInteger('ukuran_kb')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tp2gd_documents');
    }
};
