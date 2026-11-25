<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dinsos.sulselprov.go.id'],
            [
                'name' => 'Admin Dinas Sosial Sulsel',
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@dinsos.sulselprov.go.id'],
            [
                'name' => 'Staf Kurator Sejarah Dinsos',
                'role' => 'staff',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            HeroSeeder::class,
            HistoricalSiteSeeder::class,
            Tp2gdSeeder::class,
            QuizSeeder::class,
            GlossarySeeder::class,
        ]);
    }
}
