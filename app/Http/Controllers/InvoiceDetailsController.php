<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class InvoiceDetailsController extends Controller
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

    public function get(Request $request)
    {
        $operationCode = $request->operation_code;
        
        // invoice
        $invoice = DB::table('invoices')
        ->select(['price_list', 'client_address', 'invoice_type', 'operation_type'])
        ->where('operation_code', $operationCode)
        ->first();

        // commission
        $tableId = $invoice->price_list;
        $clientAddress = $invoice->client_address;
        $invoiceType = $invoice->invoice_type;
        $operationType = $invoice->operation_type;
        
        if($clientAddress == null)
            $clientAddress = 'SP';

        $tableCode = 214;

        if($tableId == 4)
            $tableCode = 214;

        if($tableId == 104)
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

            if($tableCode == 187) {
                if($clientAddress != 'SP' && $productDiscount < 5)
                    // $commissionPercentage = 4;
                    $commissionPercentage = 3;
            }

            if($invoiceType == 'PEDIDOS ESPECIAIS') {
                $dataConsultaMovimentacao = '?tipo_operacao='.$operationType.'&cod_operacao='.$operationCode.'&ujuros=false&$format=json&$dateformat=iso';
                $resultConsultaMovimentacao = $this->connection('movimentacao/consulta', $dataConsultaMovimentacao);
                $commissionPercentage = $resultConsultaMovimentacao['value'][0]['comissao_r'];
            }
            
            // commission amout
            $commissionAmount = floor(($productPrice * $productQty) * $commissionPercentage) / 100;

            if($tableCode == 214 && $productDiscount > 5)
                $commissionAmount = ($commissionAmount / 2);

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

}
