@extends('layouts.master-icon-sidebar')
@section('title')
@lang('translation.Invoice_List')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') PillowTex @endslot
    @slot('title') Comissões @endslot
@endcomponent
 
    <form action="{{url('consulta-comissoes')}}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4">
            <div>
                <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-printer mr-1"></i> Imprimir</button>
                <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-file-excel-outline mr-1"></i> Exportar</button>
            </div>
        </div>
        <div class="col-md-8">
            <div class="float-right">
                <div class="form-inline mb-3">
                    <div class="input-daterange input-group" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                        <input type="text" class="form-control text-left" placeholder="De" name="dateStart" />
                        <input type="text" class="form-control text-left" placeholder="Até" name="dateEnd" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary"><i class="mdi mdi-filter-variant"></i></button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    </form>

    <div class="row">
        <div class="col-lg-12">
            
            <div class="table-responsive mb-4">
                <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                    <thead>
                        <tr class="bg-transparent">
                            <th style="width: 24px;">
                                <div class="custom-control custom-checkbox text-center">
                                    <input type="checkbox" class="custom-control-input" id="invoicecheck">
                                    <label class="custom-control-label" for="invoicecheck"></label>
                                </div>
                            </th>
                            <th>NF PILLOW</th>
                            <th>Emissão</th>
                            <th>Cód. Cliente</th>
                            <th>Nome Cliente</th>
                            <th>Tipo Pedido</th>
                            <th>Cod Pedido</th>
                            <th>Valor Total</th>
                            <th>Valor Comissão</th>
                            <th>Média de Comissão</th>
                            <th>Faturamento</th>
                            <th>Liquidação</th>
                            <th>Substituido</th>
                            <th>Substituidor</th>
                            <th>Representante</th>
                            <th>Tabela Preço</th>
                            <th>Documento</th>
                            <th>UF</th>
                            <th>Tipo</th>
                            <th>Nota Ref-Devolução</th>
                            <th style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices['data'] as $key => $invoice)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox text-center">
                                    <input type="checkbox" class="custom-control-input" id="invoicecheck{{ $key }}">
                                    <label class="custom-control-label" for="invoicecheck{{ $key }}"></label>
                                </div>
                            </td>
                            <td>
                                <a href="consulta-titulos/{{ $invoice['operacao_codigo'] }}" target="_blank" class="text-dark font-weight-bold">#{{ $invoice['nota_fiscal'] }}</a>
                            </td>
                            <td>
                                {{ $invoice['data_emissao'] }}
                            </td>
                            <td>
                                {{ $invoice['cliente_codigo'] }}
                            </td>
                            <td>
                                {{ $invoice['cliente_nome'] }}
                            </td>       
                            <td>
                                {{ $invoice['pedido_tipo'] }}
                            </td>
                            <td>
                                {{ $invoice['pedido_codigo'] }}
                            </td>   
                            <td>
                                @if ($invoice['tipo_operacao_cor'] == 'warning') - @endif R${{ number_format($invoice['total'], 2, ',', '.') }}
                            </td>
                            <td>
                            @if ($invoice['tipo_operacao_cor'] == 'warning') - @endif R${{ number_format($invoice['comissao_total'], 2, ',', '.') }}
                            </td>
                            <td>
                                {{ $invoice['media_base_comissao'] }}
                            </td>
                            <td>
                                R${{ number_format($invoice['faturamento_50'], 2, ',', '.') }}
                            </td> 
                            <td>
                                R${{ number_format($invoice['liquidacao_50'], 2, ',', '.') }}
                            </td> 
                            <td>
                                R$0,00
                            </td> 
                            <td>
                                R$0,00
                            </td> 
                            <td>
                                {{ $invoice['representante_nome'] }}
                            </td>
                            <td>
                                {{ $invoice['tabela_preco'] }}
                            </td>
                            <td>
                                {{ $invoice['romaneio'] }} 
                            </td>
                            <td>
                                {{ $invoice['cliente_estado'] }}
                            </td>
                            <td>
                                <div class="badge badge-soft-{{ $invoice['tipo_operacao_cor'] }} font-size-12">{{ $invoice['tipo_operacao'] }}</div>
                            </td>
                            <td>
                                <a href="consulta-titulos/{{ $invoice['operacao_codigo'] }}" target="_blank" class="text-dark font-weight-bold">#</a>
                            </td>
                            <td>
                                <a href="consulta-titulos/{{ $invoice['operacao_codigo'] }}" target="_blank" class="px-3 text-primary" data-toggle="tooltip" data-placement="top" title="Consulta Títulos"><i class="uil uil-search-plus font-size-18"></i></a>
                                <a href="consulta-produtos/{{ $invoice['operacao_codigo'] }}" target="_blank" class="px-3 text-primary" data-toggle="tooltip" data-placement="top" title="Consulta Produtos"><i class="uil uil-search-plus font-size-18"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Valor Venda</th>
                        <th>Valor Comissão</th>
                        <th>Valor Faturamento</th>
                        <th>Valor Liquidação</th>
                        <th>Valor Substituidor</th>
                        <th>Valor Substituição</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>R${{ number_format($invoices['totalizador']['valor_venda'], 2, ',', '.') }}</td>
                        <td>R${{ number_format($invoices['totalizador']['valor_comissao'], 2, ',', '.') }}</td>
                        <td>R${{ number_format($invoices['totalizador']['valor_faturamento'], 2, ',', '.') }}</td>
                        <td>R${{ number_format($invoices['totalizador']['valor_liquidacao'], 2, ',', '.') }}</td>
                        <td>R$0,00</td>
                        <td>R$0,00</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-datatables.init.js')}}"></script>
@endsection