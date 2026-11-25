<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->string('nama_peserta');
            $table->string('asal_instansi')->nullable();
            $table->unsignedSmallInteger('skor');
            $table->unsignedSmallInteger('total_soal');
            $table->unsignedTinyInteger('persentase');
            $table->boolean('lulus')->default(false);
            $table->string('nomor_sertifikat')->unique();
            $table->timestamp('completed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
