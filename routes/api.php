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
Route::get('/email/resend', 'Api\VerificationController@resend')->name('verification.resend');;
Route::get('/email/verify/{id}/{hash}', 'Api\VerificationController@verify')->name('verification.verify');

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {
    Route::post('logout', 'UserController@logout');

    Route::get('user', 'UserController@index');
    Route::post('user', 'UserController@store');
    Route::post('user/{id}', 'UserController@update');
    Route::delete('user/{id}', 'UserController@destroy');

    Route::get('role', 'RoleController@index');
    Route::post('role', 'RoleController@store');
    Route::post('role/{id}', 'RoleController@update');
    Route::delete('role/{id}', 'RoleController@destroy');

    Route::get('profil', 'ProfilController@index');
    Route::post('profil', 'ProfilController@update');
    Route::delete('profil', 'ProfilController@destroy');

    Route::get('kategori', 'KategoriController@index');
    Route::post('kategori', 'KategoriController@store');
    Route::post('kategori/{id}', 'KategoriController@update');
    Route::delete('kategori/{id}', 'KategoriController@destroy');

    Route::get('barang', 'BarangController@index');
    Route::post('barang', 'BarangController@store');
    Route::post('barang/{id}', 'BarangController@update');
    Route::delete('barang/{id}', 'BarangController@destroy');

    Route::get('supplier', 'SupplierController@index');
    Route::get('supplier/{id}', 'SupplierController@show');
    Route::post('supplier', 'SupplierController@store');
    Route::post('supplier/{id}', 'SupplierController@update');
    Route::delete('supplier/{id}', 'SupplierController@destroy');

    Route::get('member', 'MemberController@index');
    Route::post('member', 'MemberController@store');
    Route::post('member/{id}', 'MemberController@update');
    Route::delete('member{id}', 'MemberController@destroy');

    Route::get('pengeluaran', 'PengeluaranController@index');
    Route::post('pengeluaran', 'PengeluaranController@store');
    Route::post('pengeluaran/{id}', 'PengeluaranController@update');
    Route::delete('pengeluaran{id}', 'PengeluaranController@destroy');

    Route::get('penjualan', 'PenjualanController@index');
    Route::post('penjualan', 'PenjualanController@store');
    Route::post('penjualan/{id}', 'PenjualanController@update');
    Route::delete('penjualan{id}', 'PenjualanController@destroy');

    Route::get('pembelian', 'PembelianController@index');
    Route::post('pembelian', 'PembelianController@store');
    Route::post('pembelian/{id}', 'PembelianController@update');
    Route::delete('pembelian{id}', 'PembelianController@destroy');
});
