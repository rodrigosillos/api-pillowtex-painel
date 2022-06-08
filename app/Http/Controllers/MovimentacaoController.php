<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Http\Controllers\AgentsController;

use GuzzleHttp\Client;
use Carbon\Carbon;

use App;
use PDF;

class MovimentacaoController extends Controller
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
            'invoices' => [
                'data' => [],
                'agents' => (new AgentsController)->get('array'),
                'totalizador' => [
                    'valor_venda' => 0,
                    'valor_comissao' => 0,
                    'valor_faturamento' => 0,
                ],
            ],
            'data_form' => [
                'date_start' => '01/' . $previousMonth . '/' . $currentYear,
                'date_end' => $previousDayMonth . '/' . $previousMonth . '/' . $currentYear,
                'search_agent' => -1,
            ]
        ]);
        
        return view('faturamento', $collection);
    }

    public function get(Request $request)
    {
        $dateStart = Carbon::createFromFormat('d/m/Y', $request->dateStart)->format('Y-m-d');
        $dateEnd = Carbon::createFromFormat('d/m/Y', $request->dateEnd)->format('Y-m-d');

        $dateStartForm = $request->dateStart;
        $dateEndForm = $request->dateEnd;
        $searchAgent = $request->search_agent;

        $lastMonth = date("m", strtotime("first day of previous month"));
        $lastDayMonth = date("d", strtotime("last day of previous month"));

        $whereSearchAgent = '';

        $users = DB::table('users')
        ->select(['agent_id', 'user_profile_id'])
        ->where('id', '=', Auth::user()->id)
        ->first();

        if(isset($users)) {
            $agentId = $users->agent_id;
            $userProfileId = $users->user_profile_id;
        }

        $query = " tipo_pedido not in (select descricao from tipos_pedido where oculto = 1) and data_emissao between '" . $dateStart . "' and '" . $dateEnd . "' and oculto = 0 and tipo_operacao = 'S'";

        if($searchAgent != "todos") {
            $query  = " tipo_pedido not in (select descricao from tipos_pedido where oculto = 1) and data_emissao between '" . $dateStart . "' and '" . $dateEnd . "' and representante_cod = '" . $searchAgent . "' and oculto = 0 and tipo_operacao = 'S'";
            $query .= " or tipo_pedido not in (select descricao from tipos_pedido where oculto = 1) and data_emissao between '" . $dateStart . "' and '" . $dateEnd . "' and representante_cliente_cod = '" . $searchAgent . "' and oculto = 0 and tipo_operacao = 'S'";
        }

        // dd($query);

        if($userProfileId == 1) {

            $invoices = DB::select(DB::raw("
                select * 
                from movimentacao
                where" . $query
            ));

        } else {

            $invoices = DB::select(DB::raw("
                select * 
                from movimentacao
                where data_emissao between '".$dateStart."' and '".$dateEnd."'
                and tipo_pedido not in (select descricao from tipos_pedido where oculto = 1)
                and representante = ".$agentId."
                and oculto = 0
                and tipo_operacao = 'S'"
            ));
        }

        $commissionResult['data'] = [];
        $commissionResult['agents'] = (new AgentsController)->get('array');
        $commissionResult['totalizador']['valor_venda'] = 0;
        $commissionResult['totalizador']['valor_comissao'] = 0;
        $commissionResult['totalizador']['valor_faturamento'] = 0;

        foreach($invoices as $invoiceKey => $invoice) {

            $issueDate = date_create($invoice->data_emissao);

            $valorComissaoRep = $invoice->valor_comissao;
            $valorFaturamentoRep = $invoice->valor_faturamento;

            if($invoice->tipo_pedido == 'ZC FEIRA' || $invoice->tipo_pedido == 'ZC FUTURO') {

                if ($invoice->representante <> $invoice->representante_cliente) {

                    $valorComissaoRep = $invoice->valor_comissao_representante;
                    $valorFaturamentoRep = $invoice->valor_faturamento_representante;
        
                    if($invoice->representante_cliente_cod == $searchAgent) {
                        $valorComissaoRep = $invoice->valor_comissao_representante_cliente;
                        $valorFaturamentoRep = $invoice->valor_faturamento_representante_cliente;
                    }  

                }

            }              

            $commissionResult['data'][$invoiceKey]['operacao_codigo'] = $invoice->cod_operacao;
            $commissionResult['data'][$invoiceKey]['romaneio'] = $invoice->romaneio;
            $commissionResult['data'][$invoiceKey]['ticket'] = $invoice->ticket;
            $commissionResult['data'][$invoiceKey]['data_emissao'] = date_format($issueDate, "d/m/Y");
            $commissionResult['data'][$invoiceKey]['cliente_codigo'] = $invoice->cliente_codigo;
            $commissionResult['data'][$invoiceKey]['cliente_nome'] = Str::limit($invoice->cliente_nome, 25, $end='...');
            $commissionResult['data'][$invoiceKey]['cliente_estado'] = $invoice->cliente_estado;
            $commissionResult['data'][$invoiceKey]['representante_nome'] = Str::limit($invoice->representante_nome, 25, $end='...');
            $commissionResult['data'][$invoiceKey]['representante_cliente_nome'] = Str::limit($invoice->representante_cliente_nome, 25, $end='...');
            $commissionResult['data'][$invoiceKey]['tabela_preco'] = $invoice->tabela == 104 ? 187 : 214;
            $commissionResult['data'][$invoiceKey]['total'] = $invoice->total;
            $commissionResult['data'][$invoiceKey]['tipo_operacao'] = $invoice->tipo_operacao == 'E' ? 'Dedução' : 'S';
            $commissionResult['data'][$invoiceKey]['nota_fiscal'] = $invoice->notas;
            $commissionResult['data'][$invoiceKey]['pedido_codigo'] = $invoice->cod_pedidov;
            $commissionResult['data'][$invoiceKey]['pedido_tipo'] = $invoice->tipo_pedido;
            $commissionResult['data'][$invoiceKey]['tipo_operacao_cor'] = 'warning';
            $commissionResult['data'][$invoiceKey]['comissao_total'] = $valorComissaoRep;
            $commissionResult['data'][$invoiceKey]['valor_comissao_representante'] = $invoice->valor_comissao_representante;
            $commissionResult['data'][$invoiceKey]['valor_comissao_representante_cliente'] = $invoice->valor_comissao_representante_cliente;
            $commissionResult['data'][$invoiceKey]['valor_faturamento_representante'] = $invoice->valor_faturamento_representante;
            $commissionResult['data'][$invoiceKey]['valor_faturamento_representante_cliente'] = $invoice->valor_faturamento_representante_cliente;
            
            if($invoice->tipo_operacao == 'S')
                $commissionResult['data'][$invoiceKey]['tipo_operacao_cor'] = 'success';

            $commissionResult['data'][$invoiceKey]['faturamento_50'] = $valorFaturamentoRep;

            if($invoice->tipo_pedido != 'E') {
                $commissionResult['totalizador']['valor_comissao'] += $commissionResult['data'][$invoiceKey]['comissao_total'];
                $commissionResult['totalizador']['valor_venda'] += $commissionResult['data'][$invoiceKey]['total'];
                $commissionResult['totalizador']['valor_faturamento'] += $commissionResult['data'][$invoiceKey]['faturamento_50'];
            }

            $commissionPercentageAverage = 0;

            if ($invoice->valor_final != 0)
                $commissionPercentageAverage = sprintf("%.2f%%", $commissionResult['data'][$invoiceKey]['comissao_total'] / $invoice->valor_final);
    
            $commissionResult['data'][$invoiceKey]['media_base_comissao'] = $commissionPercentageAverage;

        }

        return view('faturamento', 
        [
            'invoices' => $commissionResult,
            'data_form' => [
                'date_start' => $dateStartForm,
                'date_end' => $dateEndForm,
                'search_agent' => $searchAgent,
            ]
        ]);

    }

    public function desconsidera(Request $request)
    {
        $desconsideraMovimentos = $request->desconsiderar_movimento;

        foreach($desconsideraMovimentos as $movimento) {
            
            DB::table('movimentacao')
            ->where('cod_operacao', $movimento)
            ->update(['oculto' => 1]);

        }

        return redirect('/faturamento');

    }
}
 