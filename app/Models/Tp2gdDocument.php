<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tp2gdDocument extends Model
{
    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'file_path',
        'ukuran_kb',
        'urutan',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ukuran_kb' => 'integer',
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
