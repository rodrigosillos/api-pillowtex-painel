<?php

namespace App\Exports;

use App\Produtos;

use Illuminate\Support\Facades\DB;

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
        return [
            $produtos->pedido,
            $produtos->nota,
            $produtos->cod_produto,
            $produtos->descricao1,
            $produtos->quantidade,
            $produtos->descricao_divisao,
            $produtos->desconto,
            $produtos->preco,
            ($produtos->preco * $produtos->quantidade),
            sprintf("%.2f%%", $produtos->percentual_comissao),
            $produtos->valor_comissao,
        ];
    }
}
