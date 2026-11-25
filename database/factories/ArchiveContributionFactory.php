<?php

namespace Database\Factories;

use App\Models\ArchiveContribution;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ArchiveContribution>
 */
class ArchiveContributionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_pengirim' => fake()->name(),
            'hubungan_tokoh' => 'Masyarakat / Peneliti Lokal',
            'email' => fake()->safeEmail(),
            'telepon' => '0812' . fake()->numerify('########'),
            'judul' => fake()->sentence(5),
            'jenis_kontribusi' => fake()->randomElement(['foto_arsip', 'catatan_sejarah', 'koreksi_data', 'dokumen']),
            'isi_catatan' => fake()->paragraph(3),
            'sumber_dokumen' => 'Arsip Keluarga',
            'status' => 'draft',
        ];
    }
}
