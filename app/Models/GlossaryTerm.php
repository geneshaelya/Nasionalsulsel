<?php

namespace App\Models;

use Database\Factories\GlossaryTermFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GlossaryTerm extends Model
{
    /** @use HasFactory<GlossaryTermFactory> */
    use HasFactory;

    protected $fillable = [
        'istilah',
        'bahasa',
        'pelafalan',
        'arti',
        'konteks_sejarah',
        'hero_id',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function hero(): BelongsTo
    {
        return $this->belongsTo(Hero::class);
    }
}
