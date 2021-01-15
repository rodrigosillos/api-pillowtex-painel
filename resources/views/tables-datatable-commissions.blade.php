@extends('layouts.master')
@section('title')
@lang('translation.Datatables')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Tables @endslot
    @slot('title') Pillow Tex @endslot
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Comissões</h4>
                    <p class="card-title-desc">Descrição do Módulo Comissões.
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
                            <th>Base %</th>
                            <th>Comissão Total</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($data['value'] as $odata)
                        <tr role="row" class="odd parent">
                            <td class="sorting_1 dtr-control">{{ $odata['romaneio'] }}</td>
                            <td>{{  strftime("%d %b %Y",strtotime($odata['data'])) }}</td>
                            <td>{{ $odata['cliente'] }}</td>
                            <td>{{ $odata['cliente_nome'] }}</td>
                            <td>{{ $odata['cliente_estado'] }}</td>
                            <td>{{ $odata['representante_nome'] }}</td>
                            <td>{{ $odata['tabela_preco'] }}</td>
                            <td>R${{ $odata['total'] }}</td>
                            <td>{{ $odata['media_base_comissao'] }}%</td>
                            <td>R${{ $odata['comissao_total'] }}</td>
                        </tr>
                        
                        <thead>
                        <tr class="child">
                            <th>Pedido</th>
                            <th>Nota Fiscal</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Quantidade</th>
                            <th>Tipo</th>
                            <th>Preço</th>
                            <th>Preço Total</th>
                            <th>Comissão</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($data['value'][0]['produtos'] as $odata_product)
                        <tr role="row" class="odd parent">
                            <td>{{ $odata_product['pedido'] }}</td>
                            <td>{{ $odata_product['nota'] }}</td>
                            <td>{{ $odata_product['produto'] }}</td>
                            <td>{{ $odata_product['produto_nome'] }}</td>
                            <td>{{ $odata_product['quantidade'] }}</td>
                            <td>ZONACRIATIVA</td>
                            <td>R${{ $odata_product['preco'] }}</td>
                            <td>R${{ $odata_product['preco'] * $odata_product['quantidade'] }}</td>
                            <td>R${{ $odata_product['produto_comissao'] }}</td>
                        </tr>
                        @endforeach
                        
                        </tbody>

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