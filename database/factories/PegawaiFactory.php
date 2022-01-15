<?php

namespace Database\Factories;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Pegawai::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->text(10),
            'tanggal_masuk' => $this->faker->dateTimeBetween('-2 year', '-1 month'),
            'total_gaji' => $this->faker->randomNumber('8', true),
        ];
    }
}
