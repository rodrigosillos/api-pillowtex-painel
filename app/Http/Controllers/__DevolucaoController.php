<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Carbon\Carbon;

class DevolucaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDevolucao(Request $request)
    {
        // dd($request);
        $lastMonth = date("m", strtotime("first day of previous month"));
        $lastDayMonth = date("d", strtotime("last day of previous month"));
        $currentYear = date("Y"); 
        
        $dateStart = "01/".$lastMonth."/".$currentYear;
        $dateEnd = $lastDayMonth."/".$lastMonth."/".$currentYear;

        if(isset($request->dateStart)) {
            $dateStart = $request->dateStart;
            $dateEnd = $request->dateEnd;
        }

        $searchAgent = $request->search_agent;

        $dateStartQuery = Carbon::createFromFormat('d/m/Y', $dateStart)->format('Y-m-d');
        $dateEndQuery = Carbon::createFromFormat('d/m/Y', $dateEnd)->format('Y-m-d');

        $dateStartForm = $dateStart;
        $dateEndForm = $dateEnd;

        $whereSearchAgent = '';

        $users = DB::table('users')
        ->select(['agent_id', 'user_profile_id'])
        ->where('id', '=', Auth::user()->id)
        ->first();

        if(isset($users)) {
            $agentId = $users->agent_id;
            $userProfileId = $users->user_profile_id;
        }

        if($searchAgent != -1)
            $whereSearchAgent = "and i.agent_code = " . $searchAgent;

        if($userProfileId == 1) {

            // u.regiao = 150490655 and

            $invoices = DB::select(DB::raw("
                select i.* 
                from invoices i
                inner join users u on i.agent_id = u.agent_id
                where i.issue_date between '".$dateStartQuery."' and '".$dateEndQuery."'
                " . $whereSearchAgent . "
                and i.hidden = 0 
                and i.operation_type = 'E'"
            ));

        } else {

            $invoices = DB::select(DB::raw("
                select * 
                from invoices
                where issue_date between '".$dateStartQuery."' and '".$dateEndQuery."'
                and agent_id = ".$agentId."
                and hidden = 0
                and i.operation_type = 'E'"
            ));
        }

        $commissionResult['data'] = [];
        $commissionResult['agents'] = (new AgentsController)->get('array');
        $commissionResult['totalizador']['valor_venda'] = 0;
        $commissionResult['totalizador']['valor_comissao'] = 0;
        $commissionResult['totalizador']['valor_faturamento'] = 0;

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
            $commissionResult['data'][$invoiceKey]['total'] = $invoice->amount_withouttax;
            $commissionResult['data'][$invoiceKey]['tipo_operacao'] ='Dedução';
            $commissionResult['data'][$invoiceKey]['nota_fiscal'] = $invoice->invoice;
            $commissionResult['data'][$invoiceKey]['pedido_codigo'] = $invoice->order_code;
            $commissionResult['data'][$invoiceKey]['pedido_tipo'] = $invoice->invoice_type;
            $commissionResult['data'][$invoiceKey]['tipo_operacao_cor'] = 'warning';
            $commissionResult['data'][$invoiceKey]['comissao_total'] = $invoice->commission_amount;
            $commissionResult['data'][$invoiceKey]['liquidacao_50'] = $invoice->commission_debtors;
            
            if($invoice->operation_type == 'S')
                $commissionResult['data'][$invoiceKey]['tipo_operacao_cor'] = 'success';

            $commissionResult['data'][$invoiceKey]['fautramento_50'] = 0;

            $percentualFaturamento = 50;

            if ($invoice->invoice_type == 'ANTECIPADO' || $invoice->invoice_type == 'ANTECIPADO ZC')
                $percentualFaturamento = 80;

            if (date_format($issueDate, "m") == $lastMonth)
                $commissionResult['data'][$invoiceKey]['faturamento_50'] = ($percentualFaturamento / 100) * $commissionResult['data'][$invoiceKey]['comissao_total'];

            if($invoice->operation_type != 'E') {
                $commissionResult['totalizador']['valor_comissao'] += $commissionResult['data'][$invoiceKey]['comissao_total'];
                $commissionResult['totalizador']['valor_venda'] += $commissionResult['data'][$invoiceKey]['total'];
                $commissionResult['totalizador']['valor_faturamento'] += $commissionResult['data'][$invoiceKey]['faturamento_50'];
            }

            $commissionPercentageAverage = 0;

            if ($invoice->amount != 0)
                $commissionPercentageAverage = sprintf("%.2f%%", $commissionResult['data'][$invoiceKey]['comissao_total'] / $invoice->amount);
    
            $commissionResult['data'][$invoiceKey]['media_base_comissao'] = $commissionPercentageAverage;

        }

        return view('lista-devolucao', 
        [
            'invoices' => $commissionResult,
            'data_form' => [
                'date_start' => $dateStartForm,
                'date_end' => $dateEndForm,
                'search_agent' => $searchAgent,
            ]
        ]);
    }
}
