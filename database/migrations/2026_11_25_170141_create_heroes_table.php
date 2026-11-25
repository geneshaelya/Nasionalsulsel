<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nama');
            $table->string('gelar_singkat');
            $table->string('kategori', 20)->default('nasional')->index();
            $table->string('asal_daerah', 100)->index();
            $table->string('tempat_lahir')->nullable();
            $table->string('tanggal_lahir', 100)->nullable();
            $table->string('tempat_wafat')->nullable();
            $table->string('tanggal_wafat', 100)->nullable();
            $table->smallInteger('tahun_penanda')->index();
            $table->string('label_penanda')->nullable();
            $table->string('keppres_nomor')->nullable();
            $table->string('tanggal_penetapan', 100)->nullable();
            $table->string('masa_jabatan')->nullable();
            $table->text('ringkasan')->nullable();
            $table->longText('biografi')->nullable();
            $table->json('riwayat_hidup')->nullable();
            $table->json('perjuangan_jasa')->nullable();
            $table->text('hubungan_keluarga')->nullable();
            $table->json('fun_facts')->nullable();
            $table->json('sumber_referensi')->nullable();
            $table->string('foto_utama')->nullable();
            $table->string('warna_aksen', 20)->default('#33291a');
            $table->unsignedTinyInteger('ukuran_strip')->default(34);
            $table->integer('urutan')->default(0);
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
