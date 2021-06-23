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
        $lastMonth = date("m", strtotime("first day of previous month"));
        $lastDayMonth = date("d", strtotime("last day of previous month"));
        $whereAgent = '';

        if($userProfileId == 3)
            $whereAgent = "and agent_id = ".$userAgentId;

        $invoices = DB::select(DB::raw("
            select sum(commission_amount) as commission_amount
            from invoices
            where issue_date between '".$currentYear."-".$lastMonth."-01' and '".$currentYear."-".$lastMonth."-".$lastDayMonth."'
            " . $whereAgent . "
            and hidden = 0"
        ));

        $card1 = ($invoices[0]->commission_amount / 2);

        //card2 - total orders
        $card2 = DB::select(DB::raw("
            select count(distinct(order_id)) as total_pedidos from invoices_product where discount <> 0"
        ));

        //card5 - devolution
        $card5 = DB::select(DB::raw("
            select sum(amount) as total_devolucao from invoices where operation_type = 'E'"
        ));

        //card6 - attended states
        $card6 = DB::select(DB::raw("
            select distinct(address_state), address_city from users order by address_state"
        ));

        $data = [
            'card1' => $card1,
            'card2' => $card2[0]->total_pedidos,
            'card5' => $card5[0]->total_devolucao,
            'card6' => $card6,
        ];

        if($output == 'array')
            return $data;
        
        return view('index', $data);
    }
}
