<?php

use App\Business;
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
Route::get('enviarmsj','ClienteController@getSeendMsjView');
Route::post('enviarmsj','ClienteController@seendMsj');
Route::get('emby','ClienteController@getGenEmbyUserView');
Route::post('genembyusr','ClienteController@genEmbyUser');
Route::resource('torres','TorresController')->middleware('auth');
Route::resource('sectores', 'SectoresController')->middleware('auth');
Route::resource('paquetes','PaquetesController')->middleware('auth');

Route::post("pagos/data","PagosController@data")->name("pagos.data");
Route::post("reportepagos.data","ReporteController@data")->name("reportepagos.data");

Route::resource('pagos/agregarpago','AddPayController')->middleware('auth');
Route::resource('pagos/reportepagos','ReporteController')->middleware('auth');
Route::resource('pagos','PagosController')->middleware('auth');
Route::resource('tickets','TicketsController')->middleware('auth');
Route::resource('compras','ComprasController')->middleware('auth');
Route::resource('ingresos','IngresosController')->middleware('auth');
Route::resource('egresos','EgresosController')->middleware('auth');
Route::resource('configuracion','ConfiguracionController')->middleware('auth');
Route::get('verpago/{id}',"PagosController@verPago");
Route::get('routers','RouterController@getRouterView')->name("router.index");
Route::post("routers/verificarCredencialesRouter",'RouterController@verificarCredencialesRouter')->name("router.validar");
Auth::routes();

#Route::get('/home', 'HomeController@index')->name('home');
