<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeroGallery extends Model
{
    protected $fillable = [
        'hero_id',
        'judul',
        'keterangan',
        'gambar_path',
        'tahun',
        'sumber',
        'urutan',
    ];

    public function hero(): BelongsTo
    {
        return $this->belongsTo(Hero::class);
    }

    public function getGambarUrlAttribute(): string
    {
        if (str_starts_with($this->gambar_path, 'http')) {
            return $this->gambar_path;
        }

        return asset('storage/'.ltrim($this->gambar_path, '/'));
    }
}
