@extends('layouts.master-icon-sidebar')
@section('title')
@lang('translation.Form_Repeater')
@endsection
@section('css')
    <!-- plugin css -->
    <link href="{{ URL::asset('assets/libs/bootstrap-editable/bootstrap-editable.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Configurações @endslot
    @slot('title') Comissão @endslot
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Configurar Percentual de Commissão</h4>
                    <form class="repeater" action="{{url('configurar-comissoes-salvar')}}" method="post">
                        {{ csrf_field() }}
                        
                        <div data-repeater-list="group-a">
                            @foreach($settings['data'] as $key => $setting)
                            <div data-repeater-item class="row">
                                
                                <div class="form-group col-lg-2">
                                    <label for="price_list_{{ $key }}">Tabela Preço</label>
                                    <input type="text" id="price_list_{{ $key }}" name="price_list" class="form-control" value="{{ $setting['tabela_preco'] }}"/>
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="product_division_{{ $key }}">Divisão</label>
                                    <input type="text" id="product_division_{{ $key }}" name="product_division" class="form-control" value="{{ $setting['produto_divisao'] }}"/>
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="percentage_{{ $key }}">Percentual Comissão %</label>
                                    <input type="text" id="percentage_{{ $key }}" name="percentage" class="form-control" value="{{ $setting['percentual'] }}"/>
                                </div>
                                
                                <div class="col-lg-2 align-self-center">
                                    <input data-repeater-delete type="button" class="btn btn-primary btn-block" value="Delete"/>
                                </div>
                                
                            </div>
                            @endforeach
                        </div>
                        <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Adicionar +"/>
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