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

        $representanteCodSelecionado = $request->agent;
        $representanteLogado = Auth::user()->agent_id;
        $userProfileId = Auth::user()->user_profile_id;

        $whereRepresentante = '';
        $totalCommission = 0;
        $totalLiquidacao = 0;

        // Visualização Admin
        if($representanteCodSelecionado != 'todos') {

            $queryRep = DB::select(DB::raw("select name from users where agent_code = '". $representanteCodSelecionado ."'"));
            $representanteSelecionado = $representanteCodSelecionado . ' - ' . $queryRep[0]->name;
            $whereRepresentante = "representante_pedido = '".$representanteSelecionado."' and";

        }

        // Visualização Representante
        if($userProfileId == 3)
            $whereRepresentante = "representante_pedido like '%".$representanteLogado."%' and";
            // $whereRepresentante = "representante_pedido like '%".$representanteLogado."%' or representante_cliente like '%".$representanteLogado."%' and";
        
        // $mesAnterior = '04';
        // $ultimoDiaMes = '30';
        $mesAnterior = date("m", strtotime("first day of previous month"));
        $ultimoDiaMes = date("d", strtotime("last day of previous month"));
        $ano = date("Y");

        // dd($whereRepresentante);

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
                acres_decres,
                valor_pago, 
                valor_comissao,
                valor_comissao_representante_pedido,
                valor_comissao_representante_cliente
            from titulos_receber
            where ".$whereRepresentante." tipo_pagto not in (select tipo_pgto from tipos_pgto where oculto = 1) and substituido = 0 and protesto = 0 and gerador = 'C' and baixa = 0 and valor_pago <> 0 and data_pagamento between '".$ano."-".$mesAnterior."-01' and '".$ano."-".$mesAnterior."-".$ultimoDiaMes."'"
        ));

        // select valor_comissao, efetuado, origem from titulos_receber where tipo_pagto not in (5406, 20201) and representante_pedido = '34339 - A MARTINS NETO REPRESENTACAO- ME' and data_pagamento between '2022-03-01' and '2022-03-31';

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
            $acres_decres = $debtor->acres_decres;
            $valor_pago = $debtor->valor_pago;
            $commission = $debtor->valor_comissao;
            $comissaoRepPedido = $debtor->valor_comissao_representante_pedido;
            $comissaoRepCliente = $debtor->valor_comissao_representante_cliente;

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
            $resultDebtors['data'][$debtorKey]['acres_decres'] = $acres_decres;
            $resultDebtors['data'][$debtorKey]['valor_pago'] = $valor_pago;
            $resultDebtors['data'][$debtorKey]['comissao'] = $commission;
            $resultDebtors['data'][$debtorKey]['comissao_representante_pedido'] = $comissaoRepPedido;
            $resultDebtors['data'][$debtorKey]['comissao_representante_cliente'] = $comissaoRepCliente;

        }

        return view('liquidacao', 
        [
            'debtors' => $resultDebtors,
            'total_commission' => $totalCommission,
            'total_liquidacao' => $totalLiquidacao,
            'representante_liquidacao' => $representanteSelecionado,
            'mes_nome' => strftime('%B'),
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
