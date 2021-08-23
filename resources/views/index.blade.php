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
                                @foreach($devolucoes_representante as $devolucao)
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">{{ $devolucao->agent_name }}</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Brasil</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R${{ number_format($devolucao->valor_devolucao, 2, '.', ',') }}</td>
                                </tr>
                                @endforeach                                                                                                                             
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
                                @foreach($vendas_representante as $venda)
                                <tr>
                                    <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                    <td>
                                        <h6 class="font-size-15 mb-1 font-weight-normal">{{ $venda->agent_name }}</h6>
                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> São Paulo</p>
                                    </td>
                                    <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>R${{ number_format($venda->valor_venda, 2, '.', ',') }}</td>
                                </tr>
                                @endforeach                                                                                                                             
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