<?php

namespace App\Exports;

use App\Movimentacao;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class MovimentacaoExport implements FromCollection, WithHeadings, WithMapping
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
        return Movimentacao::whereIn('cod_operacao', $this->invoice_check)->get();
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
            'Valor Comissão Rep Pedido',
            'Valor Comissão Rep Cliente',
            'Valor Faturamento',
            'Valor Faturamento Rep Pedido',
            'Valor Faturamento Rep Cliente',
            'Representante Pedido',
            'Representante Cliente',
            'Tabela Preço',
            'Documento',
            'Ticket',
            'UF',
            'Tipo',
            'Nota Ref-Devolução',
        ];
    }

    public function map($movimentacao): array
    {
        return [
            $movimentacao->notas,
            $movimentacao->data_emissao,
            $movimentacao->cliente_codigo,
            $movimentacao->cliente_nome,
            $movimentacao->tipo_pedido,
            $movimentacao->cod_pedidov,
            $movimentacao->total,
            $movimentacao->valor_comissao,
            $movimentacao->valor_comissao_representante,
            $movimentacao->valor_comissao_representante_cliente,
            $movimentacao->valor_faturamento,
            $movimentacao->valor_faturamento_representante,
            $movimentacao->valor_faturamento_representante_cliente,
            $movimentacao->representante_nome,
            $movimentacao->representante_cliente_nome,
            $movimentacao->tabela,
            $movimentacao->romaneio,
            $movimentacao->ticket,
            $movimentacao->cliente_estado,
            $movimentacao->tipo_operacao,
            '#',
        ];
    }
}
