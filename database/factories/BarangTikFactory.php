<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class BarangTikFactory extends Factory
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
            'jenis_aset' => $this->faker->randomElement(['BMN', 'Non-BMN']),
            'kode_barang' => $this->faker->unique()->randomNumber(6),
            'nama_barang' => $this->faker->word,
            'merek' => $this->faker->word,
            'kelengkapan' => $this->faker->sentence,
            'tahun_pembelian' => $this->faker->date,
            'kondisi' => $this->faker->randomElement(['Baik', 'Perlu Perbaikan', 'Rusak Total']),
            'status_pinjam' => $this->faker->randomElement(['Ya', 'Tidak']),
            'keterangan' => $this->faker->word,
            'image' => null,
            'is_deleted' => $this->faker->randomElement(['0', '1']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}