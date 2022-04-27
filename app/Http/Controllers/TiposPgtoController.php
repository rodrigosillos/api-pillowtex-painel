<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use View;

class TiposPgtoController extends Controller
{
    public function index(Request $request)
    {
        $retorno = [
            'data' => []
        ];
        
        $tiposPgto = DB::table('tipos_pgto')->get();

        foreach($tiposPgto as $key => $value) {

            $retorno['data'][$key]['tipo_pgto'] = $value->tipo_pgto;
            $retorno['data'][$key]['descricao'] = $value->descricao;
            $retorno['data'][$key]['oculto'] = $value->oculto;
        }

        return View::make('tipos-pgto', $retorno);
    }

    public function salvar(Request $request)
    {
        DB::table('tipos_pgto')->truncate();

        $data = $request->get('group-a');

        foreach($data as $item) {

            // if(!empty($percentual['cod_divisao']) && !empty($percentual['tabela'])) {

                DB::table('tipos_pgto')->insert([
                    'tipo_pgto' => $item['tipo_pgto'],
                    'descricao' => $item['descricao'],
                    'oculto' => $item['oculto'],
                ]);

            // }
        }

        return redirect()->action([TiposPgtoController::class, 'index']);

    }
}
