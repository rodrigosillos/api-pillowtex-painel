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
                    <h4 class="card-title mb-4">Configurar Tipos de Pagamento</h4>
                    <form class="repeater" action="{{url('tipos-pgto-salvar')}}" method="post">
                        {{ csrf_field() }}
                        
                        <div data-repeater-list="group-a">
                            @foreach($data as $key => $value)
                            <div data-repeater-item class="row">

                                <input type="hidden" id="tipo_pgto_{{ $key }}" name="tipo_pgto" value="{{ $value['tipo_pgto'] }}"/>
                                
                                <div class="form-group col-lg-2">
                                    <label for="descricao_{{ $key }}">Tipo de Pedido</label>
                                    <input type="text" id="descricao_{{ $key }}" name="descricao" class="form-control" value="{{ $value['descricao'] }}"/>
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="oculto_{{ $key }}">Ocultar?</label>
                                    <input type="text" id="oculto_{{ $key }}" name="oculto" class="form-control" value="{{ $value['oculto'] }}"/>
                                </div>
                                
                                <div class="col-lg-2 align-self-center">
                                    <input data-repeater-delete type="button" class="btn btn-primary btn-block" value="Apagar"/>
                                </div>
                                
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