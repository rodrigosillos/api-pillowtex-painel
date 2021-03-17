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

Auth::routes();

// Route::get('{any}', 'HomeController@index');

Route::get('/index', 'DashboardController@index');
Route::get('/comissoes', 'CommissionsController@index');
Route::get('/representantes', 'CommissionsController@getAgents');
Route::get('/configurar-comissoes', 'SettingsController@index');
Route::post('/configurar-comissoes-salvar', 'SettingsController@set');
Route::post('/consulta-comissoes', 'CommissionsController@getInvoices');
Route::get('/consulta-produtos/{document}', 'CommissionsController@detailInvoice');
Route::get('/consulta-titulos/{operation_code}', 'CommissionsController@getDebtors');

//Language Translation
Route::get('index/{locale}', 'HomeController@lang');

//Socialite 
// Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
// Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');

Route::get('/', 'HomeController@root');