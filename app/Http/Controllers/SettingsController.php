<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $resultSettings = ['data' => []];
        
        $commissionSettings = DB::table('commission_settings')->get();

        foreach($commissionSettings as $settingKey => $setting) {
            $productDivision = $setting->product_division;
            $priceList = $setting->price_list;
            $percentage = $setting->percentage;

            $resultSettings['data'][$settingKey]['produto_divisao'] = $productDivision;
            $resultSettings['data'][$settingKey]['tabela_preco'] = $priceList;
            $resultSettings['data'][$settingKey]['percentual'] = $percentage;
        }

        return view('form-commission-settings',
        [
            'settings' => $resultSettings,
        ]);
    }

    public function set(Request $request)
    {
        DB::table('commission_settings')->truncate();

        $settings = $request->get('group-a');

        foreach($settings as $setting) {

            if(!empty($setting['product_division']) && !empty($setting['price_list'])) {

                DB::table('commission_settings')->insert([
                    'product_division' => $setting['product_division'],
                    'price_list' => $setting['price_list'],
                    'percentage' => $setting['percentage'],
                ]);

            }
        }

        return redirect()->action([SettingsController::class, 'index']);

    }
}
