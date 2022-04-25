<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class ProdutosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get(Request $request)
    {
        $codOperacao = $request->cod_operacao;
        
        $movimentacao = DB::table('movimentacao')
        ->select(['tabela', 'cliente_estado', 'tipo_pedido', 'tipo_operacao'])
        ->where('cod_operacao', $codOperacao)
        ->first();

        $tabela = $movimentacao->tabela;
        $clienteEstado = $movimentacao->cliente_estado;
        $tipoPedido = $movimentacao->tipo_pedido;
        $tipoOperacao = $movimentacao->tipo_operacao;

        $produtoData = [
            'produtos' => [],
            'totalizador' => [
                'total_pecas' => 0,
                'valor_comissao' => 0,
                'valor_total' => 0,
            ],
        ];
        
        $produtos = DB::table('produtos')
        ->where('cod_operacao', $codOperacao)
        ->get();

        foreach($produtos as $produtoChave => $produtoAtrib) {

            $produtoData['produtos'][$produtoChave]['id'] = $produtoAtrib->id;
            $produtoData['produtos'][$produtoChave]['pedido'] = $produtoAtrib->pedido;
            $produtoData['produtos'][$produtoChave]['nota'] = $produtoAtrib->nota;
            $produtoData['produtos'][$produtoChave]['produto'] = $produtoAtrib->produto;
            $produtoData['produtos'][$produtoChave]['produto_codigo'] = $produtoAtrib->cod_produto;
            $produtoData['produtos'][$produtoChave]['produto_nome'] = $produtoAtrib->descricao1;
            $produtoData['produtos'][$produtoChave]['quantidade'] = $produtoAtrib->quantidade;
            $produtoData['produtos'][$produtoChave]['preco'] = $produtoAtrib->preco;
            $produtoData['produtos'][$produtoChave]['desconto'] = $produtoAtrib->desconto;
            $produtoData['produtos'][$produtoChave]['produto_comissao'] = $produtoAtrib->valor_comissao;
            $produtoData['produtos'][$produtoChave]['produto_comissao_percentual'] = sprintf("%.2f%%", $produtoAtrib->percentual_comissao);
            $produtoData['produtos'][$produtoChave]['produto_divisao'] = $produtoAtrib->descricao_divisao;

            $produtoData['totalizador']['total_pecas'] += $produtoAtrib->quantidade;
            $produtoData['totalizador']['valor_comissao'] += $produtoAtrib->valor_comissao;
            $produtoData['totalizador']['valor_total'] += ($produtoAtrib->preco * $produtoAtrib->quantidade);

        }

        return view('produtos', 
        [
            'data' => $produtoData,
        ]);
    }

}
