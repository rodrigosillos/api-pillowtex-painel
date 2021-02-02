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
    @slot('pagetitle') PillowTex @endslot
    @slot('title') PillowTex @endslot
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Configurar Comissões</h4>
                    <form class="repeater" enctype="multipart/form-data">
                        <div data-repeater-list="group-a">
                            <div data-repeater-item class="row">
                                <div  class="form-group col-lg-2">
                                    <label for="name">Tabela</label>
                                    <input type="text" id="name" name="untyped-input" class="form-control"/>
                                </div>

                                <div  class="form-group col-lg-2">
                                    <label for="email">Desconto</label>
                                    <input type="email" id="email" class="form-control"/>
                                </div>

                                <div  class="form-group col-lg-2">
                                    <label for="subject">Estado</label>
                                    <input type="text" id="subject" class="form-control"/>
                                </div>

                                <div  class="form-group col-lg-2">
                                    <label for="subject">Divisão</label>
                                    <input type="text" id="subject" class="form-control"/>
                                </div>
                                
                                <div class="col-lg-2 align-self-center">
                                    <input data-repeater-delete type="button" class="btn btn-primary btn-block" value="Delete"/>
                                </div>
                            </div>
                            
                        </div>
                        <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Adicionar +"/>
                        <input type="button" class="btn btn-success mt-3 mt-lg-0" value="Salvar"/>
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