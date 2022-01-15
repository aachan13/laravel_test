<?php

namespace Database\Factories;

use App\Models\Kasbon;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

class KasbonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Kasbon::class;

    public function definition()
    {
        $pegawai = Pegawai::pluck('id')->toArray();

        return [
            'tanggal_diajukan' => $this->faker->dateTimeBetween('-1 month', 'today'),
            'tanggal_disetujui' => $this->faker->randomElement([$this->faker->date(), null]),
            'pegawai_id' => $this->faker->randomElement($pegawai),
            'total_kasbon' => $this->faker->randomNumber('6', true)
        ];
    }

    public function bulanBerjalan(){
        return $this->state(function (array $attributes) {
            return [
                'tanggal_diajukan' => $this->faker->dateTimeInInterval('-10 days', 'today'),
                'tanggal_disetujui' => $this->faker->randomElement([$this->faker->date(), null]),
            ];
        });
    }
}
