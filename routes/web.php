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

// Route::get('/index', 'MovimentacaoController@index');

Route::get('/index', function () {
    return redirect('/faturamento');
});

Route::get('/representantes', 'AgentsController@get');
Route::get('/configurar-comissoes', 'SettingsController@index');
Route::get('/percentual-comissao', 'PercentualComissaoController@index');
Route::get('/tipos-pedido', 'TiposPedidoController@index');
Route::get('/tipos-pgto', 'TiposPgtoController@index');
Route::get('/consulta-produtos/{cod_operacao}', 'ProdutosController@get');

Route::post('/desconsidera-movimento-faturamento', 'MovimentacaoController@desconsidera');
Route::post('/desconsidera-titulo-liquidacao', 'LiquidacaoController@desconsidera');
Route::post('/export-excel-faturamento', 'ExcelMovimentacaoController@exportExcel')->name('export-excel');
Route::post('/export-excel-liquidacao', 'ExcelLiquidacaoController@exportExcel')->name('export-excel');
Route::post('/export-excel-produtos', 'ExcelProdutosController@exportExcel')->name('export-excel');
Route::post('/configurar-comissoes-salvar', 'SettingsController@set');
Route::post('/percentual-comissao-salvar', 'PercentualComissaoController@salvar');
Route::post('/tipos-pedido-salvar', 'TiposPedidoController@salvar');
Route::post('/tipos-pgto-salvar', 'TiposPgtoController@salvar');

//faturamento
Route::get('/faturamento', 'MovimentacaoController@index');
Route::match(['get', 'post'], '/consulta-faturamento', 'MovimentacaoController@get')->name('consulta-faturamento');

//liquidacao
Route::get('/liquidacao', 'LiquidacaoController@index');
Route::match(['get', 'post'], '/consulta-liquidacao', 'LiquidacaoController@get')->name('consulta-liquidacao');
// Route::get('/liquidacao/{agent?}', 'LiquidacaoController@getLiquidacao');

//devolucao
Route::get('/devolucao', 'DevolucaoController@index');
Route::match(['get', 'post'], '/consulta-devolucao', 'DevolucaoController@get')->name('consulta-devolucao');

//substituicao
Route::get('/substituicao/{agent?}', 'LiquidacaoController@getSubstituicao');

//devolucao
// Route::get('/devolucao/{search_agent?}', 'DevolucaoController@getDevolucao');
// Route::post('/consulta-devolucao', 'DevolucaoController@getDevolucao');

//Language Translation
Route::get('index/{locale}', 'HomeController@lang');

//Socialite 
// Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
// Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');

Route::get('/', 'HomeController@root');
