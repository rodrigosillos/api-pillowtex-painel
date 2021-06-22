<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($output = 'view')
    {
        //card - liquidation
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

        $data = [
            'card1' => $card1,
        ];

        if($output == 'array')
            return $data;
        
        return view('index', $data);
    }
}
