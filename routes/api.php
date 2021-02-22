<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');
Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Api\ResetPasswordController@reset');
Route::get('/email/resend', 'Api\VerificationController@resend')->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', 'Api\VerificationController@verify')->name('verification.verify');

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {
    Route::post('logout', 'UserController@logout');

    Route::get('supplier', 'SupplierController@index')->middleware('role:admin|pimpinan|staff');
    Route::get('supplier/{id}', 'SupplierController@show')->middleware('role:admin|pimpinan|staff');
    Route::post('supplier', 'SupplierController@store')->middleware('role:admin|staff');
    Route::post('supplier/{id}', 'SupplierController@update')->middleware('role:admin|staff');
    Route::delete('supplier/{id}', 'SupplierController@destroy')->middleware('role:admin|staff');

    Route::get('kategori', 'KategoriController@index');
    Route::post('kategori', 'KategoriController@store')->middleware('role:admin|staff');
    Route::post('kategori/{id}', 'KategoriController@update')->middleware('role:admin|staff');
    Route::delete('kategori/{id}', 'KategoriController@destroy')->middleware('role:admin|staff');

    Route::get('barang/search/{data}', 'BarangController@search');
    Route::get('barang', 'BarangController@index');
    Route::get('barang/uid/{uid}', 'BarangController@uid');
    Route::get('barang/{id}', 'BarangController@show');
    Route::post('barang', 'BarangController@store')->middleware('role:admin|staff');
    Route::post('barang/{id}', 'BarangController@update')->middleware('role:admin|staff');
    Route::delete('barang/{id}', 'BarangController@destroy')->middleware('role:admin|staff');

    Route::get('kasir', 'KasirController@index')->middleware('role:admin|pimpinan');
    Route::get('kasir/{id}', 'KasirController@show')->middleware('role:admin|pimpinan');
    Route::post('kasir', 'KasirController@store')->middleware('role:admin|pimpinan');
    Route::post('kasir/{id}', 'KasirController@update')->middleware('role:admin|pimpinan');
    Route::delete('kasir/{id}', 'KasirController@destroy')->middleware('role:admin|pimpinan');

    Route::get('profil', 'ProfilController@index');
    Route::post('profil', 'ProfilController@update');
    Route::post('profil/password', 'ProfilController@change');
    Route::delete('profil', 'ProfilController@destroy');

    Route::get('user', 'UserController@index')->middleware('role:admin');
    Route::post('user', 'UserController@store')->middleware('role:admin');
    Route::post('user/{id}', 'UserController@update')->middleware('role:admin');
    Route::delete('user/{id}', 'UserController@destroy')->middleware('role:admin');


    Route::get('member', 'MemberController@index')->middleware('role:admin|pimpinan|kasir');
    Route::get('member/kode_member/{kode_member}', 'MemberController@kodeMember')->middleware('role:admin|pimpinan|kasir');
    Route::get('member/{id}', 'MemberController@show')->middleware('role:admin|pimpinan|kasir');
    Route::get('member/{id}/saldo', 'MemberController@saldo')->middleware('role:admin|kasir|pimpinan|member');
    Route::post('member/{id}/topup', 'MemberController@topup')->middleware('role:admin|kasir');
    Route::post('member', 'MemberController@store')->middleware('role:admin|kasir');
    Route::post('member/{id}', 'MemberController@update')->middleware('role:admin|kasir');
    Route::delete('member/{id}', 'MemberController@destroy')->middleware('role:admin|kasir');

    Route::get('pengeluaran', 'PengeluaranController@index')->middleware('role:admin|pimpinan');
    Route::post('pengeluaran', 'PengeluaranController@store')->middleware('role:admin|pimpinan');
    Route::post('pengeluaran/{id}', 'PengeluaranController@update')->middleware('role:admin|pimpinan');
    Route::delete('pengeluaran/{id}', 'PengeluaranController@destroy')->middleware('role:admin|pimpinan');

    Route::get('pembelian', 'PembelianController@index')->middleware('role:admin|pimpinan|staff');
    Route::post('pembelian', 'PembelianController@store')->middleware('role:admin|staff');
    Route::post('pembelian/{id}', 'PembelianController@update')->middleware('role:admin|staff');
    Route::delete('pembelian/{id}', 'PembelianController@destroy')->middleware('role:admin|staff');

    Route::get('penjualan/dibayar', 'PenjualanController@dibayar')->middleware('role:admin|pimpinan|kasir');
    Route::get('penjualan/belumbayar', 'PenjualanController@belumbayar')->middleware('role:admin|pimpinan|kasir');
    Route::get('penjualan/{id}', 'PenjualanController@show')->middleware('role:admin|kasir|pimpinan');
    Route::post('penjualan', 'PenjualanController@store')->middleware('role:admin|kasir');
    Route::post('penjualan/{id}', 'PenjualanController@update')->middleware('role:admin|kasir');
    Route::delete('penjualan/{id}', 'PenjualanController@destroy')->middleware('role:admin|kasir');
    Route::get('detailpenjualan/request', 'DetailPenjualanController@request')->middleware('role:admin|pimpinan|kasir');
    Route::post('detailpenjualan/confirm', 'DetailPenjualanController@confirm')->middleware('role:admin|kasir');

    Route::get('role', 'RoleController@index')->middleware('role:admin');
    Route::post('role', 'RoleController@store')->middleware('role:admin');
    Route::post('role/{id}', 'RoleController@update')->middleware('role:admin');
    Route::delete('role/{id}', 'RoleController@destroy')->middleware('role:admin');

    Route::get('laporan', 'LaporanController@index')->middleware('role:admin|pimpinan');

    Route::get('absent', 'AbsentController@absent')->middleware('role:admin|pimpinan');

});
