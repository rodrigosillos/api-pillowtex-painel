<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get($output = 'view')
    {
        $whereAgent = 'where user_profile_id = 3';
        
        if($output == 'array')
            $whereAgent = 'where agent_id in (select agent_id from invoices group by agent_id)';
        
        $agents = DB::select(DB::raw("
            select * 
            from users
            ".$whereAgent."
            order by name"
        ));

        $agentsResult = [];

        foreach($agents as $agentKey => $agentValue) {
            
            $agentsResult[$agentKey]['agent_id'] = $agentValue->agent_id;
            $agentsResult[$agentKey]['agent_code'] = $agentValue->agent_code;
            $agentsResult[$agentKey]['name'] = $agentValue->name;
            $agentsResult[$agentKey]['email'] = $agentValue->email;

        }

        if ($output == 'array')
            return $agentsResult;
        
        return view('tables-datatable-agents', ['data' => $agentsResult]);
    }
}
