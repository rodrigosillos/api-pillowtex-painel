@extends('layouts.master-icon-sidebar')
@section('title') @lang('translation.Dashboard') @endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') PillowTex @endslot
    @slot('title') DASHBOARD - Junho/2021 @endslot
@endcomponent 
<div class="row">

    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <!--
                <div class="float-right">
                    <div class="dropdown">
                        <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted">Periodo<i class="mdi mdi-chevron-down ml-1"></i></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <a class="dropdown-item" href="#">30 dias</a>
                            <a class="dropdown-item" href="#">60 dias</a>
                            <a class="dropdown-item" href="#">90 dias</a>
                        </div>
                    </div>
                </div>
                -->
                <h4 class="card-title mb-4">DEVOLUÇÕES POR REPRESENTANTE</h4>

                <div data-simplebar style="max-height: 336px;">
                    <div class="table-responsive">
                        <table class="table table-borderless table-centered table-nowrap">
                            <tbody>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ERICO MARCHONI BIANCO</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> São Paulo</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R${{ number_format($card5, 2, '.', ',') }}</td>
                                </tr>                                                                                                                             
                            </tbody>
                        </table>
                    </div> <!-- enbd table-responsive-->
                </div> <!-- data-sidebar-->
            </div><!-- end card-body-->
        </div> <!-- end card-->
    </div><!-- end col -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">VENDAS POR REPRESENTANTE</h4>

                <div data-simplebar style="max-height: 336px;">
                    <div class="table-responsive">
                        <table class="table table-borderless table-centered table-nowrap">
                            <tbody>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ERICO MARCHONI BIANCO</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> São Paulo</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R${{ number_format($vendas_representantes, 2, '.', ',') }}</td>
                                </tr>                                                                                                                             
                            </tbody>
                        </table>
                    </div> <!-- enbd table-responsive-->
                </div> <!-- data-sidebar-->
            </div><!-- end card-body-->
        </div> <!-- end card-->
    </div><!-- end col -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">COMISSÕES POR REPRESENTANTE</h4>

                <div data-simplebar style="max-height: 336px;">
                    <div class="table-responsive">
                        <table class="table table-borderless table-centered table-nowrap">
                            <tbody>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ERICO MARCHONI BIANCO</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> São Paulo</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R${{ number_format($comissoes_representantes, 2, '.', ',') }}</td>
                                </tr>                                                                                                                             
                            </tbody>
                        </table>
                    </div> <!-- enbd table-responsive-->
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

                <ol class="activity-feed mb-0 ps-2" data-simplebar style="max-height: 255px;">
                    @foreach($card6 as $agent)
                    <li class="feed-item">
                        <div class="feed-item-list">
                            <p class="text-muted mb-1 font-size-13">{{ $agent->address_city }}</p>
                            <p class="mt-0 mb-0">{{ $agent->address_state }} <span class="text-primary">+</span></p>
                        </div>
                    </li>
                    @endforeach
                </ol>

            </div>
        </div>
    </div> <!-- end Col -->    
<div class="col-xl-4">

