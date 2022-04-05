<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use App\Exports\MovimentacaoExport;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;


class ExcelMovimentacaoController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function exportExcel(Request $request) 
    {
        return Excel::download(new MovimentacaoExport($request->invoice_check), 'relatorio-faturamento.xls');
    }
}
