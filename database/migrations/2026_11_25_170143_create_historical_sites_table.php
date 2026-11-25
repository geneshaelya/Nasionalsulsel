<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historical_sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hero_id')->nullable()->constrained('heroes')->nullOnDelete();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('jenis', 30)->default('makam')->index();
            $table->text('alamat');
            $table->string('kabupaten_kota', 100)->index();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('jam_kunjungan')->nullable();
            $table->text('info_ziarah')->nullable();
            $table->text('akses_navigasi')->nullable();
            $table->string('foto_path')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historical_sites');
    }
};
