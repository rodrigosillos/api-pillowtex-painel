@extends('layouts.master')
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

    <form id="frmLiquidacao" action="{{url('consulta-liquidacao')}}" method="post">
        @csrf
        <div class="row">
            @if ( Auth::user()->user_profile_id <> 3 )
            <div class="col-md-6">
                <label class="col-md-4 col-form-label">SELECIONE O REPRESENTANTE:</label>
                <div class="col-md-10">
                    <select name="search_agent" class="form-control">
                        <option value="todos">SELECIONE ...</option>
                        @foreach($agents as $key => $agent)
                            <option value="{{ $agent['agent_code'] }}" @if ( $data_form['search_agent'] === $agent['agent_code'] ) selected @endif>{{ $agent['agent_code'] . ' - ' . $agent['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            <div class="col-md-6">
                <div class="@if ( Auth::user()->user_profile_id == 3 ) float-left @else float-right @endif">
                    <!--<div class="form-inline mb-3">-->
                        <label class="col-md-6 col-form-label">DATA DE PAGAMENTO</label>
                        <div class="input-daterange input-group" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-autoclose="true">
                            <input type="text" class="form-control text-left" placeholder="De" name="dateStart" id="dateStart" value="{{ $data_form['date_start'] }}" />
                            <input type="text" class="form-control text-left" placeholder="Até" name="dateEnd" id="dateEnd" value="{{ $data_form['date_end'] }}" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-filter-variant"></i></button>
                            </div>
                        </div>
                    <!--</div>-->
                    
                </div>
            </div>
        </div>
    </form>

    <br/>
    <br/>

    <form id="frmLiquidacao2" action="{{url('export-excel-liquidacao')}}" method="post">
        @csrf
        <input type="hidden" name="rep_selecionado" value="{{ $data_form['search_agent'] }}">
        <input type="hidden" name="data_inicio" id="data_inicio">
        <input type="hidden" name="data_fim" id="data_fim">
        <div class="row">
            <div class="col-md-3">
                <div>
                    <button type="submit" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-file-excel-outline mr-1"></i> Exportar</button>
                    <button type="button" onclick="AlteraAction('{{url('desconsidera-titulo-liquidacao')}}');" class="btn btn-outline-dark waves-effect waves-light mb-3"><i class="mdi mdi-currency-usd-circle mr-1"></i> (Des)Considerar Título</button>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    @if ( Auth::user()->user_profile_id == 3 )
                        <a href="{{url('liquidacao')}}" target="_blank">
                    @else
                        <a href="#" onclick="RedirectURL('liquidacao');return false;">
                    @endif
                    </a>
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
                                        <input type="checkbox" class="custom-control-input" id="invoicecheck" onclick="SelectAll()">
                                        <label class="custom-control-label" for="invoicecheck"></label>
                                    </div>
                                </th>
                                <th>Desconsiderar</th>
                                <th>Cliente</th>
                                <th>N Documento</th>
                                <th>Representante Pedido</th>
                                <th>Representante Cliente</th>
                                <th>Representante Movimento</th>
                                <!-- <th>Data de Vencimento</th> -->
                                <th>Data de Pagamento</th>
                                <th>Comissão Liquidação</th>
                                <th>Valor Pago</th>
                                <th>Valor Inicial</th>
                                <!-- <th>Acres/Decres</th> -->                                
                                <!-- <th>Comissão Rep Pedido</th>
                                <th>Comissão Rep Cliente</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($debtors['data'] as $key => $debtor)
                            <tr  @if ($debtor['desconsiderar'] == 1) style="background-color: #808080;" @endif>
                                <td>
                                    <div class="custom-control custom-checkbox text-center">
                                        <input type="checkbox" class="custom-control-input" id="invoicecheck{{ $key }}" name="invoice_check[]" value="{{ $debtor['id'] }}">
                                        <label class="custom-control-label" for="invoicecheck{{ $key }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox text-center">
                                        <input type="checkbox" class="custom-control-input" id="desconsiderartitulo{{ $key }}" name="desconsiderar_titulo[]" value="{{ $debtor['id'] }}">
                                        <label class="custom-control-label" for="desconsiderartitulo{{ $key }}"></label>
                                    </div>
                                </td>
                                
                                <td><a href="javascript: void(0);" class="text-dark font-weight-bold">{{ $debtor['cliente'] }}</a> </td>
                                <td>
                                    {{ $debtor['documento'] }}
                                </td>
                                <td>
                                    {{ $debtor['representante_pedido'] }}
                                </td>
                                <td>
                                    {{ $debtor['representante_cliente'] }}
                                </td>
                                <td>
                                    {{ $debtor['representante_movimento'] }}
                                </td>
                                <!-- <td>
                                    {{ $debtor['data_vencimento'] }}
                                </td> -->
                                <td>
                                    {{ $debtor['data_pagamento'] }}
                                </td>
                                <td>
                                    R$ {{ number_format($debtor['comissao'], 2, ',', '.') }}
                                </td>
                                <td>
                                    R$ {{ number_format($debtor['valor_pago'], 2, ',', '.') }}
                                </td>
                                <td>
                                    R$ {{ number_format($debtor['valor_inicial'], 2, ',', '.') }}
                                </td>
                                <!-- <td>
                                    R$ {{ number_format($debtor['acres_decres'], 2, ',', '.') }}
                                </td>  -->
                                <!-- <td>
                                    R$ {{ number_format($debtor['comissao'], 2, ',', '.') }}
                                </td>
                                <td>
                                    R$ {{ number_format($debtor['comissao'], 2, ',', '.') }}
                                </td>                         -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Liquidação</th>
                                <th>Valor Comissão</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>R$ {{ number_format($total_liquidacao, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($total_commission, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
    <!-- end row -->
@endsection
@section('script')

    <script>
        function AlteraAction(acao)
        {
            if (window.confirm("Você realmente quer (des)considerar os Títulos selecionados?")) {

                document.getElementById('data_inicio').value = document.getElementById('dateStart').value;
                document.getElementById('data_fim').value = document.getElementById('dateEnd').value;

                document.getElementById("frmLiquidacao2").action = acao;
                document.getElementById("frmLiquidacao2").submit();
            }
        }
        
        function RedirectURL(module)
        {
            window.open(createDynamicURL(module), '_blank');
        }

        function createDynamicURL(module)
        {
            //The variables containing the respective IDs
            var agentID = document.getElementsByName("search_agent")[0].value;

            //Forming the variable to return    
            URL=module+"/";
            URL+=agentID;

            return URL;
        }
        function SelectAll(){  
            var ele=document.getElementsByName('invoice_check[]');  
            for(var i=0; i<ele.length; i++){  
                // if(ele[i].type=='checkbox')  
                if(ele[i].checked==false) {
                    ele[i].checked=true;
                } else {
                    ele[i].checked=false;
                }
                      
            }  
        }  
    </script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-datatables.init.js')}}"></script>

@endsection
