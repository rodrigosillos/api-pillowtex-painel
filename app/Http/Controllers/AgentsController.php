<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get(Request $request)
    {
        $agents = DB::table('users')
        ->where('user_profile_id', 3)
        ->get();

        $agentsResult = [];

        foreach($agents as $agentKey => $agentValue) {
            
            $agentsResult[$agentKey]['agent_id'] = $agentValue->agent_id;
            $agentsResult[$agentKey]['agent_code'] = $agentValue->agent_code;
            $agentsResult[$agentKey]['name'] = $agentValue->name;
            $agentsResult[$agentKey]['email'] = $agentValue->email;

        }

        return view('tables-datatable-agents', ['data' => $agentsResult]);
    }
}
