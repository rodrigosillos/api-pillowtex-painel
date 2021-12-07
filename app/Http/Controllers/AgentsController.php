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
        $whereAgent = 'where user_profile_id = 3 and regiao = 150490655';
        
        if($output == 'array')
            $whereAgent = 'where agent_id in (select agent_id from invoices group by agent_id)';
            // $whereAgent = 'where agent_id2 in (select i.agent_id from invoices i inner join users u on i.agent_id = u.agent_id2 where u.regiao = 150490655 group by i.agent_id)';
        
        $agents = DB::select(DB::raw("
            select * 
            from users
            ".$whereAgent."
            order by name"
        ));

        $agentsResult = [];

        foreach($agents as $agentKey => $agentValue) {
            
            $agentsResult[$agentKey]['agent_id'] = $agentValue->agent_id;
            $agentsResult[$agentKey]['agent_id2'] = $agentValue->agent_id2;
            $agentsResult[$agentKey]['agent_code'] = $agentValue->agent_code;
            $agentsResult[$agentKey]['name'] = $agentValue->name;
            $agentsResult[$agentKey]['email'] = $agentValue->email;
            $agentsResult[$agentKey]['cidade'] = $agentValue->address_city;
            $agentsResult[$agentKey]['estado'] = $agentValue->address_state;

        }

        if($output == 'array')
            return $agentsResult;
        
        return view('agents-list', ['data' => $agentsResult]);
    }
}
