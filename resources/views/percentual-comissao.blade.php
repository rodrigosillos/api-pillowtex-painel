@extends('layouts.master')
@section('title')
@lang('translation.Percentual_Comissao')
@endsection
@section('css')
    <!-- plugin css -->
    <link href="{{ URL::asset('assets/libs/bootstrap-editable/bootstrap-editable.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Configurações @endslot
    @slot('title') CONFIGURAÇÕES @endslot
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">PERCENTUAL DE COMISSÃO POR PRODUTO</h4>
                    <form class="repeater" action="{{url('percentual-comissao-salvar')}}" method="post">
                        {{ csrf_field() }}
                        
                        <div data-repeater-list="group-a">
                            @foreach($data as $key => $value)
                            <div data-repeater-item class="row">
                                
                                <div class="form-group col-lg-2">
                                    <label for="tabela_{{ $key }}">Tabela de Preço</label>
                                    <input type="text" id="tabela_{{ $key }}" name="tabela" readonly class="form-control" value="{{ $value['tabela'] }}"/>
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="cod_divisao_{{ $key }}">Cod Divisão</label>
                                    <input type="text" id="cod_divisao_{{ $key }}" name="cod_divisao" readonly class="form-control" value="{{ $value['cod_divisao'] }}"/>
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="descricao_divisao_{{ $key }}">Descrição Divisão</label>
                                    <input type="text" id="descricao_divisao_{{ $key }}" name="descricao_divisao" readonly class="form-control" value="{{ $value['descricao_divisao'] }}"/>
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="percentual_comissao_{{ $key }}">Percentual Comissão %</label>
                                    <input type="text" id="percentual_comissao_{{ $key }}" name="percentual_comissao" class="form-control" value="{{ $value['percentual_comissao'] }}"/>
                                </div>
                                
                                <!-- <div class="col-lg-2 align-self-center">
                                    <input data-repeater-delete type="button" class="btn btn-primary btn-block" value="Apagar"/>
                                </div> -->
                                
                            </div>
                            @endforeach
                        </div>
                        <!-- <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Adicionar +"/> -->
                        <input type="submit" class="btn btn-success mt-3 mt-lg-0" value="Salvar"/>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
@section('script')
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>
@endsection