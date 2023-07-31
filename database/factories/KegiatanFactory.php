<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class KegiatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $end_date = Carbon::today()->addWeeks(8)->subDays(random_int(0, 365));
        return [
            'nama_kegiatan' => fake()->sentence(2), 
            'tgl_mulai' => date('Y-m-d', strtotime('-1 week', strtotime($end_date))),
            'tgl_selesai' => $end_date,
            'lokasi' => fake()->sentence(5), 
            'peserta' => fake()->sentence(2), 
        ];
    }
}