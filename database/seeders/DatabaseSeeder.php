<?php

namespace Database\Seeders;

use App\Models\Kasbon;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Pegawai::factory(10)->create();
        Kasbon::factory(5)->create();
    }
}
