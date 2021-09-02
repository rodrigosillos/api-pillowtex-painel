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

                <div data-simplebar style="max-height: 336px;">
                    <div class="table-responsive">
                        <table class="table table-borderless table-centered table-nowrap">
                            <tbody>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">CAISA GIFT</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$84.527,05</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ATLANTA RIO TECIDOS E REPRESENTACOES LTDA</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>RIO DE JANEIRO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$76.725,11</td>
                                </tr> 
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ZONA CRIATIVA - DANIELA GUIMARES</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$42.020,50</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ZONA CRIATIVA</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$34.576,03</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">LEONARDO FELIPE DOS SANTOS SILVA 40120680831</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>GUARULHOS</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$19.652,39</td>
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
                                        <h6 class="font-size-15 mb-1 font-weight-normal">EDUARDO DE ROSA KRAJUSKINAS REPRES...</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$1.460.832,82</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">CAISA GIFT</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$543.458,16</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ERICO MARCHONI BIANCO</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$467.293,87</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ZONA CRIATIVA</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$455.212,69</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">CAMENA - REPRESENTACAO COMERCIAL LTDA.</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>CURITIBA</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$312.546,24</td>
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
                                        <h6 class="font-size-15 mb-1 font-weight-normal">EDUARDO DE ROSA KRAJUSKINAS REPRES...</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$12.561,02</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">CAISA GIFT</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$16.325,29</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ZONA CRIATIVA</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$15.824,38</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">CAMENA - REPRESENTACAO COMERCIAL LTDA.</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>CURITIBA</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$9.827,71</td>
                                </tr> 
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ERICO MARCHONI BIANCO</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$4.538,98</td>
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
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info me-2"></i> IMPORTADO-LICENCIADO </p>
            </div>
            <div class="col-sm-9">
                R$2.273.198,77
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
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary me-2"></i> IMPORTADO </p>
            </div>

            <div class="col-sm-9">
                R$872.732,78
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
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info me-2"></i> IMPORTADO-LICENCIADO-FL PROMOO </p>
            </div>
            <div class="col-sm-9">
                R$40.654,06
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
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info me-2"></i> IMPORTADO FL PROMOO </p>
            </div>
            <div class="col-sm-9">
                R$1.043.855,53
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
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-warning me-2"></i> NACIONAL-LICENCIADO </p>
            </div>
            <div class="col-sm-9">
                R$1.058.279,28
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
                R$1.701.082,39
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
                R$105.631,80
                <div class="progress mt-1" style="height: 6px;">
                    <div class="progress-bar progress-bar bg-purple" role="progressbar"
                        style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                        aria-valuemax="63">
                    </div>
                </div>
            </div>
        </div> <!-- end row-->

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

        <div class="row align-items-center g-0 mt-3">
            <div class="col-sm-3">
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info me-2"></i> IMPORTADO-LICENCIADO </p>
            </div>
            <div class="col-sm-9">
                77916
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
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary me-2"></i> IMPORTADO </p>
            </div>

            <div class="col-sm-9">
                35024
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
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info me-2"></i> IMPORTADO-LICENCIADO-FL PROMOO </p>
            </div>
            <div class="col-sm-9">
                3359
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
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info me-2"></i> IMPORTADO FL PROMOO </p>
            </div>
            <div class="col-sm-9">
                108039
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
                <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-warning me-2"></i> NACIONAL-LICENCIADO </p>
            </div>
            <div class="col-sm-9">
                36086
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
                68245
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
                6489
                <div class="progress mt-1" style="height: 6px;">
                    <div class="progress-bar progress-bar bg-purple" role="progressbar"
                        style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                        aria-valuemax="63">
                    </div>
                </div>
            </div>
        </div> <!-- end row-->

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