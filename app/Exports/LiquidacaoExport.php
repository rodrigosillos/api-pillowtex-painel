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
        return Liquidacao::whereIn('origem', $this->invoice_check)->get();
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'N Documento',
            'Operação',
            'Data Vencimento',
            'Data Pagamento',
            'Valor Título',
            'Comissão Liquidação',
        ];
    }

    public function map($liquidacao): array
    {
        $dataVencimento = date_create($liquidacao->data_vencimento);
        $dataPagamento = date_create($liquidacao->data_pagamento);
        
        return [
            $liquidacao->cliente_nome,
            $liquidacao->numero_documento,
            $liquidacao->origem,
            date_format($dataVencimento, "d/m/Y"),
            date_format($dataPagamento, "d/m/Y"),
            number_format($liquidacao->valor_inicial, 2, ',', '.'),
            number_format($liquidacao->valor_comissao, 2, ',', '.'),
        ];
    }
}
