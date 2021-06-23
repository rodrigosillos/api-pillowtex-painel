@extends('layouts.master-icon-sidebar')
@section('title')
@lang('translation.Agents')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Comissões @endslot
    @slot('title') Representantes @endslot
@endcomponent
 
    <div class="row">
        <div class="col-md-4">
            <div>
                <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus mr-1"></i> Novo Representante</button>
            </div>
        </div>
        <div class="col-md-8">
            <div class="float-right">
                <div class="form-inline mb-3">
                </div>
                
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
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $odata)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox text-center">
                                    <input type="checkbox" class="custom-control-input" id="invoicecheck1">
                                    <label class="custom-control-label" for="invoicecheck1"></label>
                                </div>
                            </td>
                            
                            <td><a href="javascript: void(0);" class="text-dark font-weight-bold">{{ $odata['agent_id'] }}</a> </td>
                            <td>{{ $odata['agent_code'] }}</td>
                            <td>{{ $odata['name'] }}</td>
                            <td>{{ $odata['email'] }}</td>
                            <td>{{ $odata['cidade'] }}</td>
                            <td>{{ $odata['estado'] }}</td>
                            <td>
                                <a href="javascript:void(0);" class="px-3 text-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="uil uil-pen font-size-18"></i></a>
                                <a href="javascript:void(0);" class="px-3 text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="uil uil-trash-alt font-size-18"></i></a>
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