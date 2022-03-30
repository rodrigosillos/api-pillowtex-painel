<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LiquidacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getLiquidacao(Request $request)
    {
        $resultDebtors = [
            'data' => [],
        ];

        $agentSearchAdmin = $request->agent;
        $agentId = Auth::user()->agent_id;
        $userProfileId = Auth::user()->user_profile_id;

        $whereAgent = '';
        $totalCommission = 0;
        $totalLiquidacao = 0;

        if($agentSearchAdmin != 'all')
            $whereAgent = "representante_pedido like '%".$agentSearchAdmin."%' and";

        if($userProfileId == 3)
            $whereAgent = "representante_pedido like '%".$agentId."%' and";

        $lastMonth = 01;
        // $lastMonth = date("m", strtotime("first day of previous month"));
        // $lastDayMonth = date("d", strtotime("last day of previous month"));
        $lastDayMonth = '31';
        $currentYear = date("Y");

        $debtors = DB::select(DB::raw(" 
            select 
                id,
                cliente_nome, 
                lancamento,
                origem, 
                n_documento,
                data_vencimento, 
                data_pagamento, 
                efetuado, 
                substituido, 
                valor_inicial, 
                valor_comissao
            from titulos_receber
            where ".$whereAgent." substituido = 0 and baixa = 0 and data_pagamento between '".$currentYear."-".$lastMonth."-01' and '".$currentYear."-".$lastMonth."-".$lastDayMonth."'"
        ));

        foreach($debtors as $debtorKey => $debtor) {

            $tituloID = $debtor->id;
            $client_name = $debtor->cliente_nome;
            $lancamento = $debtor->lancamento;
            $operationCode = $debtor->origem;
            $document = $debtor->n_documento;
            $dueDate = date_create($debtor->data_vencimento);
            
            $paidDate = $debtor->data_pagamento;
            
            if(!is_null($debtor->data_pagamento))
                $paidDate = date_create($debtor->data_pagamento);

            $effected = $debtor->efetuado;
            $substituted = $debtor->substituido;
            $amount = $debtor->valor_inicial;
            $commission = $debtor->valor_comissao;

            $totalCommission += $commission;
            $totalLiquidacao += $amount;

            $resultDebtors['data'][$debtorKey]['id'] = $tituloID;
            $resultDebtors['data'][$debtorKey]['cliente'] = Str::limit($client_name, 25, $end='...');
            $resultDebtors['data'][$debtorKey]['lancamento'] = $lancamento;
            $resultDebtors['data'][$debtorKey]['codigo_operacao'] = $operationCode;
            $resultDebtors['data'][$debtorKey]['documento'] = $document;
            $resultDebtors['data'][$debtorKey]['data_vencimento'] = date_format($dueDate, "d/m/Y");

            $resultDebtors['data'][$debtorKey]['data_pagamento'] = $paidDate;
            if(!is_null($debtor->data_pagamento))
                $resultDebtors['data'][$debtorKey]['data_pagamento'] = date_format($paidDate, "d/m/Y");

            $resultDebtors['data'][$debtorKey]['efetuado'] = $effected == 1 ? 'Baixado' : 'Em Aberto';
            $resultDebtors['data'][$debtorKey]['substituido'] = $substituted == 1 ? 'Substituído' : 'Não Substituído';
            $resultDebtors['data'][$debtorKey]['valor_inicial'] = $amount;
            $resultDebtors['data'][$debtorKey]['comissao'] = $commission;

        }

        return view('liquidacao', 
        [
            'debtors' => $resultDebtors,
            'total_commission' => $totalCommission,
            'total_liquidacao' => $totalLiquidacao,
        ]);
    }

    public function getSubstituicao(Request $request)
    {
        $resultDebtors = [
            'data' => [],
        ];

        $agentSearchAdmin = $request->agent;
        $agentId = Auth::user()->agent_id;
        $userProfileId = Auth::user()->user_profile_id;

        $whereAgent = '';

        if($agentSearchAdmin != 'all')
            $whereAgent = "i.agent_id = ".$agentSearchAdmin." and";

        if($userProfileId == 3)
            $whereAgent = "i.agent_id = ".$agentId." and";

        $lastMonth = date("m", strtotime("first day of previous month"));
        $lastDayMonth = date("d", strtotime("last day of previous month"));

        /*
        $debtors = DB::select(DB::raw(" 
            select i.client_name, d.book_entry, d.document, d.due_date, d.paid_date, d.effected, d.substituted, d.amount, d.commission 
            from debtors d
            inner join invoices i on d.operation_code = i.operation_code 
            where d.operation_code = ".$operationCode." and d.paid_date between '2021-".$lastMonth."-01' and '2021-".$lastMonth."-".$lastDayMonth."'"
        ));
        */

        $debtors = DB::select(DB::raw(" 
            select i.client_name, d.book_entry, d.document, d.due_date, d.paid_date, d.effected, d.substituted, d.amount, d.commission
            from debtors d 
            inner join invoices i on d.operation_code = i.operation_code
            where ".$whereAgent." d.substituted = 1 and d.paid_date between '2021-".$lastMonth."-01' and '2021-".$lastMonth."-".$lastDayMonth."'"
        ));

        foreach($debtors as $debtorKey => $debtor) {

            $client_name = $debtor->client_name;
            $lancamento = $debtor->book_entry;
            $document = $debtor->document;
            $dueDate = date_create($debtor->due_date);
            
            $paidDate = $debtor->paid_date;
            if(!is_null($debtor->paid_date))
                $paidDate = date_create($debtor->paid_date);

            $effected = $debtor->effected;
            $substituted = $debtor->substituted;
            $amount = $debtor->amount;
            $commission = $debtor->commission;

            $resultDebtors['data'][$debtorKey]['cliente'] = Str::limit($client_name, 25, $end='...');
            $resultDebtors['data'][$debtorKey]['lancamento'] = $lancamento;
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

        return view('invoices-debtors-substituted', 
        [
            'debtors' => $resultDebtors,
        ]);
    }
}
