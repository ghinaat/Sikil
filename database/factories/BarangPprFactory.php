<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BarangPpr>
 */
class BarangPprFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_ruangan' => $this->faker->numberBetween(1, 3), // Menggunakan $this->faker
            'nama_barang' => $this->faker->word,
            'tahun_pembuatan' => $this->faker->year,
            'jumlah' => $this->faker->randomNumber(2),
            'keterangan' => $this->faker->word,
            'image' => null,
            'is_deleted' => $this->faker->randomElement(['0', '1']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
