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

    // Route::resource('profil', 'ProfilController');
    Route::post('profil', 'ProfilController@update');

    Route::resource('kategori', 'KategoriController');

    Route::resource('barang', 'BarangController');

    Route::resource('supplier', 'SupplierController');

    Route::resource('member', 'MemberController');

    Route::resource('pengeluaran', 'PengeluaranController');

    Route::resource('penjualan', 'PenjualanController');

    Route::resource('pembelian', 'PembelianController');
});
