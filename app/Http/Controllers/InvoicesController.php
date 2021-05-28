<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use GuzzleHttp\Client;
use Carbon\Carbon;

use App;
use PDF;

class InvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function connection($method, $param)
    {
        $client = new Client();

        $user = "pillowtex_adm";
        $pass = "ABusters#94";
        $environment = 'http://177.85.33.76:6017/api/millenium/';
        $type = 'GET';

        $response = $client->request($type, $environment.$method.$param, [
            'auth' => [$user, $pass]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function index(Request $request)
    {
        $collection = collect([
            'invoices' => [
                'data' => [],
                'totalizador' => [
                    'valor_venda' => 0,
                    'valor_comissao' => 0,
                    'valor_faturamento' => 0,
                    'valor_liquidacao' => 0,
                ],
            ],
            'data_form' => [
                'date_start' => '',
                'date_end' => '',
            ]
        ]);
        
        return view('invoices-list-commissions', $collection);
    }

    public function get(Request $request)
    {
        $dateStart = Carbon::createFromFormat('d/m/Y', $request->dateStart)->format('Y-m-d');
        $dateEnd = Carbon::createFromFormat('d/m/Y', $request->dateEnd)->format('Y-m-d');

        $dateStartForm = $request->dateStart;
        $dateEndForm = $request->dateEnd;

        $users = DB::table('users')
        ->select(['agent_id', 'user_profile_id'])
        ->where('id', '=', Auth::user()->id)
        ->first();

        if(isset($users)) {
            $agentId = $users->agent_id;
            $userProfileId = $users->user_profile_id;
        }

        if($userProfileId == 1) { // admin

            $invoices = DB::table('invoices')
            ->whereBetween('invoices.issue_date', [$dateStart, $dateEnd])
            ->where('hidden', '=', 0)
            ->get();
        
        } elseif($userProfileId == 3) { // agent

            $invoices = DB::table('invoices')
            ->whereBetween('issue_date', [$dateStart, $dateEnd])
            ->where('agent_id', $agentId)
            ->where('hidden', '=', 0)
            ->get();
        }

        $commissionResult['data'] = [];
        $commissionResult['totalizador']['valor_venda'] = 0;
        $commissionResult['totalizador']['valor_comissao'] = 0;
        $commissionResult['totalizador']['valor_faturamento'] = 0;
        $commissionResult['totalizador']['valor_liquidacao'] = 0;
        $commissionResult['totalizador']['valor_substituidor'] = 0;
        $commissionResult['totalizador']['valor_substituicao'] = 0;

        foreach($invoices as $invoiceKey => $invoice) {

            $issueDate = date_create($invoice->issue_date);

            $commissionResult['data'][$invoiceKey]['operacao_codigo'] = $invoice->operation_code;
            $commissionResult['data'][$invoiceKey]['romaneio'] = $invoice->document;
            $commissionResult['data'][$invoiceKey]['ticket'] = $invoice->ticket;
            $commissionResult['data'][$invoiceKey]['data_emissao'] = date_format($issueDate, "d/m/Y");
            $commissionResult['data'][$invoiceKey]['cliente_codigo'] = $invoice->client_code;
            $commissionResult['data'][$invoiceKey]['cliente_nome'] = Str::limit($invoice->client_name, 25, $end='...');
            $commissionResult['data'][$invoiceKey]['cliente_estado'] = $invoice->client_address;
            $commissionResult['data'][$invoiceKey]['representante_nome'] = Str::limit($invoice->agent_name, 25, $end='...');
            $commissionResult['data'][$invoiceKey]['tabela_preco'] = $invoice->price_list == 216 ? 187 : 214;
            $commissionResult['data'][$invoiceKey]['total'] = $invoice->amount;
            $commissionResult['data'][$invoiceKey]['tipo_operacao'] = $invoice->operation_type == 'E' ? 'Dedução' : 'S';
            $commissionResult['data'][$invoiceKey]['nota_fiscal'] = $invoice->invoice;
            $commissionResult['data'][$invoiceKey]['pedido_codigo'] = $invoice->order_code;
            $commissionResult['data'][$invoiceKey]['pedido_tipo'] = $invoice->invoice_type;
            $commissionResult['data'][$invoiceKey]['liquidacao_50'] = $invoice->commission_debtors;
            $commissionResult['data'][$invoiceKey]['tipo_operacao_cor'] = 'warning';
            $commissionResult['data'][$invoiceKey]['comissao_total'] = $invoice->commission_amount;
            
            if($invoice->operation_type == 'S')
                $commissionResult['data'][$invoiceKey]['tipo_operacao_cor'] = 'success';

            $tableId = $invoice->price_list;
            $clientAddress = $invoice->client_address;
    
            $commissionPercentage = 0;
            $commissionAmount = 0;
            //$commissionResult['data'][$invoiceKey]['comissao_total'] = 0;
            
            /*
            $invoiceProducts = DB::table('invoices_product')
            ->select(['quantity', 'discount', 'price', 'division_code'])
            ->where('document', $invoice->document)
            ->get();

            foreach($invoiceProducts as $invoiceProductKey => $invoiceProduct) {

                $productQty = $invoiceProduct->quantity;
                $productDiscount = $invoiceProduct->discount;
                $productPrice = $invoiceProduct->price;
                $divisionCode = $invoiceProduct->division_code;

                if($invoice->invoice_type == 'PEDIDOS ESPECIAIS') {

                    $dataConsultaMovimentacao = '?tipo_operacao='.$invoice->operation_type.'&cod_operacao='.$invoice->operation_code.'&ujuros=false&$format=json&$dateformat=iso';
                    $resultConsultaMovimentacao = $this->connection('movimentacao/consulta', $dataConsultaMovimentacao);
                    $commissionPercentage = $resultConsultaMovimentacao['value'][0]['comissao_r'];

                } else {
                
                    $tableCode = 214;

                    if($clientAddress == null)
                        $clientAddress = 'SP';
            
                    if($tableId == 216)
                        $tableCode = 187;

                    $commissionSettings = DB::table('commission_settings')
                    ->select(['percentage'])
                    ->where('product_division', $divisionCode)
                    ->where('price_list', $tableCode)
                    ->get();

                    if(isset($commissionSettings[0]))
                        $commissionPercentage = $commissionSettings[0]->percentage;

                    if($tableCode == 187 && $clientAddress != 'SP' && $productDiscount < 5)
                        $commissionPercentage = 4;

                    if($tableCode == 214 && $productDiscount > 5)
                        $commissionPercentage = ($commissionPercentage / 2);

                }                
                
                $commissionAmount = floor(($productPrice * $productQty) * $commissionPercentage) / 100;

                if($tableCode == 214 && $productDiscount > 5)
                    $commissionAmount = ($commissionAmount / 2);
    
                $commissionResult['data'][$invoiceKey]['comissao_total'] += $commissionAmount;
                $commissionResult['data'][$invoiceKey]['tabela_preco'] = $tableCode;

            }
            */

            $commissionResult['data'][$invoiceKey]['faturamento_50'] = $commissionResult['data'][$invoiceKey]['comissao_total'] / 2;

            if($invoice->operation_type != 'E') {
                $commissionResult['totalizador']['valor_comissao'] += $commissionResult['data'][$invoiceKey]['comissao_total'];
                $commissionResult['totalizador']['valor_venda'] += $commissionResult['data'][$invoiceKey]['total'];
                $commissionResult['totalizador']['valor_liquidacao'] += $commissionResult['data'][$invoiceKey]['liquidacao_50'];
                $commissionResult['totalizador']['valor_faturamento'] += $commissionResult['data'][$invoiceKey]['faturamento_50'];
            }

            $commissionPercentageAverage = 0;

            if ($invoice->amount != 0)
                $commissionPercentageAverage = sprintf("%.2f%%", $commissionResult['data'][$invoiceKey]['comissao_total'] / $invoice->amount);
    
            $commissionResult['data'][$invoiceKey]['media_base_comissao'] = $commissionPercentageAverage;

            $commissionAmount = 0;

        }

        return view('invoices-list-commissions', 
        [
            'invoices' => $commissionResult,
            'data_form' => [
                'date_start' => $dateStartForm,
                'date_end' => $dateEndForm,
            ]
        ]);

    }
}
