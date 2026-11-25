<?php

namespace App\Models;

use Database\Factories\HistoricalSiteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricalSite extends Model
{
    /** @use HasFactory<HistoricalSiteFactory> */
    use HasFactory;

    protected $fillable = [
        'hero_id',
        'nama',
        'slug',
        'jenis',
        'alamat',
        'kabupaten_kota',
        'latitude',
        'longitude',
        'jam_kunjungan',
        'info_ziarah',
        'akses_navigasi',
        'foto_path',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'is_published' => 'boolean',
        ];
    }

    public function hero(): BelongsTo
    {
        return $this->belongsTo(Hero::class);
    }

    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis) {
            'makam' => 'Makam Pahlawan',
            'monumen' => 'Monumen Perjuangan',
            'situs_perjuangan' => 'Situs Sejarah & Benteng',
            'museum' => 'Museum & Rumah Adat',
            default => 'Situs Sejarah',
        };
    }

    public function getGoogleMapsUrlAttribute(): string
    {
        return "https://www.google.com/maps/search/?api=1&query={$this->latitude},{$this->longitude}";
    }
}
