<?php

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

URL::forceScheme(env('APP_ENV')=='prod' ? 'https' : 'http');

Auth::routes();
Route::post('/login/logar','Auth\LoginController@attemptLogin');
Route::get('/logout','Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/ativacoes','AtivadoController');

Route::resource('/licencas','LicencaController');
Route::get('/licencas/busca/{key}/{idmaquina}','LicencaController@getFreeKey');
Route::get('/licencas/download/{file}','LicencaController@getFile');

Route::resource('/maquinas','MaquinaController');

Route::resource('/setores','SetorController');
Route::get('/setores/busca/{key}','SetorController@busca');

Route::resource('/tipos','TipoController');
