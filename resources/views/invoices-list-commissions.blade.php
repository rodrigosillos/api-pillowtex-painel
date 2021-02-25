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
                            <th>Documento</th>
                            <th>Emissão</th>
                            <th>Cód. Cliente</th>
                            <th>Nome Cliente</th>
                            <th>UF</th>
                            <th>Representante</th>
                            <th>Tabela Preço</th>
                            <th>Valor Total</th>
                            <th>%</th>
                            <th>Tipo</th>
                            <th>Comissão</th>
                            <th style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $key => $invoice)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox text-center">
                                    <input type="checkbox" class="custom-control-input" id="invoicecheck{{ $key }}">
                                    <label class="custom-control-label" for="invoicecheck{{ $key }}"></label>
                                </div>
                            </td>
                            
                            <td>
                                <a href="consulta-produtos/{{ $invoice['romaneio'] }}" target="_blank" class="text-dark font-weight-bold">#{{ $invoice['romaneio'] }}</a> 
                            </td>
                            <td>
                                {{ $invoice['data_emissao'] }}
                            </td>
                            <td>
                                {{ $invoice['cliente'] }}
                            </td>
                            <td>
                                {{ $invoice['cliente_nome'] }}
                            </td>
                            <td>
                                {{ $invoice['cliente_estado'] }}
                            </td>
                            <td>
                                {{ $invoice['representante_nome'] }}
                            </td>
                            <td>
                                {{ $invoice['tabela_preco'] }}
                            </td>
                            <td>
                                {{ number_format($invoice['total'], 2, ',', '.') }}
                            </td>
                            <td>
                                {{ $invoice['media_base_comissao'] }}
                            </td>
                            <td>
                                <div class="badge badge-soft-success font-size-12">Dedução</div>
                            </td>
                            <td>
                                R${{ number_format($invoice['comissao_total'], 2, ',', '.') }}
                            </td>
                            
                            <td>
                                <a href="consulta-produtos/{{ $invoice['romaneio'] }}" target="_blank" class="px-3 text-primary" data-toggle="tooltip" data-placement="top" title="Detalhes"><i class="uil uil-search-plus font-size-18"></i></a>
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