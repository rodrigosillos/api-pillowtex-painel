<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App;

class CommissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $client = new Client();

        $user = "consultoria";
        $pass = "Consult#2020";

        // search
        $operation_code = 500615;
        $search_response = $client->request('GET', 'http://pillowtex.bugbusters.me:6017/api/millenium/movimentacao/consulta?tipo_operacao=S&cod_operacao='.$operation_code.'&ujuros=false&$format=json', [
            'auth' => [$user, $pass]
        ]);
        $search_data = json_decode($search_response->getBody()->getContents(), true);

        // agent
        $agent_id = $search_data['value'][0]['representante'];
        $agent_response = $client->request('GET', 'http://pillowtex.bugbusters.me:6017/api/millenium/representantes/consulta?representante='.$agent_id.'&$format=json', [
            'auth' => [$user, $pass]
        ]);
        $agent_data = json_decode($agent_response->getBody()->getContents(), true);
        $search_data['value'][0]['representante_nome'] = $agent_data['value'][0]['geradores'][0]['nome'];

        // client
        $client_id = $search_data['value'][0]['cliente'];
        $client_response = $client->request('GET', 'http://pillowtex.bugbusters.me:6017/api/millenium/clientes/consulta?cliente='.$client_id.'&$format=json', [
            'auth' => [$user, $pass]
        ]);
        $client_data = json_decode($client_response->getBody()->getContents(), true);
        $search_data['value'][0]['cliente_nome'] = $client_data['value'][0]['geradores'][0]['nome'];

        // commission
        $table_id = $search_data['value'][0]['tabela'];
        $client_state = $client_data['value'][0]['geradores'][0]['ufie'];

        $commission_percentage = 8;
        $commission_amount = 0;
        $search_data['value'][0]['comissao_total'] = 0;

        foreach($search_data['value'][0]['produtos'] as $key => $product)
        {
            $product_id = $product['produto'];
            $product_qty = $product['quantidade'];
            $product_discount = $product['desconto'];
            $product_price = $product['preco'];

            // product data
            $product_response = $client->request('GET', 'http://pillowtex.bugbusters.me:6017/api/millenium/produtos/consulta?produto='.$product_id.'&$format=json', [
                'auth' => [$user, $pass]
            ]);
            $product_data = json_decode($product_response->getBody()->getContents(), true);
            $product_name = $product_data['value'][0]['descricao1'];
            $division_id = $product_data['value'][0]['divisao'];

            // product division data
            $product_response = $client->request('GET', 'http://pillowtex.bugbusters.me:6017/api/millenium/divisoes/consulta?divisao='.$division_id.'&$format=json', [
                'auth' => [$user, $pass]
            ]);
            $product_division_data = json_decode($product_response->getBody()->getContents(), true);
            $division_code = $product_division_data['value'][0]['cod_divisao'];

            // database table
            $division_db_table = [
                '0004' => 7, 
                '0003' => 7,
                'P01'  => 6,
                '007'  => 6,
                '009'  => 6,
                '012'  => 6,
                '014'  => 6,
                '008'  => 4,
                '011'  => 4,
                '010'  => 4,
                '016'  => 4,
                '017'  => 4,
                '018'  => 4,
                '019'  => 4,
            ];

            $division_key = array_search($division_code, $division_db_table);

            if($division_key)
                $commission_percentage = $division_db_table[$division_key];

            $table_code = 214;

            // table 214 (ID 4)
            if($table_id == 4)
            {
                $table_code = 214;

                if($product_discount > 5)
                {
                    $commission_amount = ($commission_amount / 2);
                }
                
            }

            // table 187 (ID 216)
            if($table_id == 216)
            {
                $commission_percentage = 6;
                $table_code = 187;

                if($client_state != 'SP' && $product_discount < 5)
                    $commission_percentage = 4;
            }

            // commission amout
            $commission_amount = ($product_price * $product_qty) * $commission_percentage;

            $search_data['value'][0]['comissao_total'] += $commission_amount;
            $search_data['value'][0]['tabela_preco'] = $table_code;

            // product data add
            $search_data['value'][0]['produtos'][$key]['produto_nome'] = $product_name;
            $search_data['value'][0]['produtos'][$key]['produto_comissao'] = $commission_amount;
        }

        return view('tables-datatable-commissions', ['data' => $search_data]);
    }
}
