<?php

namespace App\Models;

use Database\Factories\ArchiveContributionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchiveContribution extends Model
{
    /** @use HasFactory<ArchiveContributionFactory> */
    use HasFactory;

    protected $fillable = [
        'hero_id',
        'nama_pengirim',
        'hubungan_tokoh',
        'email',
        'telepon',
        'judul',
        'jenis_kontribusi',
        'isi_catatan',
        'file_path',
        'sumber_dokumen',
        'status',
        'catatan_admin',
        'verified_by',
        'verified_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    public function hero(): BelongsTo
    {
        return $this->belongsTo(Hero::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
