<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Menjalankan projek

```
   git clone 
```
```
   cd project
```
```
   composer install
```
```
   setup env, database
```
```
   php artisan key:generate
```
```
   php artisan migrate
```
```
   php artisan test
```

generate fake data
```
   php artisan db:seed 
```

endpoint

### GET
- page(nullable, integer)
```
api/pegawai
```

### POST
- nama(string, max: 10, required, unique), 
- tanggal_masuk (required, date, tanggal sebelum sekarang), 
- total_gaji (integer, required, min 4000000, max:10000000)
```
api/pegawai
```

### GET
- bulan(format YYYY-MM), 
- page(nullable, integer)
```
api/kasbon 
```

###POST
- pegawai_id(required, integer, exist(ada pada tabel pegawai), bekerja 1 tahun, 3 kasbon pada bulan berjalan),
- total_kasbon (required, integer, jumlah kasbon pada bulan berjalan tidak lebih dari setengah gaji pegawai)
```
api/kasbon 
```

### PATCH
- id (required, exist(ada pada tabel kasbon), karbon belum disetujui),
```
api/kasbon/setujui/{id}
```

### POST
```
api/kasbon/setujui-masal
```


## Daftar Tes 

Terdapat total 50 tes di dalam projek ini. 


## Tes Pegawai
```
    Feature/PegawaiTest.php
```

### test_get_pegawai

Tes get endpoint api pegawai.


### test_get_pegawai_pagination

Tes pagination api pegawai.


### test_pegawai_pagination_with_page

Tes pagination dengan tambahan parameter page.


### test_pegawai_pagination_with_page_not_integer

Tes pagination dengan parameter page yang bukan integer.


### test_pegawai_pagination_with_page_null

Tes pagination dengan request ```page``` kosong atau null.


### test_pegawai_pagination_with_page_null

Tes pagination dengan request ```page``` kosong atau null.


### test_uppercase_nama_pegawai

Tes nama pegawai pada response adalah huruf besar semua.


### test_first_name_nama_pegawai

Tes nama pegawai pada response adalah nama pertama (Cth: Achmad Fadhil = Achmad).


### test_format_tanggal_masuk_pegawai

Tes format tanggal_masuk pegawai pada response adalah DD-MM-YYYY (id).


### test_format_gaji_pegawai

Tes format total_gaji pegawai pada response adalah #.### (ribuan).


### test_store_pegawai

Tes input pegawai.


### test_store_pegawai_missing_nama

Tes input pegawai tanpa nama.


### test_store_pegawai_non_string_nama

Tes input pegawai dengan nama yang bukan string (ex:boolean).


### test_store_pegawai_non_unique_name

Tes input pegawai dengan nama yang kembar.


### test_store_pegawai_nama_more_than_10_character

Tes input pegawai dengan nama lebih dari 10 karakter.


### test_store_pegawai_missing_tanggal_masuk

Tes input pegawai tanpa tanggal_masuk.


### test_store_pegawai_tanggal_masuk_not_date

Tes input pegawai dengan tanggal masuk yang bukan format tanggal.


### test_store_pegawai_tanggal_masuk_greater_than_now

Tes input pegawai dengan tanggal masuk yang lebih dari tanggal sekarang.


### test_store_pegawai_missing_total_gaji

Tes input pegawai tanpa total gaji.


### test_store_pegawai_non_integer_total_gaji

Tes input pegawai dengan total gaji yang bukan integer.


### test_store_pegawai_gaji_lower_than_4000000

Tes input pegawai dengan total gaji kurang dari yang ditentukan (Cth: 4000000).


### test_store_pegawai_gaji_greater_than_10000000

Tes input pegawai dengan total gaji kurang dari yang ditentukan (Cth: 10000000).


## Tes Kasbon
```
    Feature/KasbonTest.php
```

### test_get_kasbon

Tes endpoint api kasbon dengan parameter bulan (YYYY-MM).


### test_get_kasbon_missing_bulan

Tes endpoint api kasbon tanpa parameter bulan.


### test_get_kasbon_incorrect_bulan_format

Tes endpoint api kasbon dengan parameter bulan yang tidak sesuai format YYYY-MM.


### test_get_kasbon_non_integer_belum_disetujui

Tes endpoint api kasbon dengan parameter belum disetujui bukan integer.


### test_get_kasbon_belum_disetujui_is_1

Tes get kasbon dengan nilai parameter belum disetujui = 1 (menampilkan kasbon yang belum disetujui).


### test_get_kasbon_with_non_integer_page

Tes get kasbon dengan parameter page bukan integer.


### test_get_kasbon_pagination

Tes pagination api kasbon.


### test_format_tanggal_diajukan

Tes format tanggal_diajukan pada response adalah DD-MM-YYYY (id).


### test_format_tanggal_disetujui

Tes format tanggal_disetujui pada response adalah DD-MM-YYYY (id).


### test_format_tanggal_disetujui_without_value

Tes format tanggal_disetujui pada response ketika null harus bernilai false.


### test_relasi_nama_pegawai

Tes response kasbon memiliki nama_pegawai dari tabel pegawai.


### test_relasi_nama_pegawai

Tes response kasbon memiliki nama_pegawai dari tabel pegawai.


### test_format_total_kasbon

Tes format total_kasbon pada response adalah #.### (ribuan).


### test_store_kasbon

Tes input data kasbon.


### test_store_kasbon_non_integer_pegawai_id

Tes input data kasbon dengan parameter pegawai_id bukan integer.


### test_store_kasbon_missing_pegawai_id

Tes input data kasbon tanpa parameter pegawai_id.


### test_store_kasbon_with_non_pegawai_id

Tes input data kasbon dengan parameter pegawai_id yang tidak valid (bukan dari tabel pegawai).


### test_store_kasbon_pegawai_not_1_year

Tes input data kasbon dengan tanggal_masuk pegawai yang belum 1 tahun.


### test_store_kasbon_pegawai_greater_than_3_kasbon

Tes input data kasbon dengan pegawai yang sudah memiliki 3 kasbon pada bulan berjalan.


### test_store_kasbon_non_integer_total_kasbon

Tes input data kasbon dengan parameter total_kasbon bukan integer.


### test_store_kasbon_batas_jumlah_kasbon

Tes input data kasbon dengan total_kasbon melebihi 1/2 gaji pegawai.


### test_store_kasbon_batas_jumlah_kasbon

Tes input data kasbon dengan total_kasbon melebihi 1/2 gaji pegawai.


### test_patch_setujui_kasbon

Tes update tanggal_disetujui kasbon sesuai dengan waktu insert.


### test_patch_setujui_kasbon_missing_id

Tes update tanggal_disetujui kasbon tanpa menggunakan parameter id.


### test_patch_setujui_kasbon_id_not_found

Tes update tanggal_disetujui kasbon menggunakan parameter id yang tidak ada pada tabel pegawai.


### test_patch_setujui_kasbon_tanggal_disetujui_is_not_null

Tes update tanggal_disetujui kasbon dengan kasbon yang sudah disetujui.


### test_patch_setujui_kasbon_tanggal_disetujui_is_not_null

Tes update tanggal_disetujui kasbon dengan kasbon yang sudah disetujui.


### test_kasbon_setujui_masal

Tes setujui kasbon secara masal.


### test_kasbon_setujui_masal_job_dispatched

Tes setujui kasbon secara masal dan mengecek job queue berjalan.



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
