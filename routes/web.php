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

Route::get('/', function () {
    return view('dashbord');
});

Route::get('home', function () {
    return view('dashbord');
})->name("home.index");

Route::resource('clientes','ClienteController');
Route::resource('torres','TorresController');
Route::resource('sectores', 'SectoresController');
Route::resource('paquetes','PaquetesController');
Route::resource('pagos/agregarpago','AddPayController');
Route::resource('pagos/reportepagos','ReporteController');
Route::resource('pagos','PagosController');