<div class="card">
    <div class="card-body">

        <h4 class="card-title mb-4">RANKING DE DIVISÕES POR VALOR (R$)</h4>

        <div class="row align-items-center g-0 mt-3">
            <div class="col-sm-3">
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary me-2"></i> IMPORTADO </p>
            </div>

            <div class="col-sm-9">
                un. R$4.624,09 - total: R$148.773,58
                <div class="progress mt-1" style="height: 6px;">
                    <div class="progress-bar progress-bar bg-primary" role="progressbar"
                        style="width: 52%" aria-valuenow="52" aria-valuemin="0"
                        aria-valuemax="52">
                    </div>
                </div>
            </div>
        </div> <!-- end row-->

        <div class="row align-items-center g-0 mt-3">
            <div class="col-sm-3">
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info me-2"></i> IMPORTADO-LICENCIADO </p>
            </div>
            <div class="col-sm-9">
                un. R$8.004,75 - total: R$282.343,14
                <div class="progress mt-1" style="height: 6px;">
                    <div class="progress-bar progress-bar bg-info" role="progressbar"
                        style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                        aria-valuemax="45">
                    </div>
                </div>
            </div>
        </div> <!-- end row-->

        <div class="row align-items-center g-0 mt-3">
            <div class="col-sm-3">
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-success me-2"></i> IMPORTADO FL PROMOO </p>
            </div>
            <div class="col-sm-9">
                un. R$25,47 - total: R$611,28
                <div class="progress mt-1" style="height: 6px;">
                    <div class="progress-bar progress-bar bg-success" role="progressbar"
                        style="width: 48%" aria-valuenow="48" aria-valuemin="0"
                        aria-valuemax="48">
                    </div>
                </div>
            </div>
        </div> <!-- end row-->

        <div class="row align-items-center g-0 mt-3">
            <div class="col-sm-3">
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-warning me-2"></i> NACIONAL-LICENCIADO </p>
            </div>
            <div class="col-sm-9">
                un. R$2.510,07 - total: R$53.974,14
                <div class="progress mt-1" style="height: 6px;">
                    <div class="progress-bar progress-bar bg-warning" role="progressbar"
                        style="width: 78%" aria-valuenow="78" aria-valuemin="0"
                        aria-valuemax="78">
                    </div>
                </div>
            </div>
        </div> <!-- end row-->

        <div class="row align-items-center g-0 mt-3">
            <div class="col-sm-3">
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple me-2"></i> NACIONAL </p>
            </div>
            <div class="col-sm-9">
                un. R$112,60 - total: R$1.508,82
                <div class="progress mt-1" style="height: 6px;">
                    <div class="progress-bar progress-bar bg-purple" role="progressbar"
                        style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                        aria-valuemax="63">
                    </div>
                </div>
            </div>
        </div> <!-- end row-->

        <div class="row align-items-center g-0 mt-3">
            <div class="col-sm-3">
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple me-2"></i> IMPORTADO-NG </p>
            </div>
            <div class="col-sm-9">
                un. R$190,41 - total: R$4.569,84
                <div class="progress mt-1" style="height: 6px;">
                    <div class="progress-bar progress-bar bg-purple" role="progressbar"
                        style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                        aria-valuemax="63">
                    </div>
                </div>
            </div>
        </div> <!-- end row-->

    </div> <!-- end card-body-->
</div> <!-- end card-->
</div> <!-- end Col -->


    <div class="col-xl-4">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">QTDE DE PEÇAS VENDIDAS POR DIVISÃO</h4>

                <div class="row align-items-center g-0 mt-3">
                    <div class="col-sm-3">
                        <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary me-2"></i> IMPORTADO </p>
                    </div>

                    <div class="col-sm-9">
                        9449
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar progress-bar bg-primary" role="progressbar"
                                style="width: 52%" aria-valuenow="52" aria-valuemin="0"
                                aria-valuemax="52">
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->

                <div class="row align-items-center g-0 mt-3">
                    <div class="col-sm-3">
                        <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info me-2"></i> IMPORTADO-LICENCIADO </p>
                    </div>
                    <div class="col-sm-9">
                        15527
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar progress-bar bg-info" role="progressbar"
                                style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                                aria-valuemax="45">
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->

                <div class="row align-items-center g-0 mt-3">
                    <div class="col-sm-3">
                        <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-success me-2"></i> IMPORTADO FL PROMOO </p>
                    </div>
                    <div class="col-sm-9">
                        48
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar progress-bar bg-success" role="progressbar"
                                style="width: 48%" aria-valuenow="48" aria-valuemin="0"
                                aria-valuemax="48">
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->

                <div class="row align-items-center g-0 mt-3">
                    <div class="col-sm-3">
                        <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-warning me-2"></i> NACIONAL-LICENCIADO </p>
                    </div>
                    <div class="col-sm-9">
                        2310
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar progress-bar bg-warning" role="progressbar"
                                style="width: 78%" aria-valuenow="78" aria-valuemin="0"
                                aria-valuemax="78">
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->

                <div class="row align-items-center g-0 mt-3">
                    <div class="col-sm-3">
                        <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple me-2"></i> NACIONAL </p>
                    </div>
                    <div class="col-sm-9">
                        94
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar progress-bar bg-purple" role="progressbar"
                                style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                                aria-valuemax="63">
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->

                <div class="row align-items-center g-0 mt-3">
                    <div class="col-sm-3">
                        <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple me-2"></i> IMPORTADO-NG </p>
                    </div>
                    <div class="col-sm-9">
                        312
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar progress-bar bg-purple" role="progressbar"
                                style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                                aria-valuemax="63">
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end Col -->
</div><!-- end row -->

<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <div id="total-revenue-chart"></div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1">R$<span data-plugin="counterup">{{ number_format($card1, 2, '.', ',') }}</span></h4>
                    <p class="text-muted mb-0">R$ DE COMISSÃO REPRESENTA O FATURAMENTO</p>
                </div>
                <p class="text-muted mt-3 mb-0"><span class="text-success mr-1"><i class="mdi mdi-arrow-up-bold ml-1"></i>0.00%</span> desde o mês passado
                </p>
            </div>
        </div>
    </div> <!-- end col-->
</div><!-- end row -->

@endsection
@section('script')
       <!-- apexcharts -->
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
@endsection