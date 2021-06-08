<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::get('/comissoes', 'InvoicesController@index');
Route::get('/representantes', 'AgentsController@get');
Route::get('/configurar-comissoes', 'SettingsController@index');
Route::get('/consulta-produtos/{operation_code}', 'InvoiceDetailsController@get');
Route::get('/consulta-titulos/{operation_code?}', 'DebtorsController@get');

Route::post('/export-excel', 'ExcelController@exportExcel')->name('export-excel');
Route::post('/configurar-comissoes-salvar', 'SettingsController@set');
Route::post('/consulta-comissoes', 'InvoicesController@get');


//Language Translation
Route::get('index/{locale}', 'HomeController@lang');

//Socialite 
// Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
// Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');

Route::get('/', 'HomeController@root');
