<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
// Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('user.home');

Route::get('/produk', 'ProdukController@index')->name('user.produk');
Route::get('/produk/{slug}', 'ProdukController@detail')->name('user.produk.detail');



Route::middleware(['auth'])
    ->group(function(){
        

        Route::post('/produk/keranjang/{id}', 'ProdukController@addKeranjang')->name('user.produk.addKeranjang');

        Route::get('/profil', 'ProfilController@index')->name('user.profil');
        Route::put('/profil/updateData', 'ProfilController@updateData')->name('user.profil.updateData');
        Route::put('/profil/updateFoto', 'ProfilController@updateFoto')->name('user.profil.updateFoto');
        Route::post('/profil/updatePassword', 'ProfilController@updatePassword')->name('user.profil.updatePassword');
        
        Route::get('/keranjang', 'KeranjangController@index')->name('user.keranjang');
        Route::post('/keranjang/checkout', 'KeranjangController@checkout')->name('user.keranjang.checkout');
        Route::put('/keranjang/{id}', 'KeranjangController@updateQty')->name('user.keranjang.updateQty');
        Route::delete('/keranjang/{id}', 'KeranjangController@deleteCart')->name('user.keranjang.deleteCart');
        

        Route::get('/pesanan', 'PesananController@index')->name('user.pesanan');
        Route::get('/pesanan/cetakInvoice/{id}', 'PesananController@cetakInvoice')->name('user.pesanan.cetakInvoice');
        Route::put('/pesanan/batal/{id}', 'PesananController@batal')->name('user.pesanan.batal');
        Route::put('/pesanan/selesai/{id}', 'PesananController@selesai')->name('user.pesanan.selesai');


        Route::get('/point-saya', 'PointController@index')->name('user.point');

        Route::get('/tukar-point', 'TukarpointController@index')->name('user.tukarPoint');
        Route::put('/tukar-point/ambil/{id}', 'TukarpointController@ambil')->name('user.tukarPoint.ambil');


        Route::middleware(['isAdmin'])
            ->group(function(){
                Route::resource('admin/dashboard', 'Admin\DashboardController', [
                    'as' => 'admin'
                ]);

                Route::post('admin/produk/setStatus', 'Admin\ProductController@setStatus')->name('admin.produk.setStatus');
                Route::post('admin/produk/hapusGambar', 'Admin\ProductController@hapusGambar')->name('admin.produk.hapusGambar');
                Route::resource('admin/produk', 'Admin\ProductController', [
                    'as' => 'admin'
                ]);

                Route::get('admin/laporan', 'Admin\LaporanController@index')->name('admin.laporan.index');

                Route::get('admin/pesanan/cetakInvoice/{id}', 'Admin\PesananController@cetakInvoice')->name('admin.pesanan.cetakInvoice');
                Route::put('admin/pesanan/batal/{id}', 'Admin\PesananController@batal')->name('admin.pesanan.batal');
                Route::post('admin/pesanan/addongkir/{id}', 'Admin\PesananController@addongkir')->name('admin.pesanan.addongkir');
                Route::post('admin/pesanan/kirim/{id}', 'Admin\PesananController@kirim')->name('admin.pesanan.kirim');
                Route::put('admin/pesanan/selesai/{id}', 'Admin\PesananController@selesai')->name('admin.pesanan.selesai');
                Route::put('admin/pesanan/konfirmasi/{id}', 'Admin\PesananController@konfirmasi')->name('admin.pesanan.konfirmasi');
                Route::put('admin/pesanan/bayar/{id}', 'Admin\PesananController@bayar')->name('admin.pesanan.bayar');
                Route::resource('admin/pesanan', 'Admin\PesananController', [
                    'as' => 'admin'
                ]);


                Route::get('admin/point-reseller', 'Admin\PointresellerController@index')->name('admin.point-reseller');
                Route::get('admin/point-reseller/riwayat', 'Admin\PointresellerController@riwayat')->name('admin.point-reseller.riwayat');
               
                Route::resource('admin/point', 'Admin\PointController', [
                    'as' => 'admin'
                ]);

                Route::resource('admin/pelanggan', 'Admin\PelangganController', [
                    'as' => 'admin'
                ]);


                Route::post('admin/profil/updatePassword', 'Admin\ProfilController@updatePassword')->name('admin.profil.updatePassword');
                Route::post('admin/profil/ubahFoto', 'Admin\ProfilController@ubahFoto')->name('admin.profil.ubahFoto');
                Route::resource('admin/profil', 'Admin\ProfilController', [
                    'as' => 'admin'
                ]);
            });
    });
