<?php

namespace App\Exports;

use App\Produtos;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProdutosExport implements FromCollection, WithHeadings, WithMapping
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
        return Produtos::whereIn('id', $this->invoice_check)->get();
    }

    public function headings(): array
    {
        return [
            'Pedido',
            'Nota Fiscal',
            'Código',
            'Produto',
            'Quantidade',
            'Divisão',
            'Desconto',
            'Preço Liquido',
            'Total Liquido',
            'Comissão Produto',
            'Comissão Valor',
        ];
    }

    public function map($produtos): array
    {
        $totalLiquido = ($produtos->price * $produtos->quantity);
        
        return [
            $produtos->order_id,
            $produtos->invoice,
            $produtos->product_code,
            $produtos->product_name,
            $produtos->quantity,
            $produtos->division_description,
            $produtos->discount,
            $produtos->price,
            $totalLiquido,
            '0.00',
            '0.00',
        ];
    }
}
