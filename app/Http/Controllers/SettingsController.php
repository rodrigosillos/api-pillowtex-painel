<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        return view('form-repeater');
    }

    public function get(Request $request)
    {
        $users = DB::table('users')->get();
        dd($users);
    }
}
