<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Exports\InvoicesExport;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function exportExcel(Request $request) 
    {
        return Excel::download(new InvoicesExport($request->invoice_check), 'invoices.xls');
    }
}
