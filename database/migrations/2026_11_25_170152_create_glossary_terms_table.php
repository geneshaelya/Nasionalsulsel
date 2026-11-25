<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('glossary_terms', function (Blueprint $table) {
            $table->id();
            $table->string('istilah');
            $table->string('bahasa', 30)->index();
            $table->string('pelafalan')->nullable();
            $table->text('arti');
            $table->text('konteks_sejarah')->nullable();
            $table->foreignId('hero_id')->nullable()->constrained('heroes')->nullOnDelete();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('glossary_terms');
    }
};
