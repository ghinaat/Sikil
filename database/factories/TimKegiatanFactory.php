<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimKegiatan>
 */
class TimKegiatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_kegiatan' => random_int(1, 40),
            'id_users' => random_int(1, 12),
            'id_peran' => random_int(1, 2),
        ];
    }
}
