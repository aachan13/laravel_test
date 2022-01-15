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
   cd project
   composer install
   setup env
   php artisan key:generate
   php artisan migrate
   php artisan test
 ```

## Daftar Tes 

Terdapat total 48 tes di dalam projek ini.


### test_get_pegawai

Tes akses endpoint api pegawai.


### test_get_pegawai_pagination

Tes pagination api pegawai.


### test_pegawai_pagination_with_page

Tes pagination dengan tambahan request ```page```.


### test_pegawai_pagination_with_page_not_integer

Tes pagination dengan request ```page``` bukan **integer**.


### test_pegawai_pagination_with_page_null

Tes pagination dengan request ```page``` kosong atau null.


### test_pegawai_pagination_with_page_null

Tes pagination dengan request ```page``` kosong atau null.


### test_uppercase_nama_pegawai

Tes nama pegawai pada response adalah huruf besar semua.


### test_first_name_nama_pegawai

Tes nama pegawai pada response adalah nama pertama (Cth: Achmad Fadhil = Achmad).


### test_format_tanggal_masuk_pegawai

Tes format tanggal_masuk pegawai pada response adalah DD-MMMM-YYYY (id).


### test_format_gaji_pegawai

Tes format total_gaji pegawai pada response adalah #.### (ribuan).





## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
