<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_id',
        'nama_peserta',
        'asal_instansi',
        'skor',
        'total_soal',
        'persentase',
        'lulus',
        'nomor_sertifikat',
        'completed_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'skor' => 'integer',
            'total_soal' => 'integer',
            'persentase' => 'integer',
            'lulus' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
