<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\memberController;
use App\Http\Controllers\paketController;
use App\Http\Controllers\transaksiController;
use App\Http\Controllers\detailtransaksiController;
use App\Http\Controllers\outletController;
use App\Http\Controllers\dasboardController;

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
Route::post('login', 'AuthController@login');

Route::group(['middleware' => ['jwt.verify:admin,kasir,owner']], function(){
    Route::get('login/check', 'AuthController@loginCheck');
    Route::post('/logout',       'AuthController@logout');

    //MEMBER
    Route::post('member', 'MemberController@store');
    Route::get('member', 'MemberController@getAll');
    Route::get('member/{id}', 'MemberController@getdata');
    Route::put('member/{id}', 'MemberController@update');
    Route::delete('member/{id}', 'MemberController@delete');

    Route::post('report', 'transaksiController@report');

    Route::get('dashboard', 'dasboardController@index');
});


    
Route::group(['middleware' => ['jwt.verify:admin']], function(){
    //PAKET
    Route::post('paket', 'PaketController@store');
    Route::get('paket', 'PaketController@getAll');
    Route::get('paket/{id}', 'PaketController@getById');
    Route::put('paket/{id}', 'PaketController@update');
    Route::delete('paket/{id}', 'PaketController@delete');
});

Route::group(['middleware' => ['jwt.verify:admin,kasir']], function () {
    //OUTLET
    Route::post('outlet', 'OutletController@store');
    Route::get('outlet', 'OutletController@getAll');
    Route::get('outlet/{id}', 'OutletController@getById');
    Route::put('outlet/{id}', 'OutletController@update');
    Route::delete('outlet/{id}', 'OutletController@delete');

    //user
    Route::post('user', 'UserController@store');
    Route::get('user', 'UserController@getAll');
    Route::get('user/{id}', 'UserController@getById');
    Route::put('user/{id}', 'UserController@update');
    Route::delete('user/{id}', 'UserController@delete');

    //DETAIL TRANSAKSI
        Route::post('detail/tambah', 'detail_transaksiController@store');
        Route::get('detail/{id}', 'detail_transaksiController@getById');
        Route::get('detail/total/{id}', 'detail_transaksiController@getTotal');

        //TRANSAKSI
    Route::post('transaksi', 'transaksiController@store');
    Route::get('transaksi', 'transaksiController@getAll');
    Route::get('transaksi/{id}', 'transaksiController@getById');
    Route::post('transaksi/{id}', 'transaksiController@changeStatus');
    Route::post('transaksi/bayar/{id}', 'transaksiController@bayar');
});
