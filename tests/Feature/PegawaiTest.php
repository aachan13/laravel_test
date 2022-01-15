<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class PegawaiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_pegawai()
    {
        $response = $this->get('/api/pegawai');

        $response->assertStatus(200);
    }

    public function test_get_pegawai_pagination(){

        Pegawai::factory(5)->create();

        $response = $this->getJson('/api/pegawai');
        $response->assertStatus(200)
                ->assertJson([
                    'links' => true,
                    'meta' => [
                        'per_page' => true
                    ],
                ]);
    }

    public function test_pegawai_pagination_with_page(){

        Pegawai::factory(30)->create();

        $response = $this->json('GET', '/api/pegawai', [
                        'page' => 5
                    ]);
        
        $response->assertStatus(200)
                ->assertJson([
                    'meta' => [
                        'current_page' => 5
                    ],
                ]);
    }

    public function test_pegawai_pagination_with_page_not_integer(){

        $response = $this->json('GET', '/api/pegawai', [
                        'page' => 'asasf'
                    ]);
        
        $response->assertStatus(422)
                ->assertInvalid([
                    'page' => 'The page must be an integer.',
                ]);
    }

    public function test_pegawai_pagination_with_page_null(){

        $response = $this->json('GET', '/api/pegawai', [
                        'page' => null
                    ]);
        
        $response->assertStatus(200)
        ->assertJson([
                    'links' => true,
                    'meta' => [
                        'per_page' => true
                    ],
                ]);;
    }

    public function test_uppercase_nama_pegawai()
    {
        Pegawai::factory()->create();
        $response = $this->getJson('/api/pegawai');

        $dataPegawai = $response['data'][0];
        
        $this->assertTrue(Str::upper($dataPegawai['nama']) == $dataPegawai['nama']);
    }

    public function test_first_name_nama_pegawai()
    {
        $pegawai = Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => now(),
            'total_gaji' => 5000000
        ]);
        $response = $this->getJson('/api/pegawai');

        $dataPegawai = $response['data'][0];
        
        $this->assertTrue($dataPegawai['nama'] == Str::before(Str::upper($pegawai->nama), ' '));
    }

    public function test_format_tanggal_masuk_pegawai(){
        
        $tanggal = new Carbon('2021-04-20');
        Pegawai::create([
            'nama' => 'Achmad Fad',
            // YYYY-MM-DD
            'tanggal_masuk' => $tanggal,
            'total_gaji' => 5000000
        ]);
        $response = $this->getJson('/api/pegawai');

        $dataPegawai = $response['data'][0];
        // expected DD-MM-YYYY
        $this->assertTrue($dataPegawai['tanggal_masuk'] == $tanggal->format('d-m-Y'));
    }

    public function test_format_gaji_pegawai(){
        $pegawai = Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2021-04-20',
            'total_gaji' => 5000000
        ]);
        $response = $this->getJson('/api/pegawai');

        $dataPegawai = $response['data'][0];
        $this->assertTrue($dataPegawai['total_gaji'] == number_format($pegawai->total_gaji, '0', '', '.'));
    }

    public function test_store_pegawai(){
        
        $response = $this->postJson('/api/pegawai', [
                            'nama' => 'Fadhil P',
                            'tanggal_masuk' => '2022-01-13',
                            'total_gaji' => 6000000
                        ]);
        
        $response->assertStatus(201)
                ->assertJson([
                    'data' => [
                        'nama' => true,
                        'tanggal_masuk' => true,
                        'total_gaji' => true
                    ]
                ]);
    }

    public function test_store_pegawai_missing_nama(){

        $response = $this->postJson('/api/pegawai', [
            'tanggal_masuk' => '2022-01-13',
            'total_gaji' => 6000000
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'nama' => 'The nama field is required.',
                ]);
    }

    // test nama

    public function test_store_pegawai_non_string_nama(){
        $response = $this->postJson('/api/pegawai', [
            'nama' => true,
            'tanggal_masuk' => '2022-01-13',
            'total_gaji' => 6000000
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'nama' => 'The nama must be a string.',
                ]);
    }

    public function test_store_pegawai_non_unique_name(){

        Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2021-04-20',
            'total_gaji' => 5000000
        ]);

        $response = $this->postJson('/api/pegawai', [
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2022-01-01',
            'total_gaji' => 6000000
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'nama' => 'The nama has already been taken.',
                ]);
    }

    public function test_store_pegawai_nama_more_than_10_character(){

        // 20 character name
        $nama = Str::random(20);
        $response = $this->postJson('/api/pegawai', [
            'nama' => $nama,
            'tanggal_masuk' => '2022-01-01',
            'total_gaji' => 6000000
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'nama' => 'The nama must not be greater than 10 characters.',
                ]);
    }

    // test tanggal masuk
    public function test_store_pegawai_missing_tanggal_masuk(){
        
        $response = $this->postJson('/api/pegawai', [
            'nama' => 'Achmad Fadhil',
            'total_gaji' => 6000000
        ]);

        $response->assertStatus(422)
                    ->assertInvalid([
                        'tanggal_masuk' => 'The tanggal masuk field is required.',
                    ]);
    }

    public function test_store_pegawai_tanggal_masuk_not_date(){
        
        $response = $this->postJson('/api/pegawai', [
            'nama' => 'Achmad Fadhil',
            'tanggal_masuk' => 'test12345',
            'total_gaji' => 6000000
        ]);

        $response->assertStatus(422)
                    ->assertInvalid([
                        'tanggal_masuk' => 'The tanggal masuk is not a valid date.',
                    ]);
    }

    public function test_store_pegawai_tanggal_masuk_greater_than_now(){
        
        // 1 hari setelah sekarang
        $tanggal = now()->add(1, 'day');

        $response = $this->postJson('/api/pegawai', [
            'nama' => 'Achmad Fadhil',
            'tanggal_masuk' => $tanggal,
            'total_gaji' => 6000000
        ]);

        $response->assertStatus(422)
                    ->assertInvalid([
                        'tanggal_masuk' => 'The tanggal masuk must be a date before now.',
                    ]);
    }

    // test total gaji
    public function test_store_pegawai_missing_total_gaji(){

        $response = $this->postJson('/api/pegawai', [
            'nama' => 'Achmad Fadhil',
            'tanggal_masuk' => '2022-01-01',
        ]);

        $response->assertStatus(422)
                    ->assertInvalid([
                        'total_gaji' => 'The total gaji field is required.',
                    ]);
    }

    public function test_store_pegawai_non_integer_total_gaji(){

        $response = $this->postJson('/api/pegawai', [
            'nama' => 'Achmad F',
            'tanggal_masuk' => '2022-01-01',
            'total_gaji' => 'fadhil'
        ]);

        $response->assertStatus(422)
                    ->assertInvalid([
                        'total_gaji' => 'The total gaji must be an integer.',
                    ]);
    }

    public function test_store_pegawai_gaji_lower_than_4000000(){

        $response = $this->postJson('/api/pegawai', [
            'nama' => 'Achmad F',
            'tanggal_masuk' => '2022-01-01',
            'total_gaji' => 1000000
        ]);

        $response->assertStatus(422)
                    ->assertInvalid([
                        'total_gaji' => 'The total gaji must be at least 4000000.',
                    ]);
    }

    public function test_store_pegawai_gaji_greater_than_10000000(){

        $response = $this->postJson('/api/pegawai', [
            'nama' => 'Achmad F',
            'tanggal_masuk' => '2022-01-01',
            'total_gaji' => 70000000
        ]);

        $response->assertStatus(422)
                    ->assertInvalid([
                        'total_gaji' => 'The total gaji must not be greater than 10000000.',
                    ]);
    }
}
