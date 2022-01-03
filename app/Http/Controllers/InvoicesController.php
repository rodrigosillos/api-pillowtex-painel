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

class InvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function connection($method, $param)
    // {
    //     $client = new Client();

    //     $user = "Pillowtex";
    //     $pass = "P!Ll0w.021!";
    //     $environment = 'http://pillowtex.ip.odhserver.com:6017/api/millenium/';
    //     $type = 'GET';

    //     $response = $client->request($type, $environment.$method.$param, [
    //         'auth' => [$user, $pass]
    //     ]);

    //     return json_decode($response->getBody()->getContents(), true);
    // }

    public function index(Request $request)
    {           
        $previousMonth = date("m", strtotime("first day of previous month"));
        $previousDayMonth = date("d", strtotime("last day of previous month"));
        $currentYear = date("Y", strtotime("-1 year"));
        
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
        
        return view('invoices-list-commissions', $collection);
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

        if($searchAgent != -1)
            $whereSearchAgent = "and agent_code = " . $searchAgent;

        if($userProfileId == 1) {

            // representante_regiao = 150490655 and

            $invoices = DB::select(DB::raw("
                select * 
                from invoices
                where issue_date between '".$dateStart."' and '".$dateEnd."'
                " . $whereSearchAgent . "
                and hidden = 0
                and operation_type = 'S'"
            ));

        } else {

            $invoices = DB::select(DB::raw("
                select * 
                from invoices
                where issue_date between '".$dateStart."' and '".$dateEnd."'
                and agent_id = ".$agentId."
                and hidden = 0
                and operation_type = 'S'"
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
            $commissionResult['data'][$invoiceKey]['tabela_preco'] = $invoice->price_list == 104 ? 187 : 214;
            $commissionResult['data'][$invoiceKey]['total'] = $invoice->amount_withouttax;
            $commissionResult['data'][$invoiceKey]['tipo_operacao'] = $invoice->operation_type == 'E' ? 'Dedução' : 'S';
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

        return view('invoices-list-commissions', 
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
