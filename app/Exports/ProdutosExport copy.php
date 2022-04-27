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
        // comissao produto

        // invoice
        $invoice = DB::table('invoices')
        ->select(['price_list', 'client_address', 'invoice_type', 'operation_type'])
        ->where('operation_code', $produtos->operation_code)
        ->first();

        // commission
        $tableId = $invoice->price_list;
        $clientAddress = $invoice->client_address;
        $invoiceType = $invoice->invoice_type;
        $operationType = $invoice->operation_type;
        
        if($clientAddress == null)
            $clientAddress = 'SP';

        $tableCode = 214;

        if($tableId == 4)
            $tableCode = 214;

        if($tableId == 104)
            $tableCode = 187;

        $commissionPercentage = 8;
        $commissionAmount = 0;

        $commissionSettings = DB::table('commission_settings')
            ->where('product_division', $produtos->division_code)
            ->where('price_list', $tableCode)
            ->get();

            if(isset($commissionSettings[0]))
                $commissionPercentage = $commissionSettings[0]->percentage;

            if($tableCode == 187) {
                if($clientAddress != 'SP' && $produtos->discount < 5)
                    $commissionPercentage = 3;
            }

            if($invoiceType == 'ZC PEDIDO ESPECIAL') {
                $dataConsultaMovimentacao = '?tipo_operacao='.$operationType.'&cod_operacao='.$operationCode.'&ujuros=false&$format=json&$dateformat=iso';
                $resultConsultaMovimentacao = $this->connection('/movimentacao/consulta', $dataConsultaMovimentacao);
                $commissionPercentage = $resultConsultaMovimentacao['value'][0]['comissao_r'];
            }
            
            $commissionAmount = floor(($produtos->price * $produtos->quantity) * $commissionPercentage) / 100;

            if($tableCode == 214 && $produtos->discount > 5)
                $commissionAmount = ($commissionAmount / 2);

        // fim comissao produto
        
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
            sprintf("%.2f%%", $commissionPercentage),
            $commissionAmount,
        ];
    }
}
