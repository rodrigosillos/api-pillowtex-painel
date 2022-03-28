<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use App\Exports\ProdutosExport;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;


class ExcelProdutosController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function exportExcel(Request $request) 
    {
        return Excel::download(new ProdutosExport($request->invoice_check), 'relatorio-produtos.xls');
    }
}
