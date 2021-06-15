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
        $agentId = Auth::user()->agent_id;

        $lastMonth = date("m", strtotime("first day of previous month"));
        $lastDayMonth = date("d", strtotime("last day of previous month"));
        
        if(isset($request->operation_code)) {

            $debtors = DB::select(DB::raw(" 
                select i.client_name, d.document, d.due_date, d.paid_date, d.effected, d.substituted, d.amount, d.commission 
                from debtors d
                inner join invoices i on d.operation_code = i.operation_code 
                where d.operation_code = ".$operationCode." and d.paid_date between '2021-".$lastMonth."-01' and '2021-".$lastMonth."-".$lastDayMonth."'"
            ));
        
        } else {

            $debtors = DB::select(DB::raw(" 
                select d.document, d.due_date, d.paid_date, d.effected, d.substituted, d.amount, d.commission, i.client_name
                from debtors d 
                inner join invoices i on d.operation_code = i.operation_code
                where i.agent_id = ".$agentId." and d.paid_date between '2021-".$lastMonth."-01' and '2021-".$lastMonth."-".$lastDayMonth."'"
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
            $commission = $debtor->commission;

            $resultDebtors['data'][$debtorKey]['cliente'] = $client_name;
            $resultDebtors['data'][$debtorKey]['documento'] = $document;
            $resultDebtors['data'][$debtorKey]['data_vencimento'] = date_format($dueDate, "d/m/Y");

            $resultDebtors['data'][$debtorKey]['data_pagamento'] = $paidDate;
            if(!is_null($debtor->paid_date))
                $resultDebtors['data'][$debtorKey]['data_pagamento'] = date_format($paidDate, "d/m/Y");

            $resultDebtors['data'][$debtorKey]['efetuado'] = $effected == 1 ? 'Baixado' : 'Em Aberto';
            $resultDebtors['data'][$debtorKey]['substituido'] = $substituted == 1 ? 'Substituído' : 'Não Substituído';
            $resultDebtors['data'][$debtorKey]['valor_inicial'] = $amount;
            $resultDebtors['data'][$debtorKey]['comissao'] = $commission;

        }

        return view('invoices-debtors', 
        [
            'debtors' => $resultDebtors,
        ]);
    }
}
