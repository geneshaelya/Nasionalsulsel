<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archive_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hero_id')->nullable()->constrained('heroes')->nullOnDelete();
            $table->string('nama_pengirim');
            $table->string('hubungan_tokoh')->nullable();
            $table->string('email');
            $table->string('telepon', 30)->nullable();
            $table->string('judul');
            $table->string('jenis_kontribusi', 30)->default('catatan_sejarah');
            $table->text('isi_catatan');
            $table->string('file_path')->nullable();
            $table->string('sumber_dokumen')->nullable();
            $table->string('status', 20)->default('draft')->index();
            $table->text('catatan_admin')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archive_contributions');
    }
};
