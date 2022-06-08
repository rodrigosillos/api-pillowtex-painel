@extends('layouts.master')
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
    @slot('pagetitle') COMISSÕES @endslot
    @slot('title') FATURAMENTO @endslot
@endcomponent

    <form id="frmFaturamento" action="{{url('consulta-faturamento')}}" method="post">
        @csrf
        <div class="row">
            @if ( Auth::user()->user_profile_id <> 3 )
            <div class="col-md-6">
                <label class="col-md-4 col-form-label">SELECIONE O REPRESENTANTE:</label>
                <div class="col-md-10">
                    <select name="search_agent" class="form-control">
                        <option value="todos">SELECIONE ...</option>
                        @foreach($invoices['agents'] as $key => $agent)
                            <option value="{{ $agent['agent_code'] }}" @if ( $data_form['search_agent'] == $agent['agent_code'] ) selected @endif>{{ $agent['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            <div class="col-md-6">
                <div class="@if ( Auth::user()->user_profile_id == 3 ) float-left @else float-right @endif">
                    <!--<div class="form-inline mb-3">-->
                        <label class="col-md-4 col-form-label">Data de Emissão</label>
                        <div class="input-daterange input-group" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-autoclose="true">
                            <input type="text" class="form-control text-left" placeholder="De" name="dateStart" value="{{ $data_form['date_start'] }}" />
                            <input type="text" class="form-control text-left" placeholder="Até" name="dateEnd" value="{{ $data_form['date_end'] }}" />
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

    <form id="frmFaturamento2" action="{{url('export-excel-faturamento')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <div>
                    <button type="submit" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-file-excel-outline mr-1"></i> Exportar</button>
                    <button type="button" onclick="AlteraAction('{{url('desconsidera-movimento-faturamento')}}');" class="btn btn-outline-dark waves-effect waves-light mb-3"><i class="mdi mdi-currency-usd-circle mr-1"></i> Desconsiderar Movimento</button>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    @if ( Auth::user()->user_profile_id == 3 )
                        <a href="{{url('liquidacao')}}" target="_blank">
                    @else
                        <a href="#" onclick="RedirectURL('liquidacao');return false;">
                    @endif
                    <button type="button" class="btn btn-primary waves-effect waves-light">
                        Visualizar Liquidação <i class="uil uil-arrow-right ml-2"></i> 
                    </button>
                    </a>
                    <!-- <a href="#" onclick="RedirectURL('substituicao');return false;">
                    <button disabled type="button" class="btn btn-primary waves-effect waves-light">
                        Substituição <i class="uil uil-arrow-right ml-2"></i> 
                    </button>
                    </a> -->
                    <!-- </button>
                    </a>
                    @if ( Auth::user()->user_profile_id == 3 )
                        <a href="{{url('devolucao')}}" target="_blank">
                    @else
                        <a href="#" onclick="RedirectURL('devolucao');return false;">
                    @endif
                    <button disabled type="button" class="btn btn-primary waves-effect waves-light">
                        Devolução <i class="uil uil-arrow-right ml-2"></i> 
                    </button>
                    </a> -->
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
                                <th>Nota Fiscal</th>
                                <th>Emissão</th>
                                <th>Cliente</th>
                                <th>Nome Cliente</th>
                                <th>Tipo Pedido</th>
                                <th>Pedido</th>
                                <th>Valor Total Produto</th>
                                <!--<th>Valor Produto</th>-->
                                <th>Valor Comissão</th>
                                <!-- <th>Comissão Rep Pedido</th>
                                <th>Comissão Rep Cliente</th> -->
                                <th>Faturamento</th>
                                <!-- <th>Faturamento Rep Pedido</th>
                                <th>Faturamento Rep Cliente</th> -->
                                <th>Representante Pedido</th>
                                <th>Representante Cliente</th>
                                <th>Tipo</th>
                                <th>Tabela Preço</th>
                                <th>Documento</th>
                                <th>Ticket</th>
                                <th>UF</th>
                                <th>Nota Ref-Devolução</th>
                                <th style="width: 120px;">Produtos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices['data'] as $key => $invoice)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox text-center">
                                        <input type="checkbox" class="custom-control-input" id="invoicecheck{{ $key }}" name="invoice_check[]" value="{{ $invoice['operacao_codigo'] }}">
                                        <label class="custom-control-label" for="invoicecheck{{ $key }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox text-center">
                                        <input type="checkbox" class="custom-control-input" id="desconsiderarmovimento{{ $key }}" name="desconsiderar_movimento[]" value="{{ $invoice['operacao_codigo'] }}">
                                        <label class="custom-control-label" for="desconsiderarmovimento{{ $key }}"></label>
                                    </div>
                                </td>
                                <td>
                                    {{ $invoice['nota_fiscal'] }}
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
                                <!-- <td>
                                @if ($invoice['tipo_operacao_cor'] == 'warning') - @endif R${{ number_format($invoice['valor_comissao_representante'], 2, ',', '.') }}
                                </td>
                                <td>
                                @if ($invoice['tipo_operacao_cor'] == 'warning') - @endif R${{ number_format($invoice['valor_comissao_representante_cliente'], 2, ',', '.') }}
                                </td> -->
                                <td>
                                    R${{ number_format($invoice['faturamento_50'], 2, ',', '.') }}
                                </td>
                                <!-- <td>
                                    R${{ number_format($invoice['valor_faturamento_representante'], 2, ',', '.') }}
                                </td>
                                <td>
                                    R${{ number_format($invoice['valor_faturamento_representante_cliente'], 2, ',', '.') }}
                                </td> -->
                                <td>
                                    {{ $invoice['representante_nome'] }}
                                </td>
                                <td>
                                    {{ $invoice['representante_cliente_nome'] }}
                                </td>
                                <td>
                                    <div class="badge badge-soft-{{ $invoice['tipo_operacao_cor'] }} font-size-12">{{ $invoice['tipo_operacao'] }}</div>
                                </td>
                                <td>
                                    {{ $invoice['tabela_preco'] }}
                                </td>
                                <td>
                                    {{ $invoice['romaneio'] }}
                                </td>
                                <td>
                                    {{ $invoice['ticket'] }} 
                                </td>
                                <td>
                                    {{ $invoice['cliente_estado'] }}
                                </td>
                                <td>
                                    <a href="consulta-titulos/{{ $invoice['operacao_codigo'] }}" target="_blank" class="text-dark font-weight-bold">#</a>
                                </td>
                                <td>
                                    <!--<a href="consulta-titulos/{{ $invoice['operacao_codigo'] }}" target="_blank" class="px-3 text-primary" data-toggle="tooltip" data-placement="top" title="Consulta Títulos"><i class="uil uil-search-plus font-size-18"></i></a>-->
                                    <a href="consulta-produtos/{{ $invoice['operacao_codigo'] }}" target="_blank" class="px-3 text-primary" data-toggle="tooltip" data-placement="top" title="Visualizar Produtos"><i class="uil uil-search-plus font-size-18"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Faturamento (Valor sem Imposto)</th>
                            <th>Base de Comissão</th>
                            <th>Valor Comissão</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>R${{ number_format($invoices['totalizador']['valor_venda'], 2, ',', '.') }}</td>
                            <td>R${{ number_format($invoices['totalizador']['valor_comissao'], 2, ',', '.') }}</td>
                            <td>R${{ number_format($invoices['totalizador']['valor_faturamento'], 2, ',', '.') }}</td>
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
            document.getElementById("frmFaturamento2").action = acao;
            document.getElementById("frmFaturamento2").submit();
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
