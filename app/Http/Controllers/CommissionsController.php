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
        return view('invoices-list-commissions', ['invoices' => [
            'data' => [],
            'totalizador' => [
                'valor_venda' => 0,
                'valor_comissao' => 0,
                'valor_faturamento' => 0,
                'valor_liquidacao' => 0,
                ],
            ]
        ]);
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

    public function getInvoices(Request $request)
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
            //->whereIn('document', [306789198, 306804648])
            ->get();
        } elseif($userProfileId == 3) { // agent
            $invoices = DB::table('invoices')
            ->whereBetween('issue_date', [$dateStart, $dateEnd])
            ->where('agent_id', $agentId)
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

            if($invoice->client_id != null && $invoice->canceled == false){

                $issueDate = date_create($invoice->issue_date);

                $commissionResult['data'][$invoiceKey]['operacao_codigo'] = $invoice->operation_code;
                $commissionResult['data'][$invoiceKey]['romaneio'] = $invoice->document;
                $commissionResult['data'][$invoiceKey]['ticket'] = $invoice->ticket;
                $commissionResult['data'][$invoiceKey]['data_emissao'] = date_format($issueDate, "d/m/Y");
                $commissionResult['data'][$invoiceKey]['cliente_codigo'] = $invoice->client_code;
                $commissionResult['data'][$invoiceKey]['cliente_nome'] = Str::limit($invoice->client_name, 25, $end='...');
                $commissionResult['data'][$invoiceKey]['cliente_estado'] = $invoice->client_address;
                $commissionResult['data'][$invoiceKey]['representante_nome'] = Str::limit($invoice->agent_name, 25, $end='...');
                $commissionResult['data'][$invoiceKey]['tabela_preco'] = $invoice->price_list;
                $commissionResult['data'][$invoiceKey]['total'] = $invoice->amount;
                $commissionResult['data'][$invoiceKey]['tipo_operacao'] = $invoice->operation_type == 'E' ? 'Dedução' : 'S';
                $commissionResult['data'][$invoiceKey]['nota_fiscal'] = $invoice->invoice;
                $commissionResult['data'][$invoiceKey]['pedido_codigo'] = $invoice->order_code;
                $commissionResult['data'][$invoiceKey]['pedido_tipo'] = $invoice->invoice_type;

                //debtors
                $debtors = DB::table('debtors')
                ->where('operation_code', $invoice->operation_code)
                ->get();

                $commissionDebtors = 0;

                foreach($debtors as $debtorKey => $debtor__) {
                    $commissionDebtors += $debtor__->commission;
                }

                $commissionResult['data'][$invoiceKey]['liquidacao_50'] = $commissionDebtors;
    
                $commissionResult['data'][$invoiceKey]['tipo_operacao_cor'] = 'warning';
                
                if($invoice->operation_type == 'S')
                    $commissionResult['data'][$invoiceKey]['tipo_operacao_cor'] = 'success';
    
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
        
                $commissionPercentage = 0;
                $commissionAmount = 0;
                $commissionResult['data'][$invoiceKey]['comissao_total'] = 0;
    
                // products
                $invoiceProducts = DB::table('invoices_product')
                ->where('document', $invoice->document)
                ->get();
    
                foreach($invoiceProducts as $invoiceProductKey => $invoiceProduct) {
    
                    $orderId = $invoiceProduct->order_id;
                    $productInvoice = $invoiceProduct->invoice;
                    $productId = $invoiceProduct->product_id;
                    $productName = $invoiceProduct->product_name;
                    $productQty = $invoiceProduct->quantity;
                    $productDiscount = $invoiceProduct->discount;
                    $productPrice = $invoiceProduct->price;
                    $divisionCode = $invoiceProduct->division_code;
                    $divisionDescription = $invoiceProduct->division_description;

                    $commissionSettings = DB::table('commission_settings')
                    ->where('product_division', $divisionCode)
                    ->where('price_list', $tableCode)
                    ->get();

                    if(isset($commissionSettings[0]))
                        $commissionPercentage = $commissionSettings[0]->percentage;
    
                    if($tableCode == 187) {
                        if($clientAddress != 'SP' && $productDiscount < 5)
                            $commissionPercentage = 4;
                    }

                    if($tableCode == 214) {
                        if($productDiscount > 5)
                            $commissionPercentage = ($commissionPercentage / 2);
                    }
                    
                    // commission amout
                    $commissionAmount = floor(($productPrice * $productQty) * $commissionPercentage) / 100;

                    if($tableCode == 214) {
                        if($productDiscount > 5)
                            $commissionAmount = ($commissionAmount / 2);
                    }
        
                    $commissionResult['data'][$invoiceKey]['comissao_total'] += $commissionAmount;
                    $commissionResult['data'][$invoiceKey]['tabela_preco'] = $tableCode;
        
                    // product data add
                    $commissionResult['data'][$invoiceKey]['produtos'][$invoiceProductKey]['pedido'] = $orderId;
                    $commissionResult['data'][$invoiceKey]['produtos'][$invoiceProductKey]['nota'] = $productInvoice;
                    $commissionResult['data'][$invoiceKey]['produtos'][$invoiceProductKey]['produto'] = $productId;
                    $commissionResult['data'][$invoiceKey]['produtos'][$invoiceProductKey]['produto_nome'] = $productName;
                    $commissionResult['data'][$invoiceKey]['produtos'][$invoiceProductKey]['quantidade'] = $productQty;
                    $commissionResult['data'][$invoiceKey]['produtos'][$invoiceProductKey]['preco'] = $productPrice;
                    $commissionResult['data'][$invoiceKey]['produtos'][$invoiceProductKey]['desconto'] = $productDiscount;
                    $commissionResult['data'][$invoiceKey]['produtos'][$invoiceProductKey]['produto_comissao'] = $commissionAmount;
                    $commissionResult['data'][$invoiceKey]['produtos'][$invoiceProductKey]['produto_comissao_percentual'] = sprintf("%.2f%%", $commissionPercentage);
                    $commissionResult['data'][$invoiceKey]['produtos'][$invoiceProductKey]['produto_divisao'] = $divisionDescription;
    
                }

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
        
                //$commissionResult['data'][$invoiceKey]['media_base_comissao'] = (int) $commissionPercentageAverage . '.00%';
                $commissionResult['data'][$invoiceKey]['media_base_comissao'] = $commissionPercentageAverage;
    
                // final
                $commissionAmount = 0;

            }

        }

        return view('invoices-list-commissions', 
        [
            'invoices' => $commissionResult,
        ]);

    }

    public function detailInvoice(Request $request)
    {
        $operationCode = $request->operation_code;
        
        // invoice
        $invoice = DB::table('invoices')
        ->where('operation_code', $operationCode)
        ->get();

        // commission
        $tableId = $invoice[0]->price_list;
        $clientAddress = $invoice[0]->client_address;
        
        if($clientAddress == null)
            $clientAddress = 'SP';

        $tableCode = 214;

        if($tableId == 4)
            $tableCode = 214;

        if($tableId == 216)
            $tableCode = 187;

        $commissionPercentage = 8;
        $commissionAmount = 0;
        $commissionResult = [
            'produtos' => [],
        ];
        
        // products
        $invoiceProducts = DB::table('invoices_product')
        ->where('operation_code', $operationCode)
        ->get();

        foreach($invoiceProducts as $invoiceProductKey => $invoiceProduct) {

            $orderId = $invoiceProduct->order_id;
            $productInvoice = $invoiceProduct->invoice;
            $productId = $invoiceProduct->product_id;
            $productCode = $invoiceProduct->product_code;
            $productName = $invoiceProduct->product_name;
            $productQty = $invoiceProduct->quantity;
            $productDiscount = $invoiceProduct->discount;
            $productPrice = $invoiceProduct->price;
            $divisionCode = $invoiceProduct->division_code;
            $divisionDescription = $invoiceProduct->division_description;

            $commissionSettings = DB::table('commission_settings')
            ->where('product_division', $divisionCode)
            ->where('price_list', $tableCode)
            ->get();

            if(isset($commissionSettings[0]))
                $commissionPercentage = $commissionSettings[0]->percentage;

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

            // product data add
            $commissionResult['produtos'][$invoiceProductKey]['pedido'] = $orderId;
            $commissionResult['produtos'][$invoiceProductKey]['nota'] = $productInvoice;
            $commissionResult['produtos'][$invoiceProductKey]['produto'] = $productId;
            $commissionResult['produtos'][$invoiceProductKey]['produto_codigo'] = $productCode;
            $commissionResult['produtos'][$invoiceProductKey]['produto_nome'] = $productName;
            $commissionResult['produtos'][$invoiceProductKey]['quantidade'] = $productQty;
            $commissionResult['produtos'][$invoiceProductKey]['preco'] = $productPrice;
            $commissionResult['produtos'][$invoiceProductKey]['desconto'] = $productDiscount;
            $commissionResult['produtos'][$invoiceProductKey]['produto_comissao'] = $commissionAmount;
            $commissionResult['produtos'][$invoiceProductKey]['produto_comissao_percentual'] = sprintf("%.2f%%", $commissionPercentage);
            $commissionResult['produtos'][$invoiceProductKey]['produto_divisao'] = $divisionDescription;

        }

        return view('invoices-detail-commissions', 
        [
            'products' => $commissionResult,
        ]);
    }

    public function getAgents(Request $request)
    {
        $agents = DB::table('users')
        ->where('user_profile_id', 3)
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

    public function getDebtors(Request $request)
    {
        $operationCode = $request->operation_code;
        $resultDebtors = [
            'data' => [],
        ];

        $commissionDebtors = 0;
        
        $debtors = DB::table('debtors')
        ->where('operation_code', $operationCode)
        ->get();

        foreach($debtors as $debtorKey => $debtor) {

            $document = $debtor->document;
            $dueDate = date_create($debtor->due_date);
            
            $paidDate = $debtor->paid_date;
            if(!is_null($debtor->paid_date))
                $paidDate = date_create($debtor->paid_date);

            $effected = $debtor->effected;
            $substituted = $debtor->substituted;
            $amount = $debtor->amount;

            $invoiceProducts = DB::table('invoices_product')
            ->where('operation_code', $operationCode)
            ->get();
    
            foreach($invoiceProducts as $invoiceProductKey => $invoiceProduct) {
    
                $orderId = $invoiceProduct->order_id;
                $productInvoice = $invoiceProduct->invoice;
                $productId = $invoiceProduct->product_id;
                $productName = $invoiceProduct->product_name;
                $productQty = $invoiceProduct->quantity;
                $productDiscount = $invoiceProduct->discount;
                $productPrice = $invoiceProduct->price;
                $divisionCode = $invoiceProduct->division_code;
                $divisionDescription = $invoiceProduct->division_description;

                $invoice = DB::table('invoices')
                ->where('operation_code', $operationCode)
                ->get();

                $tableId = $invoice[0]->price_list;
                $clientAddress = $invoice[0]->client_address;

                if($clientAddress == null)
                    $clientAddress = 'SP';
        
                $tableCode = 214;
        
                if($tableId == 4)
                    $tableCode = 214;
            
                if($tableId == 216)
                    $tableCode = 187;
    
                $commissionSettings = DB::table('commission_settings')
                ->where('product_division', $divisionCode)
                ->where('price_list', $tableCode)
                ->get();

                if(isset($commissionSettings[0]))
                    $commissionPercentage = $commissionSettings[0]->percentage;
    
                if($tableCode == 187 && $clientAddress != 'SP' && $productDiscount < 5)
                    $commissionPercentage = 4;
                
                // commission amout
                $commissionAmount = floor(($productPrice * $productQty) * $commissionPercentage) / 100;

                if($tableCode == 214 && $productDiscount > 5) 
                    $commissionAmount = ($commissionAmount / 2);

                $commissionDebtors += $commissionAmount;
               
            }

            $resultDebtors['data'][$debtorKey]['documento'] = $document;
            $resultDebtors['data'][$debtorKey]['data_vencimento'] = date_format($dueDate, "d/m/Y");

            $resultDebtors['data'][$debtorKey]['data_pagamento'] = $paidDate;
            if(!is_null($debtor->paid_date))
                $resultDebtors['data'][$debtorKey]['data_pagamento'] = date_format($paidDate, "d/m/Y");

            $resultDebtors['data'][$debtorKey]['efetuado'] = $effected == 1 ? 'Baixado' : 'Em Aberto';
            $resultDebtors['data'][$debtorKey]['substituido'] = $substituted == 1 ? 'Substituído' : 'Não Substituído';
            $resultDebtors['data'][$debtorKey]['valor_inicial'] = $amount;
            $resultDebtors['data'][$debtorKey]['comissao'] = 0;
            
            if($effected == 1)
                $resultDebtors['data'][$debtorKey]['comissao'] = (($commissionDebtors / 2) / count($debtors));

            $commissionDebtors = 0;

        }

        return view('invoices-debtors', 
        [
            'debtors' => $resultDebtors,
        ]);
    }
}
