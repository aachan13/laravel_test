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
            'tanggal_masuk' => $this->faker->date(),
            'total_gaji' => $this->faker->randomNumber('8', true),
        ];
    }
}
