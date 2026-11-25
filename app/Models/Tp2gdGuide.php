<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tp2gdGuide extends Model
{
    protected $fillable = [
        'tahap_nomor',
        'judul',
        'ringkasan',
        'deskripsi',
        'persyaratan',
        'instansi_terkait',
        'estimasi_waktu',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tahap_nomor' => 'integer',
            'persyaratan' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
