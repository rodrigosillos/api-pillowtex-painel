<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Carbon\Carbon;

class LiquidacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {           
        $previousMonth = date("m", strtotime("first day of previous month"));
        $previousDayMonth = date("d", strtotime("last day of previous month"));
        // $currentYear = date("Y", strtotime("-1 year"));
        $currentYear = date("Y");
        
        $collection = collect([
            'debtors' => [
                'data' => []
            ],
            'agents' => (new AgentsController)->get('array'),
            'total_commission' => 0,
            'total_liquidacao' => 0,
            'data_form' => [
                'date_start' => '01/' . $previousMonth . '/' . $currentYear,
                'date_end' => $previousDayMonth . '/' . $previousMonth . '/' . $currentYear,
                'search_agent' => -1,
            ]
        ]);
        
        return view('liquidacao-filtro', $collection);
    }

    public function get(Request $request)
    { 
        $resultDebtors = [
            'data' => [],
            'agents' => (new AgentsController)->get('array'),
        ];

        // $representanteCodSelecionado = $request->agent;
        $representanteLogado = Auth::user()->agent_id;
        $userProfileId = Auth::user()->user_profile_id;

        $whereRepresentante = '';
        $totalCommission = 0;
        $totalLiquidacao = 0;

        $dateStart = Carbon::createFromFormat('d/m/Y', $request->dateStart)->format('Y-m-d');
        $dateEnd = Carbon::createFromFormat('d/m/Y', $request->dateEnd)->format('Y-m-d');

        $dateStartForm = $request->dateStart;
        $dateEndForm = $request->dateEnd;
        $representanteCodSelecionado = $request->search_agent;

        $lastMonth = date("m", strtotime("first day of previous month"));
        $lastDayMonth = date("d", strtotime("last day of previous month"));

        // Visualização Admin
        if($representanteCodSelecionado != 'todos') {

            $queryRep = DB::select(DB::raw("select agent_id2, name from users where agent_code = '". $representanteCodSelecionado ."'"));
            $representanteId = $queryRep[0]->agent_id2;
            $representanteSelecionado = $representanteCodSelecionado . ' - ' . $queryRep[0]->name;
            $whereRepresentante = "representante_pedido = '".$representanteSelecionado."' and";

        }

        // Visualização Representante
        if($userProfileId == 3)
            $whereRepresentante = "representante_pedido like '%".$representanteLogado."%' and";
            // $whereRepresentante = "representante_pedido like '%".$representanteLogado."%' or representante_cliente like '%".$representanteLogado."%' and";
        
        // $mesAnterior = '06';
        // $ultimoDiaMes = '30';
        // $mesAnterior = date("m", strtotime("first day of previous month"));
        // $ultimoDiaMes = date("d", strtotime("last day of previous month"));
        $ano = date("Y");

        // dd($whereRepresentante);

        $sqlRepresentante = "select       
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
            valor_comissao_representante_cliente,
            desconsiderar,
            representante_pedido,
            representante_cliente,
            representante_movimento
        from titulos_receber where 
        representante = ".$representanteId." and tipo_pagto not in (select tipo_pgto from tipos_pgto where oculto = 1) and substituido = 0 and protesto = 0 and gerador = 'C' and baixa = 0 and data_pagamento between '". $dateStart ."' and '". $dateEnd ."' or
        representante_movimento = '".$representanteSelecionado."' and tipo_pagto not in (select tipo_pgto from tipos_pgto where oculto = 1) and substituido = 0 and protesto = 0 and gerador = 'C' and baixa = 0 and data_pagamento between '". $dateStart ."' and '". $dateEnd ."' or
        representante_cliente = '".$representanteSelecionado."' and tipo_pagto not in (select tipo_pgto from tipos_pgto where oculto = 1) and substituido = 0 and protesto = 0 and gerador = 'C' and baixa = 0 and data_pagamento between '". $dateStart ."' and '". $dateEnd ."' or 
        representante_pedido = '".$representanteSelecionado."' and tipo_pagto not in (select tipo_pgto from tipos_pgto where oculto = 1) and substituido = 0 and protesto = 0 and gerador = 'C' and baixa = 0 and data_pagamento between '". $dateStart ."' and '". $dateEnd ."';";

        $debtors = DB::select(DB::raw($sqlRepresentante));

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

            if($debtor->desconsiderar == 0) {
                $totalCommission += $commission;
                $totalLiquidacao += $amount;
            }

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
            $resultDebtors['data'][$debtorKey]['desconsiderar'] = $debtor->desconsiderar;
            $resultDebtors['data'][$debtorKey]['representante_pedido'] = $debtor->representante_pedido;
            $resultDebtors['data'][$debtorKey]['representante_cliente'] = $debtor->representante_cliente;
            $resultDebtors['data'][$debtorKey]['representante_movimento'] = $debtor->representante_movimento;
        }

        return view('liquidacao-filtro', 
        [
            'debtors' => $resultDebtors,
            'agents' => (new AgentsController)->get('array'),
            'total_commission' => $totalCommission,
            'total_liquidacao' => $totalLiquidacao,
            'representante_liquidacao' => $representanteSelecionado,
            'representante_cod' => $representanteCodSelecionado,
            'mes_nome' => strftime('%B'),
            'data_form' => [
                'date_start' => $dateStartForm,
                'date_end' => $dateEndForm,
                'search_agent' => $representanteCodSelecionado,
            ]
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

    public function desconsidera(Request $request)
    {
        $desconsideraTitulos = $request->desconsiderar_titulo;
        $repSelecionado = $request->rep_selecionado;
        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;

        foreach($desconsideraTitulos as $titulo) {

            $result = DB::table('titulos_receber')
            ->select('desconsiderar')
            ->where('id', $titulo)
            ->first();

            $acaoDesconsiderar = $result->desconsiderar; 

            $desconsiderar = 1;
            if ($acaoDesconsiderar == 1)
                $desconsiderar = 0;
            
            DB::table('titulos_receber')
            ->where('id', $titulo)
            ->update(['desconsiderar' => $desconsiderar]);

        }

        return redirect()->route('consulta-liquidacao', [
            '_token' => csrf_token(),
            'search_agent' => $repSelecionado,
            'dateStart' => $dataInicio,
            'dateEnd' => $dataFim,
        ]);

    }
}
