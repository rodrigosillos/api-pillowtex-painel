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
    public function exportExcel($type) 
    {
        return Excel::download(new InvoicesExport, 'invoices.'.$type);
    }
}
