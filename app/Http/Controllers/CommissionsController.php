<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Str;

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

        $users = DB::table('users')
        ->where('id', '=', Auth::user()->id)
        ->get();

        if(isset($users[0])) {
            $agentId = $users[0]->agent_id;
            $userProfileId = $users[0]->user_profile_id;
        }

        if($userProfileId == 1) { // admin
            $invoices = DB::table('invoices')
            ->whereBetween('issue_date', [$dateStart, $dateEnd])
            ->get();
        } elseif($userProfileId == 3) { // agent
            $invoices = DB::table('invoices')
            ->whereBetween('issue_date', [$dateStart, $dateEnd])
            ->where('agent_id', $agentId)
            ->get();
        }

        $commissionResult = [];

        foreach($invoices as $invoiceKey => $invoice) {

            $issueDate = date_create($invoice->issue_date);

            $commissionResult[$invoiceKey]['romaneio'] = $invoice->document;
            $commissionResult[$invoiceKey]['data_emissao'] = date_format($issueDate, "d/m/Y");
            $commissionResult[$invoiceKey]['cliente'] = $invoice->client_id;
            $commissionResult[$invoiceKey]['cliente_nome'] = Str::limit($invoice->client_name, 40, $end='...');
            $commissionResult[$invoiceKey]['cliente_estado'] = $invoice->client_address;
            $commissionResult[$invoiceKey]['representante_nome'] = $invoice->agent_name;
            $commissionResult[$invoiceKey]['tabela_preco'] = $invoice->price_list;
            $commissionResult[$invoiceKey]['total'] = $invoice->amount;

            // commission
            $tableId = $invoice->price_list;
            $clientAddress = $invoice->client_address;
            
            if($clientAddress == null)
                $clientAddress = 'SP';
    
            $tableCode = 214;
    
            if($tableId == 4)
                $tableCode = 214;
    
            if($tableId == 216)
                $tableCode = 187;
    
            $commissionPercentage = 8;
            $commissionAmount = 0;
            $commissionResult[$invoiceKey]['comissao_total'] = 0;

            // database table division
            $divisionDb = [
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

            // products
            $invoiceProducts = DB::table('invoices_product')
            ->where('document', $invoice->document)
            ->get();

            foreach($invoiceProducts as $invoiceProductKey => $invoiceProduct) {

                $productId = $invoiceProduct->product_id;
                $productName = $invoiceProduct->product_name;
                $productQty = $invoiceProduct->quantity;
                $productDiscount = $invoiceProduct->discount;
                $productPrice = $invoiceProduct->price;
                $divisionCode = $invoiceProduct->division_code;
                $divisionDescription = $invoiceProduct->division_description;

                $divisionKey = $this->searchForId($divisionCode, $tableCode, $divisionDb);

                if($divisionKey)
                    $commissionPercentage = $divisionDb[$divisionKey]['percentage'];

                if($tableCode == 214) {
                    if($productDiscount > 5)
                        $commissionAmount = ($commissionAmount / 2);
                }

                if($tableCode == 187) {
                    if($clientAddress != 'SP' && $productDiscount < 5)
                        $commissionPercentage = 4;
                }
                
                // commission amout
                $commissionAmount = floor(($productPrice * $productQty) * $commissionPercentage) / 100;
    
                $commissionResult[$invoiceKey]['comissao_total'] += $commissionAmount;
                $commissionResult[$invoiceKey]['tabela_preco'] = $tableCode;
    
                // product data add
                $commissionResult[$invoiceKey]['produtos'][$invoiceProductKey]['produto_nome'] = $productName;
                $commissionResult[$invoiceKey]['produtos'][$invoiceProductKey]['produto_comissao'] = $commissionAmount;
                $commissionResult[$invoiceKey]['produtos'][$invoiceProductKey]['produto_comissao_percentual'] = sprintf("%.2f%%", $commissionPercentage);
                $commissionResult[$invoiceKey]['produtos'][$invoiceProductKey]['produto_divisao'] = $divisionDescription;

            }

            $commissionPercentageAverage = 0;

            if ($invoice->amount != 0)
                $commissionPercentageAverage = sprintf("%.2f%%", $commissionResult[$invoiceKey]['comissao_total'] / $invoice->amount);
    
                $commissionResult[$invoiceKey]['media_base_comissao'] = $commissionPercentageAverage;

            // final
            $commissionAmount = 0;

        }

        return view('tables-datatable-commissions', ['data' => $commissionResult]);

    }

    public function getAgents(Request $request)
    {
        $agents = DB::table('users')
        ->where('user_profile_id', '=', 3)
        ->get();

        $agentsResult = [];

        foreach($agents as $agentKey => $agentValue) {
            
            $agentsResult[$agentKey]['agent_id'] = $agentValue->agent_id;
            $agentsResult[$agentKey]['agent_code'] = $agentValue->agent_code;
            $agentsResult[$agentKey]['name'] = $agentValue->name;
            $agentsResult[$agentKey]['email'] = $agentValue->email;

        }

        return view('tables-datatable-agents', ['data' => $agentsResult]);
    }
}
