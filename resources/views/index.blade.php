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
                                        <h6 class="font-size-15 mb-1 font-weight-normal">FAMA REPRESENTAO COMERCIAL EIRELI</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>INDAIATUBA</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$51.589,48</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ZONA CRIATIVA</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$39.898,40</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">GUSTAVO ANDRE GOBBO OBREGON DOS SANTOS</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>São Paulo</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$19.652,39</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">EDUARDO DE ROSA KRAJUSKINAS REPRES...</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$17.447,88</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ATLANTA RIO TECIDOS E REPRESENTACOES LTDA</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>RIO DE JANEIRO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$12.586,27</td>
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
                                        <h6 class="font-size-15 mb-1 font-weight-normal">CAISA GIFT</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$976.633,26</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">CAMENA - REPRESENTACAO COMERCIAL LTDA.</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>CURITIBA</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$640.710,59</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">ZONA CRIATIVA</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$622.931,64</td>
                                </tr>
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">HORLEY FONTANELLA E CIA LTDA</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>BALNEARIO CAMBORIU</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$403.735,61</td>
                                </tr> 
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">FAMA REPRESENTAO COMERCIAL EIRELI</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>INDAIATUBA</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$347.707,13</td>
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
                                    <h6 class="font-size-15 mb-1 font-weight-normal">CAISA GIFT</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                </td>
                                <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$28.000,91</td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 font-weight-normal">CAMENA - REPRESENTACAO COMERCIAL LTDA.</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>CURITIBA</p>
                                </td>
                                <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$20.833,52</td>
                            </tr>                            
                            <tr>
                                <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 font-weight-normal">ZONA CRIATIVA</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>SAO PAULO</p>
                                </td>
                                <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$18.857,68</td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 font-weight-normal">FAMA REPRESENTAO COMERCIAL EIRELI</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>INDAIATUBA</p>
                                </td>
                                <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$11.887,68</td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 font-weight-normal">HORLEY FONTANELLA E CIA LTDA</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>BALNEARIO CAMBORIU</p>
                                </td>
                                <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R$11.102,08</td>
                            </tr>                                                                                                                                                              
                        </tbody>
                    </table>
                </div> <!-- enbd table-responsive-->
            </div> <!-- data-sidebar-->
        </div><!-- end card-body-->
    </div> <!-- end card-->
</div><!-- end col -->

</div> <!-- end row-->

@endsection
@section('script')
       <!-- apexcharts -->
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
@endsection