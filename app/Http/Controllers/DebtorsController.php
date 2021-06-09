<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DebtorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get(Request $request)
    {
        $operationCode = $request->operation_code;
        $resultDebtors = [
            'data' => [],
        ];

        $commissionDebtors = 0;
        $agentId = Auth::user()->id;
        
        if(isset($request->operation_code)) {

            $debtors = DB::select(DB::raw(" 
                select i.client_name, d.document, d.due_date, d.paid_date, d.effected, d.substituted, d.amount 
                from debtors d
                inner join invoices i on d.operation_code = i.operation_code 
                where d.operation_code = ".$operationCode
            ));
        
        } else {

            $debtors = DB::select(DB::raw(" 
                select i.client_name, d.document, d.due_date, d.paid_date, d.effected, d.substituted, d.amount 
                from invoices i 
                inner join debtors d on i.operation_code = d.operation_code 
                where i.agent_id = ".$agentId." and d.effected = 1 and paid_date between '2021-06-01' and '2021-06-30'"
            ));
        
        }

        foreach($debtors as $debtorKey => $debtor) {

            $client_name = $debtor->client_name;
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
                
                $commissionAmount = floor(($productPrice * $productQty) * $commissionPercentage) / 100;

                if($tableCode == 214 && $productDiscount > 5) 
                    $commissionAmount = ($commissionAmount / 2);

                $commissionDebtors += $commissionAmount;
               
            }

            $resultDebtors['data'][$debtorKey]['cliente'] = $client_name;
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
