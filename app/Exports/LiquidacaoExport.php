<?php

namespace App\Exports;

use App\Liquidacao;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class LiquidacaoExport implements FromCollection, WithHeadings, WithMapping
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
        return Liquidacao::where('desconsiderar', 0)->whereIn('id', $this->invoice_check)->get();
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'N Documento',
            'Representante Pedido',
            'Representante Cliente',
            'Representante Movimento',
            'Data Pagamento',
            'Comissão Liquidação',
            'Valor Pago',
            'Valor Inicial',            
        ];
    }

    public function map($liquidacao): array
    {
        $dataPagamento = date_create($liquidacao->data_pagamento);
        
        return [
            $liquidacao->cliente_nome,
            $liquidacao->n_documento,
            $liquidacao->representante_pedido,
            $liquidacao->representante_cliente,
            $liquidacao->representante_movimento,
            date_format($dataPagamento, "d/m/Y"),
            number_format($liquidacao->valor_comissao, 2, ',', '.'),
            number_format($liquidacao->valor_pago, 2, ',', '.'),
            number_format($liquidacao->valor_inicial, 2, ',', '.'),            
        ];
    }
}
