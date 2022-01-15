<?php

namespace Tests\Feature;

use App\Jobs\UpdateMasalKasbonJob;
use App\Models\Kasbon;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class KasbonTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_kasbon()
    {
        Pegawai::factory(10)->create();
        Kasbon::factory(10)->create();

        // belum disetujui nullable
        $response = $this->json('GET', '/api/kasbon', [
                        'bulan' => '2022-01',
                    ]);
        $response->assertStatus(200);
    }

    public function test_get_kasbon_missing_bulan(){

        Pegawai::factory(10)->create();
        Kasbon::factory(10)->create();

        $response = $this->getJson('/api/kasbon');

        $response->assertStatus(422)
                    ->assertInvalid([
                        'bulan' => 'The bulan field is required.',
                    ]);
    }

    public function test_get_kasbon_incorrect_bulan_format(){

        Pegawai::factory(10)->create();
        Kasbon::factory(10)->create();

        $response = $this->json('GET', '/api/kasbon', [
                        'bulan' => '01',
                    ]);

        $response->assertStatus(422)
                    ->assertInvalid([
                        'bulan' => 'The bulan does not match the format Y-m.',
                    ]);
    }

    public function test_get_kasbon_non_integer_belum_disetujui(){

        Pegawai::factory(10)->create();
        Kasbon::factory(10)->create();

        $response = $this->json('GET', '/api/kasbon', [
                        'bulan' => '2022-01',
                        'belum_disetujui' => 'tes'
                    ]);

        $response->assertStatus(422)
                    ->assertInvalid([
                        'belum_disetujui' => 'The belum disetujui must be an integer.',
                    ]);
    }

    public function test_get_kasbon_belum_disetujui_is_1(){

        Pegawai::factory(10)->create();
        Kasbon::factory(50)->bulanBerjalan()->create();

        $response = $this->json('GET', '/api/kasbon', [
                        'bulan' => '2022-01',
                        'belum_disetujui' => 1
                    ]);

        $response->assertStatus(200)
                    ->assertJson([
                        'data' => [
                            [
                                'tanggal_diajukan' => true,
                                'tanggal_disetujui' => null,
                                'nama_pegawai' => true,
                                'total_kasbon' => true,
                            ]
                        ],
                    ]);
    }

    public function test_get_kasbon_with_page(){

        Pegawai::factory(20)->create();
        Kasbon::factory(20)->create();

        $response = $this->json('GET', '/api/kasbon', [
                        'bulan' => '2022-01',
                        'page' => 3
                    ]);

        $response->assertStatus(200)
                ->assertJson([
                    'meta' => [
                        'current_page' => 3
                    ],
                ]);
    }

    public function test_get_kasbon_with_non_integer_page(){

        Pegawai::factory(20)->create();
        Kasbon::factory(20)->create();

        $response = $this->json('GET', '/api/kasbon', [
                        'bulan' => '2022-01',
                        'page' => 'tes'
                    ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'page' => 'The page must be an integer.',
                ]);
    }

    public function test_get_kasbon_pagination(){
        Pegawai::factory(20)->create();
        Kasbon::factory(20)->create();

        $response = $this->json('GET', '/api/kasbon', [
                        'bulan' => '2022-01',
                    ]);
        $response->assertStatus(200)
                    ->assertJson([
                        'links' => true,
                        'meta' => [
                            'per_page' => true
                        ],
                    ]);
    }

    public function test_format_tanggal_diajukan(){

        $tanggal = new Carbon('2022-01-10');
        Pegawai::factory(1)->create();
        Kasbon::create([
                'tanggal_diajukan' => $tanggal,
                'pegawai_id' => Pegawai::first()->id,
                'total_kasbon' => 500000
        ]);

        $response = $this->json('GET', '/api/kasbon', [
            'bulan' => '2022-01',
        ]);

        // format DD-MMMM-YYYY
        $this->assertTrue($response['data'][0]['tanggal_diajukan'] == $tanggal->format('d-m-Y'));
        
    }

    public function test_format_tanggal_disetujui(){

        $tanggal = new Carbon('2022-01-10');
        Pegawai::factory(1)->create();
        Kasbon::create([
                'tanggal_diajukan' => now(),
                'pegawai_id' => Pegawai::first()->id,
                'tanggal_disetujui' => $tanggal,
                'total_kasbon' => 500000
        ]);

        $response = $this->json('GET', '/api/kasbon', [
            'bulan' => '2022-01',
        ]);

        // format DD-MMMM-YYYY
        $this->assertTrue($response['data'][0]['tanggal_disetujui'] == $tanggal->format('d-m-Y'));
        
    }

    public function test_format_tanggal_disetujui_without_value(){

        $tanggal = new Carbon('2022-01-10');
        Pegawai::factory(1)->create();
        Kasbon::create([
                'tanggal_diajukan' => now(),
                'pegawai_id' => Pegawai::first()->id,
                'tanggal_disetujui' => null,
                'total_kasbon' => 500000
        ]);

        $response = $this->json('GET', '/api/kasbon', [
            'bulan' => '2022-01',
        ]);

        // format DD-MMMM-YYYY
        $this->assertFalse($response['data'][0]['tanggal_disetujui'] == $tanggal->format('d-m-Y'));
        
    }

    public function test_relasi_nama_pegawai(){

        $pegawai = Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2021-04-20',
            'total_gaji' => 5000000
        ]);

        Kasbon::create([
                'tanggal_diajukan' => '2022-01-10',
                'pegawai_id' => $pegawai->id,
                'tanggal_disetujui' => null,
                'total_kasbon' => 500000
        ]);

        $response = $this->json('GET', '/api/kasbon', [
            'bulan' => '2022-01',
        ]);

        $this->assertTrue($response['data'][0]['nama_pegawai'] == $pegawai->nama);
        
    }

    public function test_format_total_kasbon(){
        
        Pegawai::factory(1)->create();
        $kasbon = Kasbon::create([
                'tanggal_diajukan' => now(),
                'pegawai_id' => Pegawai::first()->id,
                'tanggal_disetujui' => null,
                'total_kasbon' => 500000
        ]);

        $response = $this->json('GET', '/api/kasbon', [
            'bulan' => '2022-01',
        ]);

        $this->assertTrue($response['data'][0]['total_kasbon'] == number_format($kasbon->total_kasbon, '2', '', '.'));
    }

    public function test_store_kasbon(){

        // bekerja 1 Januari 2021
        $pegawai = Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2021-01-01',
            'total_gaji' => 5000000
        ]);

        $response = $this->postJson('/api/kasbon', [
            'tanggal_diajukan' => now(),
            'pegawai_id' => $pegawai->id,
            'total_kasbon' => 500000
        ]);

        $response->assertStatus(201)
                ->assertJson([
                    'data' => [
                        'tanggal_diajukan' => true,
                        'tanggal_disetujui' => null,
                        'nama_pegawai' => true,
                        'total_kasbon' => true,
                    ],
                ]);
    }

    public function test_store_kasbon_non_integer_pegawai_id(){

        $response = $this->postJson('/api/kasbon', [
            'tanggal_diajukan' => now(),
            'pegawai_id' => 'tes',
            'total_kasbon' => 500000
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'pegawai_id' => 'The pegawai id must be an integer.',
                ]);
    }

    public function test_store_kasbon_missing_pegawai_id(){

        $response = $this->postJson('/api/kasbon', [
            'tanggal_diajukan' => now(),
            'total_kasbon' => 500000
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'pegawai_id' => 'The pegawai id field is required.',
                ]);
    }

    public function test_store_kasbon_with_non_pegawai_id(){

        $response = $this->postJson('/api/kasbon', [
            'tanggal_diajukan' => now(),
            'pegawai_id' => 99,
            'total_kasbon' => 500000
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'pegawai_id' => 'The selected pegawai id is invalid.',
                ]);
    }

    public function test_store_kasbon_pegawai_not_1_year(){

        // 20 Agustus 2021
        $pegawai = Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2021-08-20',
            'total_gaji' => 5000000
        ]);

        $response = $this->postJson('/api/kasbon', [
            'tanggal_diajukan' => now(),
            'pegawai_id' => $pegawai->id,
            'total_kasbon' => 500000
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'pegawai_id' => 'Minimal harus 1 tahun bekerja.',
                ]);
    }

    public function test_store_kasbon_pegawai_greater_than_3_kasbon(){

        // 1 Januari 2021
        $pegawai = Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2021-01-01',
            'total_gaji' => 5000000
        ]);

        // buat 3 pengajuan pada januari 2022
        $pegawai->kasbon()->create([
            'tanggal_diajukan' => '2022-01-01',
            'total_kasbon' => 20000
        ]);

        $pegawai->kasbon()->create([
            'tanggal_diajukan' => '2022-01-02',
            'total_kasbon' => 20000
        ]);

        $pegawai->kasbon()->create([
            'tanggal_diajukan' => '2022-01-03',
            'total_kasbon' => 20000
        ]);
        // 3x pengajuan

        $response = $this->postJson('/api/kasbon', [
            'tanggal_diajukan' => now(),
            'pegawai_id' => $pegawai->id,
            'total_kasbon' => 500000
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'pegawai_id' => 'Pengajuan kasbon pada bulan ini sudah lebih dari 3.',
                ]);
    }

    public function test_store_kasbon_non_integer_total_kasbon(){
        // bekerja 1 Januari 2021
        $pegawai = Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2021-01-01',
            'total_gaji' => 5000000
        ]);

        $response = $this->postJson('/api/kasbon', [
            'tanggal_diajukan' => now(),
            'pegawai_id' => $pegawai->id,
            'total_kasbon' => 'tes'
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'total_kasbon' => 'The total kasbon must be an integer.',
                ]);
    }

    public function test_store_kasbon_batas_jumlah_kasbon(){
        // 1/2 gaji = 2500000
        $pegawai = Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2021-01-01',
            'total_gaji' => 5000000
        ]);

        // kasbon bulan Januari
        $pegawai->kasbon()->create([
            'tanggal_diajukan' => '2022-01-02',
            'total_kasbon' => 1500000
        ]);

        $pegawai->kasbon()->create([
            'tanggal_diajukan' => '2022-01-03',
            'total_kasbon' => 100000
        ]);

        $response = $this->postJson('/api/kasbon', [
            'tanggal_diajukan' => now(),
            'pegawai_id' => $pegawai->id,
            'total_kasbon' => 1000000
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'total_kasbon' => 'Total kasbon pada bulan ini tidak boleh melewati setengah gaji anda.',
                ]);
    }

    public function test_patch_setujui_kasbon(){
        
        $pegawai = Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2021-01-01',
            'total_gaji' => 5000000
        ]);

        $kasbon = Kasbon::create([
            'tanggal_diajukan' => '2022-01-03',
            'pegawai_id' => $pegawai->id,
            'total_kasbon' => 20000
        ]);

        $response = $this->patchJson('/api/kasbon/setujui/'.$kasbon->id, [
            'id' => $kasbon->id,
            'tanggal_disetujui' => now(),
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'tanggal_diajukan' => true,
                        'tanggal_disetujui' => true,
                        'nama_pegawai' => true,
                        'total_kasbon' => true,
                    ],
                ]);
    }

    public function test_patch_setujui_kasbon_missing_id(){

        $response = $this->patchJson('/api/kasbon/setujui/3', [
            'tanggal_disetujui' => now(),
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'id' => 'The id field is required.',
                ]);
    }

    public function test_patch_setujui_kasbon_id_not_found(){

        $response = $this->patchJson('/api/kasbon/setujui/3', [
            'id' => 3,
            'tanggal_disetujui' => now(),
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'id' => 'The selected id is invalid.',
                ]);
    }

    public function test_patch_setujui_kasbon_tanggal_disetujui_is_not_null(){

        $pegawai = Pegawai::create([
            'nama' => 'Achmad Fad',
            'tanggal_masuk' => '2021-01-01',
            'total_gaji' => 5000000
        ]);

        $kasbon = Kasbon::create([
            'tanggal_diajukan' => '2022-01-03',
            'pegawai_id' => $pegawai->id,
            'tanggal_disetujui' => '2022-01-04',
            'total_kasbon' => 20000
        ]);

        $response = $this->patchJson('/api/kasbon/setujui/'.$kasbon->id, [
            'id' => $kasbon->id,
            'tanggal_disetujui' => now(),
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'id' => 'Kasbon sudah disetujui.',
                ]);
    }

    public function test_kasbon_setujui_masal(){
        
        Pegawai::factory(10)->create();
        Kasbon::factory(100)->create();
        $kasbonBulanIni =  Kasbon::filterKasbon(now()->format('Y-m'), 1)->count();
        
        $response = $this->postJson('api/kasbon/setujui-masal');

        $response->assertStatus(200)
                ->assertJson([
                    $kasbonBulanIni. ' kasbon akan disetujui.'
                ]);
    }

    public function test_kasbon_setujui_masal_job_dispatched(){
        Pegawai::factory(10)->create();
        Kasbon::factory(100)->create();
        Bus::fake();
        $this->post('api/kasbon/setujui-masal');

        Bus::assertDispatched(UpdateMasalKasbonJob::class);
    }
}
