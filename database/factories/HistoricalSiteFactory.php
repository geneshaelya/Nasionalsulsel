<?php

namespace Database\Factories;

use App\Models\HistoricalSite;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<HistoricalSite>
 */
class HistoricalSiteFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = 'Makam ' . fake()->name();

        return [
            'nama' => $nama,
            'slug' => Str::slug($nama) . '-' . fake()->unique()->numberBetween(100, 999),
            'jenis' => fake()->randomElement(['makam', 'monumen', 'situs_perjuangan', 'museum']),
            'alamat' => fake()->address(),
            'kabupaten_kota' => fake()->randomElement(['Kota Makassar', 'Kabupaten Gowa', 'Kabupaten Bone', 'Kabupaten Takalar']),
            'latitude' => fake()->latitude(-5.5, -2.9),
            'longitude' => fake()->longitude(119.3, 120.4),
            'jam_kunjungan' => '07.00 – 17.00 WITA',
            'info_ziarah' => fake()->paragraph(),
            'akses_navigasi' => fake()->sentence(),
            'is_published' => true,
        ];
    }
}
