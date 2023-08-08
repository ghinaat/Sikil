<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Presensi>
 */
class PresensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $existingKodeFingers = User::pluck('kode_finger')->all();

        if (fake()->boolean()) {
            $array = [
                'kode_finger' => fake()->randomElement($existingKodeFingers),
                'tanggal' => fake()->date(),
                'jam_masuk' => fake()->time(),
                'jam_pulang' => fake()->time(),
                'terlambat' => fake()->time(),
                'pulang_cepat' => fake()->time(),
                'kehadiran' => true,
                'jenis_perizinan' => fake()->randomElement(['I', 'DL', 'S', 'CS', 'Prajab', 'CT', 'CM', 'CAP', 'CH', 'CB', 'A', 'TB']),
            ];
        } else {
            $array = [
                'kode_finger' => fake()->randomElement($existingKodeFingers),
                'tanggal' => fake()->date(),
                'jam_masuk' => null,
                'jam_pulang' => null,
                'terlambat' => null,
                'pulang_cepat' => null,
                'kehadiran' => false,
                'jenis_perizinan' => fake()->randomElement(['I', 'DL', 'S', 'CS', 'Prajab', 'CT', 'CM', 'CAP', 'CH', 'CB', 'A', 'TB']),
            ];
        }

        return $array;
    }
}
