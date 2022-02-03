<?php

namespace App\Exports;

use App\Invoice;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $invoice_check;

    function __construct($invoice_check) {
        $this->invoice_check = $invoice_check;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoice::whereIn('operation_code', $this->invoice_check)->get();
    }

    public function headings(): array
    {
        return [
            'Nota Fiscal',
            'Emissão',
            'Cod Cliente',
            'Nome Cliente',
            'Tipo Pedido',
            'Cod Pedido',
            'Valor Total Produtos',
            'Valor Comissão',
            'Valor Faturamento',
            // 'Média de Comissão',
            // 'Liquidação',
            // 'Substituido',
            // 'Substituidor',
            'Representante',
            'Tabela Preço',
            'Documento',
            'Ticket',
            'UF',
            'Tipo',
            'Nota Ref-Devolução',
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->invoice,
            $invoice->issue_date,
            $invoice->client_code,
            $invoice->client_name,
            $invoice->invoice_type,
            $invoice->order_code,
            $invoice->amount_withouttax,
            $invoice->commission_amount,
            $invoice->valor_faturamento,
            $invoice->agent_name,
            $invoice->price_list,
            $invoice->document,
            $invoice->ticket,
            $invoice->client_address,
            $invoice->operation_type,
            '#',
        ];
    }
}
