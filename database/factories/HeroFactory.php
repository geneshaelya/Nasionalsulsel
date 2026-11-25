<?php

namespace Database\Factories;

use App\Models\Hero;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Hero>
 */
class HeroFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = fake()->name();

        return [
            'slug' => Str::slug($nama) . '-' . fake()->unique()->numberBetween(100, 999),
            'nama' => $nama,
            'gelar_singkat' => fake()->sentence(4),
            'kategori' => 'nasional',
            'asal_daerah' => fake()->randomElement(['Makassar', 'Gowa', 'Bone', 'Luwu', 'Toraja', 'Wajo', 'Takalar', 'Bulukumba']),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => '1900',
            'tempat_wafat' => fake()->city(),
            'tanggal_wafat' => '1965',
            'tahun_penanda' => fake()->numberBetween(1660, 2026),
            'label_penanda' => 'Penetapan Gelar Pahlawan Nasional',
            'keppres_nomor' => 'Keppres No. 085/TK/2006',
            'tanggal_penetapan' => '3 November 2006',
            'ringkasan' => fake()->paragraph(),
            'biografi' => fake()->paragraphs(3, true),
            'riwayat_hidup' => [fake()->paragraph(), fake()->paragraph()],
            'perjuangan_jasa' => [fake()->sentence(), fake()->sentence()],
            'hubungan_keluarga' => fake()->sentence(),
            'fun_facts' => [
                ['judul' => 'Fakta Sejarah', 'fakta' => fake()->sentence()],
            ],
            'sumber_referensi' => [
                ['judul' => 'Arsip Kemensos RI', 'url' => 'https://kemensos.go.id'],
            ],
            'warna_aksen' => '#7a5a2e',
            'ukuran_strip' => 34,
            'urutan' => 1,
            'is_published' => true,
        ];
    }
}
