<?php

namespace App\Http\Controllers;

use App\Models\Liquidacao;
use App\Exports\LiquidacaoExport;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;


class ExcelProdutosController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function exportExcel(Request $request) 
    {
        return Excel::download(new LiquidacaoExport($request->invoice_check), 'liquidacao.xls');
    }
}
