<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use View;

class PercentualComissaoController extends Controller
{
    public function index(Request $request)
    {
        $retornoPercentual = [
            'data' => []];
        
        $percentuaisComissao = DB::table('percentual_comissao')->get();

        foreach($percentuaisComissao as $percentualKey => $percentualValue) {

            $retornoPercentual['data'][$percentualKey]['tabela'] = $percentualValue->tabela;
            $retornoPercentual['data'][$percentualKey]['cod_divisao'] = $percentualValue->cod_divisao;
            $retornoPercentual['data'][$percentualKey]['descricao_divisao'] = $percentualValue->descricao_divisao;
            $retornoPercentual['data'][$percentualKey]['percentual_comissao'] = $percentualValue->percentual_comissao;
        }

        return View::make('percentual-comissao', $retornoPercentual);
    }

    public function salvar(Request $request)
    {
        DB::table('percentual_comissao')->truncate();

        $data = $request->get('group-a');

        foreach($data as $percentual) {

            if(!empty($percentual['cod_divisao']) && !empty($percentual['tabela'])) {

                DB::table('percentual_comissao')->insert([
                    'tabela' => $percentual['tabela'],
                    'cod_divisao' => $percentual['cod_divisao'],
                    'descricao_divisao' => $percentual['descricao_divisao'],
                    'percentual_comissao' => $percentual['percentual_comissao'],
                ]);

            }
        }

        return redirect()->action([PercentualComissaoController::class, 'index']);

    }
}
