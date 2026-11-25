<?php

namespace Database\Factories;

use App\Models\GlossaryTerm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GlossaryTerm>
 */
class GlossaryTermFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'istilah' => fake()->unique()->word(),
            'bahasa' => fake()->randomElement(['Bugis', 'Makassar', 'Toraja', 'Mandar']),
            'pelafalan' => fake()->word(),
            'arti' => fake()->sentence(),
            'konteks_sejarah' => fake()->sentence(),
            'is_published' => true,
        ];
    }
}
