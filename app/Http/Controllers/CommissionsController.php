<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App;
use Carbon\Carbon;

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

        $table_code = 214;

        if($table_id == 4)
            $table_code = 214;

        if($table_id == 216)
            $table_code = 187;

        $commission_percentage = 8;
        $commission_amount = 0;
        $search_data['value'][0]['comissao_total'] = 0;

        function searchForId($division, $table, $array) {
            foreach ($array as $key => $val) {
                if ($val['division'] == $division && $val['table'] == $table) {
                    return $key;
                }
            }
            return null;
        }

        // database table division
        $division_db = [
            [
                'division' => '001',
                'table' => '214',
                'percentage' => 8,
            ],
            [
                'division' => '001',
                'table' => '187',
                'percentage' => 6,
            ],
            [
                'division' => '002',
                'table' => '214',
                'percentage' => 8,
            ],
            [
                'division' => '002',
                'table' => '187',
                'percentage' => 6,
            ],
            [
                'division' => '003',
                'table' => '214',
                'percentage' => 7.04,
            ],
            [
                'division' => '003',
                'table' => '187',
                'percentage' => 6,
            ],
            [
                'division' => '004',
                'table' => '214',
                'percentage' => 7.04,
            ],
            [
                'division' => '004',
                'table' => '187',
                'percentage' => 6,
            ],
            [
                'division' => '005',
                'table' => '214',
                'percentage' => 0,
            ],
            [
                'division' => '005',
                'table' => '187',
                'percentage' => 0,
            ],
            [
                'division' => '007',
                'table' => '214',
                'percentage' => 7,
            ],
            [
                'division' => '007',
                'table' => '187',
                'percentage' => 7,
            ],
            [
                'division' => '008',
                'table' => '214',
                'percentage' => 4,
            ],
            [
                'division' => '008',
                'table' => '187',
                'percentage' => 4,
            ],
            [
                'division' => '009',
                'table' => '214',
                'percentage' => 6,
            ],
            [
                'division' => '009',
                'table' => '187',
                'percentage' => 6,
            ],
            [
                'division' => '010',
                'table' => '214',
                'percentage' => 4,
            ],
            [
                'division' => '010',
                'table' => '187',
                'percentage' => 4,
            ],
            [
                'division' => '011',
                'table' => '214',
                'percentage' => 4,
            ],
            [
                'division' => '011',
                'table' => '187',
                'percentage' => 4,
            ],
            [
                'division' => '012',
                'table' => '214',
                'percentage' => 6,
            ],
            [
                'division' => '012',
                'table' => '187',
                'percentage' => 6,
            ],
            [
                'division' => '013',
                'table' => '214',
                'percentage' => 4,
            ],
            [
                'division' => '013',
                'table' => '187',
                'percentage' => 4,
            ],
            [
                'division' => '014',
                'table' => '214',
                'percentage' => 6,
            ],
            [
                'division' => '014',
                'table' => '187',
                'percentage' => 6,
            ],
            [
                'division' => '017',
                'table' => '214',
                'percentage' => 4,
            ],
            [
                'division' => '017',
                'table' => '187',
                'percentage' => 4,
            ],
            [
                'division' => '020',
                'table' => '214',
                'percentage' => 6,
            ],
            [
                'division' => '020',
                'table' => '187',
                'percentage' => 6,
            ],
            [
                'division' => '021',
                'table' => '214',
                'percentage' => 8,
            ],
            [
                'division' => '021',
                'table' => '187',
                'percentage' => 8,
            ],
            [
                'division' => '022',
                'table' => '214',
                'percentage' => 7,
            ],
            [
                'division' => '022',
                'table' => '187',
                'percentage' => 7,
            ],
            [
                'division' => 'L01',
                'table' => '214',
                'percentage' => 0,
            ],
            [
                'division' => 'L01',
                'table' => '187',
                'percentage' => 0,
            ],
            [
                'division' => 'indefinido',
                'table' => '214',
                'percentage' => 0,
            ],
            [
                'division' => 'indefinido',
                'table' => '187',
                'percentage' => 0,
            ],
        ];

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
            $division_description = $product_division_data['value'][0]['descricao'];

            $division_key = searchForId($division_code, $table_code, $division_db);

            if($division_key)
                $commission_percentage = $division_db[$division_key]['percentage'];

            if($table_code == 214) {
                if($product_discount > 5)
                    $commission_amount = ($commission_amount / 2);
            }

            if($table_code == 187) {
                if($client_state != 'SP' && $product_discount < 5)
                    $commission_percentage = 4;
            }

            // commission amout
            $commission_amount = floor(($product_price * $product_qty) * $commission_percentage) / 100;

            $search_data['value'][0]['comissao_total'] += $commission_amount;
            $search_data['value'][0]['tabela_preco'] = $table_code;
            $search_data['value'][0]['cliente_estado'] = $client_state;
            $search_data['value'][0]['data'] = Carbon::createFromTimestamp($search_data['value'][0]['data'])->toDateTimeString(); ;

            // product data add
            $search_data['value'][0]['produtos'][$key]['produto_nome'] = $product_name;
            $search_data['value'][0]['produtos'][$key]['produto_comissao'] = $commission_amount;
            $search_data['value'][0]['produtos'][$key]['produto_comissao_percentual'] = sprintf("%.2f%%", $commission_percentage);
            $search_data['value'][0]['produtos'][$key]['produto_divisao'] = $division_description;
        }

        $commission_percentage_average = sprintf("%.2f%%", $search_data['value'][0]['comissao_total'] / $search_data['value'][0]['total']);

        $search_data['value'][0]['media_base_comissao'] = $commission_percentage_average;

        return view('tables-datatable-commissions', ['data' => $search_data]);
    }
}
