<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;

class CommissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('tables-datatable-commissions', ['data' => []]);
    }

    public function connection($method, $param)
    {
        $client = new Client();

        $user = "administrator";
        $pass = "ABusters#94";
        //$environment = 'http://pillowtex.bugbusters.me:6017/api/millenium/';
        $environment = 'http://189.113.4.250:6017/api/millenium/';
        $type = 'GET';

        $response = $client->request($type, $environment.$method.$param, [
            'auth' => [$user, $pass]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function searchForId($division, $table, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['division'] == $division && $val['table'] == $table) {
                return $key;
            }
        }
        return null;
    }

    public function getCommission(Request $request)
    {
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;

        $method = 'movimentacao/lista_movimentacao';
        $param = '?datai='.$dateStart.'&dataf='.$dateEnd.'&tipo_operacao=S&$format=json';

        $movement_data = $this->connection($method, $param);
        $commision_data = [];

        $users = DB::table('users')
        ->where('id', '=', Auth::user()->id)
        ->get();

        if (isset($users[0]))
            $agent_id = $users[0]->agent_id;

        foreach($movement_data['value'] as $movement_key => $movement) {

            // search
            $operation_code = $movement['cod_operacao'];
            $search_data = $this->connection('movimentacao/consulta', '?tipo_operacao=S&cod_operacao='.$operation_code.'&ujuros=false&$format=json');
    
            // filter agent
            if ($search_data['value'][0]['representante'] == $agent_id) {

                // agent
                $agent_id = $search_data['value'][0]['representante'];
                $agent_data = $this->connection('representantes/consulta', '?representante='.$agent_id.'&$format=json');

                $search_data['value'][0]['representante_nome'] = "";

                if(isset($agent_data['value'][0]))
                    $search_data['value'][0]['representante_nome'] = $agent_data['value'][0]['geradores'][0]['nome'];
        
                // client
                $client_id = $search_data['value'][0]['cliente'];
                $client_data = $this->connection('clientes/consulta', '?cliente='.$client_id.'&$format=json');

                $search_data['value'][0]['cliente_nome'] = "";
                $client_state = "SP";

                if(isset($client_data['value'][0])) {
                    $search_data['value'][0]['cliente_nome'] = $client_data['value'][0]['geradores'][0]['nome'];
                    $client_state = $client_data['value'][0]['geradores'][0]['ufie'];
                }

                // commission
                $table_id = $search_data['value'][0]['tabela'];
        
                $table_code = 214;
        
                if($table_id == 4)
                    $table_code = 214;
        
                if($table_id == 216)
                    $table_code = 187;
        
                $commission_percentage = 8;
                $commission_amount = 0;
                $search_data['value'][0]['comissao_total'] = 0;
        
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
                    $product_data = $this->connection('produtos/consulta', '?produto='.$product_id.'&$format=json');
                    $product_name = $product_data['value'][0]['descricao1'];
                    $division_id = $product_data['value'][0]['divisao'];
        
                    // product division data
                    $product_division_data = $this->connection('divisoes/consulta', '?divisao='.$division_id.'&$format=json');
                    
                    $division_code = 000;
                    $division_description = "";

                    if (isset($product_division_data['value'][0])) {
                        $division_code = $product_division_data['value'][0]['cod_divisao'];
                        $division_description = $product_division_data['value'][0]['descricao'];
                    }
        
                    $division_key = $this->searchForId($division_code, $table_code, $division_db);
        
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

                    $date_transmission = str_replace('/Date(', '', $search_data['value'][0]['data']);
                    $date_transmission = str_replace(')/', '', $date_transmission);
                    $search_data['value'][0]['data'] = $date_transmission;
        
                    // product data add
                    $search_data['value'][0]['produtos'][$key]['produto_nome'] = $product_name;
                    $search_data['value'][0]['produtos'][$key]['produto_comissao'] = $commission_amount;
                    $search_data['value'][0]['produtos'][$key]['produto_comissao_percentual'] = sprintf("%.2f%%", $commission_percentage);
                    $search_data['value'][0]['produtos'][$key]['produto_divisao'] = $division_description;
                }
        
                $commission_percentage_average = 0;

                if ($search_data['value'][0]['total'] != 0)
                    $commission_percentage_average = sprintf("%.2f%%", $search_data['value'][0]['comissao_total'] / $search_data['value'][0]['total']);
        
                $search_data['value'][0]['media_base_comissao'] = $commission_percentage_average;

                // final
                $commission_amount = 0;
                $commision_data[] = $search_data['value'][0];
            }
        }

        return view('tables-datatable-commissions', ['data' => $commision_data]);

    }
}
