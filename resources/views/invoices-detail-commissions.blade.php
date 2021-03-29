@extends('layouts.master-icon-sidebar')
@section('title')
@lang('translation.Invoice_Detail')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Comissões @endslot
    @slot('title') Produtos @endslot
@endcomponent
 
    <div class="row">
        <div class="col-md-4">
            <div>
                <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-printer mr-1"></i> Imprimir</button>
                <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-file-excel-outline mr-1"></i> Exportar</button>
            </div>
        </div>
    </div>

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
                            <th>Pedido</th>
                            <th>Nota Fiscal</th>
                            <th>Cód. Produto</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Divisão</th>
                            <th>Desconto</th>
                            <th>Preço Líquido</th>
                            <th>Total Líquido</th>
                            <th>% Comissão Produto</th>
                            <th>Comissão Valor</th>
                            <th style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products['produtos'] as $key => $product)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox text-center">
                                    <input type="checkbox" class="custom-control-input" id="invoicecheck{{ $key }}">
                                    <label class="custom-control-label" for="invoicecheck{{ $key }}"></label>
                                </div>
                            </td>
                            
                            <td><a href="javascript: void(0);" class="text-dark font-weight-bold">#{{ $product['pedido'] }}</a> </td>
                            <td>
                                {{ $product['nota'] }}
                            </td>
                            <td>
                                {{ $product['produto_codigo'] }}
                            </td>
                            <td>
                                {{ $product['produto_nome'] }}
                            </td>
                            <td>
                                {{ $product['quantidade'] }}
                            </td>
                            <td>
                                {{ $product['produto_divisao'] }}
                            </td>
                            <td>
                                {{ $product['desconto'] }}%
                            </td>
                            <td>
                                R${{ number_format($product['preco'], 2, ',', '.') }}
                            </td>
                            <td>
                                R${{ number_format($product['preco'] * $product['quantidade'], 2, ',', '.') }}
                            </td>
                            <td>
                                <div class="badge badge-soft-success font-size-12">{{ $product['produto_comissao_percentual'] }}</div>
                            </td>
                            <td>
                                R${{ number_format($product['produto_comissao'], 2, ',', '.') }}
                            </td>
                            
                            <td>
                            <a href="javascript:void(0);" class="px-3 text-primary" data-toggle="tooltip" data-placement="top" title="Editar"><i class="uil uil-pen font-size-18"></i></a>
                            </td>
                        </tr>
                        @endforeach
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