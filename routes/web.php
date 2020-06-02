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

Route::get('/','HomeController@index')->middleware('auth');

Route::get('home','HomeController@index')->middleware('auth');

Route::resource('clientes','ClienteController')->middleware('auth');
Route::resource('torres','TorresController')->middleware('auth');
Route::resource('sectores', 'SectoresController')->middleware('auth');
Route::resource('paquetes','PaquetesController')->middleware('auth');
Route::resource('pagos/agregarpago','AddPayController')->middleware('auth');
Route::resource('pagos/reportepagos','ReporteController')->middleware('auth');
Route::resource('pagos','PagosController')->middleware('auth');

Auth::routes();

#Route::get('/home', 'HomeController@index')->name('home');
