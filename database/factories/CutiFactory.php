<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Cuti;
use Illuminate\Database\Eloquent\Factories\Factory;

class CutiFactory extends Factory
{
    protected $model = Cuti::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_users' => function () {
                return User::factory()->create()->id_users;
            },
            'jatah_cuti' => $this->faker->numberBetween(10, 30),
            'is_deleted' => '0',
        ];
    }
}
