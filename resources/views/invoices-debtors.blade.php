@extends('layouts.master-icon-sidebar')
@section('title')
@lang('translation.Debtors_Detail')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') COMISSÕES @endslot
    @slot('title') LIQUIDAÇÃO @endslot
@endcomponent
 
    <div class="row">
        <div class="col-md-4">
            <div>
                <!--<button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-printer mr-1"></i> Imprimir</button>-->
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
                            <th>Cliente</th>
                            <th>Lançamento</th>
                            <th>Operação</th>
                            <th>N Documento</th>
                            <th>Data de Vencimento</th>
                            <th>Data de Pagamento</th>
                            <th>Efetuado</th>
                            <th>Substituido</th>
                            <th>Valor</th>
                            <th>Comissão Liquidação</th>
                            <th style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($debtors['data'] as $key => $debtor)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox text-center">
                                    <input type="checkbox" class="custom-control-input" id="invoicecheck{{ $key }}">
                                    <label class="custom-control-label" for="invoicecheck{{ $key }}"></label>
                                </div>
                            </td>
                            
                            <td><a href="javascript: void(0);" class="text-dark font-weight-bold">#{{ $debtor['cliente'] }}</a> </td>
                            <td>
                                {{ $debtor['lancamento'] }}
                            </td>
                            <td>
                                {{ $debtor['codigo_operacao'] }}
                            </td>
                            <td>
                                {{ $debtor['documento'] }}
                            </td>
                            <td>
                                {{ $debtor['data_vencimento'] }}
                            </td>

                            <td>
                                {{ $debtor['data_pagamento'] }}
                            </td>

                            <td>
                                {{ $debtor['efetuado'] }}
                            </td>
                            <td>
                                {{ $debtor['substituido'] }}
                            </td>
                            <td>
                                R$ {{ number_format($debtor['valor_inicial'], 2, ',', '.') }}
                            </td>
                            <td>
                                R$ {{ number_format($debtor['comissao'], 2, ',', '.') }}
                            </td>                             
                            <td>
                            <a href="javascript:void(0);" class="px-3 text-primary" data-toggle="tooltip" data-placement="top" title="Editar"><i class="uil uil-pen font-size-18"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Valor Liquidação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>R$ {{ number_format($total_commission, 2, ',', '.') }}</td>
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