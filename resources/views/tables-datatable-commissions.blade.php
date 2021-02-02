@extends('layouts.master-icon-sidebar')
@section('title')
@lang('translation.Datatables')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') PillowTex @endslot
    @slot('title') PillowTex @endslot
@endcomponent

    <form action="{{url('consulta-comissoes')}}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-4">
                <div>
                    <h1 class="mb-3">Olá, {{Auth::user()->name}}!</h1>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Comissões</h4>
                    <p class="card-title-desc">Módulo Comissões.
                    </p>

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Emissão</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>UF</th>
                            <th>Representante</th>
                            <th>Tabela Preço</th>
                            <th>Valor Total</th>
                            <th>%</th>
                            <th>Tipo</th>
                            <th>Comissão</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($data as $odata)
                        <tr role="row" class="odd parent">
                            <td class="sorting_1 dtr-control">{{ $odata['romaneio'] }}</td>
                            <td>{{ $odata['data'] }}</td>
                            <td>{{ $odata['cliente'] }}</td>
                            <td>{{ $odata['cliente_nome'] }}</td>
                            <td>{{ $odata['cliente_estado'] }}</td>
                            <td>{{ $odata['representante_nome'] }}</td>
                            <td>{{ $odata['tabela_preco'] }}</td>
                            <td>R${{ number_format($odata['total'], 2, ',', '.') }}</td>
                            <td>{{ $odata['media_base_comissao'] }}</td>
                            <td>Dedução</td>
                            <td>R${{ number_format($odata['comissao_total'], 2, ',', '.') }}</td>
                        </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
@endsection