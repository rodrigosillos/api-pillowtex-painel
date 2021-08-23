<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($output = 'view')
    {
        //card1 - liquidation
        $userAgentId = Auth::user()->agent_id;
        $userProfileId = Auth::user()->user_profile_id;

        $currentYear = date("Y");
        $previousMonth = date("m", strtotime("first day of previous month"));
        $lastDayPreviousMonth = date("d", strtotime("last day of previous month"));
        // $whereAgent = '';

        // if($userProfileId == 3)
        //     $whereAgent = "and agent_id = ".$userAgentId;

        // $invoices = DB::select(DB::raw("
        //     select sum(commission_amount) as commission_amount
        //     from invoices
        //     where issue_date between '".$currentYear."-".$previousMonth."-01' and '".$currentYear."-".$previousMonth."-".$lastDayPreviousMonth."'
        //     " . $whereAgent . "
        //     and hidden = 0"
        // ));

        // card - total de vendas por representante
        //     $cardTotalVendas = DB::select(DB::raw("
        //     select sum(amount) as total_venda 
        //     from invoices 
        //     where issue_date between '".$currentYear."-".$previousMonth."-01' and '".$currentYear."-".$previousMonth."-".$lastDayPreviousMonth."'
        //     " . $whereAgent . "
        //     and hidden = 0"
        // ));

        // $card1 = ($invoices[0]->commission_amount / 2);

        //card2 - total orders
        $card2 = DB::select(DB::raw("
            select count(distinct(order_id)) as total_pedidos from invoices_product where discount <> 0"
        ));

        // DEVOLUÇÕES POR REPRESENTANTE
        $devolucoesRepresentante = DB::select(DB::raw("
            SELECT agent_id, agent_name, SUM(`amount`) as valor_devolucao
            FROM (SELECT agent_id, agent_name, `amount`, 
                    IF(@lastAgent=(@lastAgent:=agent_id), @auto:=@auto+1, @auto:=1) indx 
                FROM invoices, (SELECT @lastAgent:=0, @auto:=1) A 
                WHERE operation_type = 'E' AND issue_date BETWEEN '".$currentYear."-".$previousMonth."-01' AND '".$currentYear."-".$previousMonth."-".$lastDayPreviousMonth."'
                ORDER BY agent_id, `amount`) AS A  
            WHERE indx <= 5
            GROUP BY agent_id, agent_name LIMIT 5;
        "));

        // VENDAS POR REPRESENTANTE
        $vendasRepresentante = DB::select(DB::raw("
        SELECT agent_id, agent_name, SUM(`amount`) as valor_venda
        FROM (SELECT agent_id, agent_name, `amount`, 
                IF(@lastAgent=(@lastAgent:=agent_id), @auto:=@auto+1, @auto:=1) indx 
            FROM invoices, (SELECT @lastAgent:=0, @auto:=1) A 
            WHERE operation_type = 'S' AND issue_date BETWEEN '".$currentYear."-".$previousMonth."-01' AND '".$currentYear."-".$previousMonth."-".$lastDayPreviousMonth."'
            ORDER BY agent_id, `amount`) AS A  
        WHERE indx <= 5
        GROUP BY agent_id, agent_name LIMIT 5;
        "));

        // COMISSOES POR REPRESENTANTE
        $comissoesRepresentante = DB::select(DB::raw("
        SELECT agent_id, agent_name, SUM(`commission_amount`) as valor_comissao
        FROM (SELECT agent_id, agent_name, `commission_amount`, 
                IF(@lastAgent=(@lastAgent:=agent_id), @auto:=@auto+1, @auto:=1) indx 
            FROM invoices, (SELECT @lastAgent:=0, @auto:=1) A 
            WHERE operation_type = 'S' AND issue_date BETWEEN '".$currentYear."-".$previousMonth."-01' AND '".$currentYear."-".$previousMonth."-".$lastDayPreviousMonth."'
            ORDER BY agent_id, `commission_amount`) AS A  
        WHERE indx <= 5
        GROUP BY agent_id, agent_name LIMIT 5;
        "));

        //card6 - attended states
        $card6 = DB::select(DB::raw("
            select distinct(address_state), address_city from users order by address_state"
        ));

        $data = [
            'mes_ano' => $previousMonth.'/'.$currentYear,
            'devolucoes_representante' => $devolucoesRepresentante,
            'vendas_representante' => $vendasRepresentante,
            'comissoes_representante' => $comissoesRepresentante,
            'card6' => $card6,
            'card1' => [],
            'card2' => $card2[0]->total_pedidos,
        ];

        if($output == 'array')
            return $data;
        
        return view('index', $data);
    }
}
