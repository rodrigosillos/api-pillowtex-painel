<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use View;

class TiposPedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $retorno = [
            'data' => []];
        
        $tiposPedido = DB::table('tipos_pedido')->get();

        foreach($tiposPedido as $key => $value) {

            $retorno['data'][$key]['tipo_pedido'] = $value->tipo_pedido;
            $retorno['data'][$key]['descricao'] = $value->descricao;
            $retorno['data'][$key]['oculto'] = $value->oculto;
        }

        return View::make('tipos-pedido', $retorno);
    }

    public function salvar(Request $request)
    {
        DB::table('tipos_pedido')->truncate();

        $data = $request->get('group-a');

        foreach($data as $item) {

            DB::table('tipos_pedido')->insert([
                'tipo_pedido' => $item['tipo_pedido'],
                'descricao' => $item['descricao'],
                'oculto' => isset($item['oculto'][0]) ? $item['oculto'][0] : 0,
            ]);
        
        }

        return redirect()->action([TiposPedidoController::class, 'index']);

    }
}