<?php

namespace App\Models;

use Database\Factories\HeroFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hero extends Model
{
    /** @use HasFactory<HeroFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'nama',
        'gelar_singkat',
        'kategori',
        'asal_daerah',
        'tempat_lahir',
        'tanggal_lahir',
        'tempat_wafat',
        'tanggal_wafat',
        'tahun_penanda',
        'label_penanda',
        'keppres_nomor',
        'tanggal_penetapan',
        'masa_jabatan',
        'ringkasan',
        'biografi',
        'riwayat_hidup',
        'perjuangan_jasa',
        'hubungan_keluarga',
        'fun_facts',
        'sumber_referensi',
        'foto_utama',
        'warna_aksen',
        'ukuran_strip',
        'urutan',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'riwayat_hidup' => 'array',
            'perjuangan_jasa' => 'array',
            'fun_facts' => 'array',
            'sumber_referensi' => 'array',
            'tahun_penanda' => 'integer',
            'ukuran_strip' => 'integer',
            'urutan' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(HeroGallery::class)->orderBy('urutan');
    }

    public function historicalSites(): HasMany
    {
        return $this->hasMany(HistoricalSite::class);
    }

    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class)->where('is_active', true);
    }

    public function glossaryTerms(): HasMany
    {
        return $this->hasMany(GlossaryTerm::class)->where('is_published', true);
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(ArchiveContribution::class);
    }

    public function getFotoUrlAttribute(): string
    {
        if (! $this->foto_utama) {
            return asset('images/placeholder-hero.svg');
        }

        if (str_starts_with($this->foto_utama, 'http')) {
            return $this->foto_utama;
        }

        return asset('storage/'.ltrim($this->foto_utama, '/'));
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'nasional' => 'Pahlawan Nasional',
            'daerah' => 'Tokoh Pejuang Daerah Sulsel',
            'calon' => 'Calon Pahlawan Nasional (TP2GD)',
            default => 'Tokoh Sejarah',
        };
    }
}
