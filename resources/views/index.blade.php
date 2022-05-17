@extends('layouts.master-icon-sidebar')
@section('title') @lang('translation.Dashboard') @endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') PillowTex @endslot
    @slot('title') DASHBOARD - {{ $mes_ano }} @endslot
@endcomponent 
<div class="row">

    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">DEVOLUÇÕES POR REPRESENTANTE</h4>
            </div><!-- end card-body-->
        </div> <!-- end card-->
    </div><!-- end col -->
    
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">VENDAS POR REPRESENTANTE</h4>
            </div><!-- end card-body-->
        </div> <!-- end card-->
    </div><!-- end col -->

    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">COMISSÕES POR REPRESENTANTE</h4>
            </div> <!-- data-sidebar-->
        </div><!-- end card-body-->
    </div> <!-- end card-->
</div><!-- end col -->

</div> <!-- end row-->

<div class="row">

    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">CIDADES/ESTADOS ATENDIDOS POR REPRESENTANTE</h4>


            </div>
        </div>
    </div> <!-- end Col -->

    <div class="col-xl-4">

<div class="card">
    <div class="card-body">

        <h4 class="card-title mb-4">RANKING DE DIVISÕES POR VALOR (R$)</h4>




        <!-- <div class="row align-items-center g-0 mt-3">
            <div class="col-sm-3">
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple me-2"></i> LOJAS ZONA CRIATIVA </p>
            </div>
            <div class="col-sm-9">
                R$919,16
                <div class="progress mt-1" style="height: 6px;">
                    <div class="progress-bar progress-bar bg-info" role="progressbar"
                        style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                        aria-valuemax="45">
                    </div>
                </div>
            </div>
        </div> end row -->

    </div> <!-- end card-body-->
</div> <!-- end card-->
</div> <!-- end Col -->

<div class="col-xl-4">

<div class="card">
    <div class="card-body">

        <h4 class="card-title mb-4">QTDE DE PEÇAS VENDIDAS POR DIVISÃO</h4>

        <!-- <div class="row align-items-center g-0 mt-3">
            <div class="col-sm-3">
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple me-2"></i> LOJAS ZONA CRIATIVA </p>
            </div>
            <div class="col-sm-9">
                34
                <div class="progress mt-1" style="height: 6px;">
                    <div class="progress-bar progress-bar bg-info" role="progressbar"
                        style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                        aria-valuemax="45">
                    </div>
                </div>
            </div>
        </div> end row -->

    </div> <!-- end card-body-->
</div> <!-- end card-->
</div> <!-- end Col -->
    
</div> <!-- end row-->

@endsection
@section('script')
       <!-- apexcharts -->
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
@endsection