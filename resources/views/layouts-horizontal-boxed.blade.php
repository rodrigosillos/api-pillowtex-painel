@extends('layouts.master-layouts')
@section('title')
@lang('translation.Boxed_Horizontal')
@endsection
@section('body')
<body data-keep-enlarged="true" data-layout="horizontal" class="horizontal-collpsed" data-topbar="colored" data-layout-size="boxed">
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Layouts @endslot
    @slot('title') Horizontal @endslot
@endcomponent 
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">

                    <h5>Welcome ! Marcus</h5>

                    <div class="row mt-1 align-items-center">
                        <div class="col-sm-6">
                            <h2 class="text-primary mb-1">$<span data-plugin="counterup">9.84</span>k</h2>
                            <p class="text-muted">
                                <span class="text-success mr-1"><i class="mdi mdi-arrow-up ml-1"></i>0.82%</span> since last week
                            </p>

                            <p class="mt-3 mb-2 text-muted font-size-17">You have done 85.19% target sales reached today. </p>

                            <div class="mt-3">
                                <a href="" class="btn btn-primary waves-effect waves-light">Learn More
                                    <i class="uil uil-arrow-right"></i></a>
                            </div>
                        </div> <!-- end col-->
                        <div class="col-sm-6">
                            <div class="text-center">
                                <img src="{{ URL::asset('assets/images/winners-rafiki.svg')}}" class="img-fluid" alt="" style="max-height: 213px;">
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row -->
                </div> <!-- end card-body-->
            </div><!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="font-weight-semibold">Sort By:</span> <span class="text-muted">Weekly<i class="mdi mdi-chevron-down ml-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Monthly</a>
                                <a class="dropdown-item" href="#">Yearly</a>
                                <a class="dropdown-item" href="#">Weekly</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">Revenue Stats</h4>
                    <div id="revenue-stats-chart" class="apex-charts" dir="ltr"></div>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-5">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right mt-2">
                                <div id="total-revenue-chart"></div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">34,152</span></h4>
                                <p class="text-muted mb-0">Total Revenue</p>
                            </div>
                            <p class="text-muted mt-3 mb-0"><span class="text-success mr-1"><i class="mdi mdi-arrow-up-bold ml-1"></i>2.65%</span> since last week
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="float-right mt-2">
                                <div id="orders-chart"> </div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">5,643</span></h4>
                                <p class="text-muted mb-0">Orders</p>
                            </div>
                            <p class="text-muted mt-3 mb-0"><span class="text-danger mr-1"><i class="mdi mdi-arrow-down-bold ml-1"></i>0.82%</span> since last week
                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right mt-2">
                                <div id="customers-chart"> </div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">45,254</span></h4>
                                <p class="text-muted mb-0">Customers</p>
                            </div>
                            <p class="text-muted mt-3 mb-0"><span class="text-danger mr-1"><i class="mdi mdi-arrow-down-bold ml-1"></i>6.24%</span> since last week
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="float-right mt-2">
                                <div id="growth-chart"></div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1">+ <span data-plugin="counterup">12.58</span>%</h4>
                                <p class="text-muted mb-0">Growth</p>
                            </div>
                            <p class="text-muted mt-3 mb-0"><span class="text-success mr-1"><i class="mdi mdi-arrow-up-bold ml-1"></i>10.51%</span> since last week
                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->
        </div> <!-- end col-->
    </div> <!-- end row -->

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5"
                                data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="font-weight-semibold">Sort By:</span> <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ml-1"></i></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                <a class="dropdown-item" href="#">Monthly</a>
                                <a class="dropdown-item" href="#">Yearly</a>
                                <a class="dropdown-item" href="#">Weekly</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">Sales Analytics</h4>

                    <div class="mt-1">
                        <ul class="list-inline main-chart mb-0">
                            <li class="list-inline-item chart-border-left mr-0 border-0">
                                <h3 class="text-primary">$<span data-plugin="counterup">2,371</span><span class="text-muted d-inline-block font-size-15 ml-3">Income</span></h3>
                            </li>
                            <li class="list-inline-item chart-border-left mr-0">
                                <h3><span data-plugin="counterup">258</span><span class="text-muted d-inline-block font-size-15 ml-3">Sales</span>
                                </h3>
                            </li>
                            <li class="list-inline-item chart-border-left mr-0">
                                <h3><span data-plugin="counterup">3.6</span>%<span class="text-muted d-inline-block font-size-15 ml-3">Conversation Ratio</span></h3>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-3">
                        <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-4">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <p class="text-white font-size-18">Enhance your <b>Campaign</b> for better outreach <i class="mdi mdi-arrow-right"></i></p>
                            <div class="mt-4">
                                <a href="javascript: void(0);" class="btn btn-success waves-effect waves-light">Upgrade Account!</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mt-4 mt-sm-0">
                                <img src="{{ URL::asset('assets/images/setup-analytics-amico.svg')}}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->

            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1"
                                data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="font-weight-semibold">Sort By:</span> <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ml-1"></i></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                                <a class="dropdown-item" href="#">Monthly</a>
                                <a class="dropdown-item" href="#">Yearly</a>
                                <a class="dropdown-item" href="#">Weekly</a>
                            </div>
                        </div>
                    </div>

                    <h4 class="card-title mb-4">Top Selling Products</h4>


                    <div class="row align-items-center no-gutters mt-3">
                        <div class="col-sm-3">
                            <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary mr-2"></i> Desktops </p>
                        </div>

                        <div class="col-sm-9">
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar progress-bar bg-primary" role="progressbar"
                                    style="width: 52%" aria-valuenow="52" aria-valuemin="0"
                                    aria-valuemax="52">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row align-items-center no-gutters mt-3">
                        <div class="col-sm-3">
                            <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info mr-2"></i> iPhones </p>
                        </div>
                        <div class="col-sm-9">
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar progress-bar bg-info" role="progressbar"
                                    style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                                    aria-valuemax="45">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row align-items-center no-gutters mt-3">
                        <div class="col-sm-3">
                            <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-success mr-2"></i> Android </p>
                        </div>
                        <div class="col-sm-9">
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar progress-bar bg-success" role="progressbar"
                                    style="width: 48%" aria-valuenow="48" aria-valuemin="0"
                                    aria-valuemax="48">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row align-items-center no-gutters mt-3">
                        <div class="col-sm-3">
                            <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-warning mr-2"></i> Tablets </p>
                        </div>
                        <div class="col-sm-9">
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar progress-bar bg-warning" role="progressbar"
                                    style="width: 78%" aria-valuenow="78" aria-valuemin="0"
                                    aria-valuemax="78">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row align-items-center no-gutters mt-3">
                        <div class="col-sm-3">
                            <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple mr-2"></i> Cables </p>
                        </div>
                        <div class="col-sm-9">
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
    </div> <!-- end row-->

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <div class="dropdown">
                            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">All Members<i class="mdi mdi-chevron-down ml-1"></i></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <a class="dropdown-item" href="#">Locations</a>
                                <a class="dropdown-item" href="#">Revenue</a>
                                <a class="dropdown-item" href="#">Join Date</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">Top Users</h4>

                    <div data-simplebar style="max-height: 336px;">
                        <div class="table-responsive">
                            <table class="table table-borderless table-centered table-nowrap">
                                <tbody>
                                    <tr>
                                        <td style="width: 20px;"><img src="{{ URL::asset('assets/images/users/avatar-4.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                        <td>
                                            <h6 class="font-size-15 mb-1 font-weight-normal">Glenn Holden</h6>
                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Nevada</p>
                                        </td>
                                        <td><span class="badge badge-soft-danger font-size-12">Cancel</span></td>
                                        <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$250.00</td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ URL::asset('assets/images/users/avatar-5.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                        <td>
                                            <h6 class="font-size-15 mb-1 font-weight-normal">Lolita Hamill</h6>
                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Texas</p>
                                        </td>
                                        <td><span class="badge badge-soft-success font-size-12">Success</span></td>
                                        <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-danger" data-feather="trending-down"></i>$110.00</td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ URL::asset('assets/images/users/avatar-6.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                        <td>
                                            <h6 class="font-size-15 mb-1 font-weight-normal">Robert Mercer</h6>
                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                                        </td>
                                        <td><span class="badge badge-soft-info font-size-12">Active</span></td>
                                        <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$420.00</td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ URL::asset('assets/images/users/avatar-7.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                        <td>
                                            <h6 class="font-size-15 mb-1 font-weight-normal">Marie Kim</h6>
                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Montana</p>
                                        </td>
                                        <td><span class="badge badge-soft-warning font-size-12">Pending</span></td>
                                        <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-danger" data-feather="trending-down"></i>$120.00</td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ URL::asset('assets/images/users/avatar-8.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                        <td>
                                            <h6 class="font-size-15 mb-1 font-weight-normal">Sonya Henshaw</h6>
                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Colorado</p>
                                        </td>
                                        <td><span class="badge badge-soft-info font-size-12">Active</span></td>
                                        <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$112.00</td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ URL::asset('assets/images/users/avatar-2.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                        <td>
                                            <h6 class="font-size-15 mb-1 font-weight-normal">Marie Kim</h6>
                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Australia</p>
                                        </td>
                                        <td><span class="badge badge-soft-success font-size-12">Success</span></td>
                                        <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-danger" data-feather="trending-down"></i>$120.00</td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ URL::asset('assets/images/users/avatar-1.jpg')}}" class="avatar-xs rounded-circle " alt="..."></td>
                                        <td>
                                            <h6 class="font-size-15 mb-1 font-weight-normal">Sonya Henshaw</h6>
                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> India</p>
                                        </td>
                                        <td><span class="badge badge-soft-danger font-size-12">Cancel</span></td>
                                        <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$112.00</td>
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
                    <div class="float-right">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" id="dropdownMenuButton3"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Recent<i class="mdi mdi-chevron-down ml-1"></i></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton3">
                                <a class="dropdown-item" href="#">Recent</a>
                                <a class="dropdown-item" href="#">By Users</a>
                            </div>
                        </div>
                    </div>

                    <h4 class="card-title mb-4">Recent Activity</h4>

                    <ol class="activity-feed mb-0 pl-2" data-simplebar style="max-height: 336px;">
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <p class="text-muted mb-1 font-size-13">Today<small class="d-inline-block ml-1">12:20 pm</small></p>
                                <p class="mt-0 mb-0">Andrei Coman magna sed porta finibus, risus
                                    posted a new article: <span class="text-primary">Forget UX
                                        Rowland</span></p>
                            </div>
                        </li>
                        <li class="feed-item">
                            <p class="text-muted mb-1 font-size-13">22 Jul, 2020 <small class="d-inline-block ml-1">12:36 pm</small></p>
                            <p class="mt-0 mb-0">Andrei Coman posted a new article: <span
                                    class="text-primary">Designer Alex</span></p>
                        </li>
                        <li class="feed-item">
                            <p class="text-muted mb-1 font-size-13">18 Jul, 2020 <small class="d-inline-block ml-1">07:56 am</small></p>
                            <p class="mt-0 mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                                Commented <span class="text-primary"> Developer Moreno</span></p>
                        </li>
                        <li class="feed-item">
                            <p class="text-muted mb-1 font-size-13">10 Jul, 2020 <small class="d-inline-block ml-1">08:42 pm</small></p>
                            <p class="mt-0 mb-0">Zack Wetass, Chris combined Commented <span
                                    class="text-primary">UX Murphy</span></p>
                        </li>

                        <li class="feed-item">
                            <p class="text-muted mb-1 font-size-13">23 Jun, 2020 <small class="d-inline-block ml-1">12:22 am</small></p>
                            <p class="mt-0 mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                                Commented <span class="text-primary"> Developer Moreno</span></p>
                        </li>
                        <li class="feed-item pb-1">
                            <p class="text-muted mb-1 font-size-13">20 Jun, 2020 <small class="d-inline-block ml-1">09:48 pm</small></p>
                            <p class="mt-0 mb-0">Zack Wetass, Chris combined Commented <span
                                    class="text-primary">UX Murphy</span></p>
                        </li>

                    </ol>

                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">

                    <div class="float-right">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" id="dropdownMenuButton4"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Monthly<i class="mdi mdi-chevron-down ml-1"></i></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton4">
                                <a class="dropdown-item" href="#">Yearly</a>
                                <a class="dropdown-item" href="#">Monthly</a>
                                <a class="dropdown-item" href="#">Weekly</a>
                            </div>
                        </div>
                    </div>

                    <h4 class="card-title">Social Source</h4>

                    <div class="text-center">
                        <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-soft-primary font-size-24">
                                    <i class="mdi mdi-facebook text-primary"></i>
                                </span>
                        </div>
                        <p class="font-16 text-muted mb-2"></p>
                        <h5><a href="#" class="text-dark">Facebook - <span class="text-muted font-16">125 sales</span> </a></h5>
                        <p class="text-muted">Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus tincidunt.</p>
                        <a href="#" class="text-reset font-16">Learn more <i class="mdi mdi-chevron-right"></i></a>
                    </div>
                    <div class="row mt-4">
                        <div class="col-4">
                            <div class="social-source text-center mt-3">
                                <div class="avatar-xs mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-primary font-size-16">
                                            <i class="mdi mdi-facebook text-white"></i>
                                        </span>
                                </div>
                                <h5 class="font-size-15">Facebook</h5>
                                <p class="text-muted mb-0">125 sales</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="social-source text-center mt-3">
                                <div class="avatar-xs mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-info font-size-16">
                                            <i class="mdi mdi-twitter text-white"></i>
                                        </span>
                                </div>
                                <h5 class="font-size-15">Twitter</h5>
                                <p class="text-muted mb-0">112 sales</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="social-source text-center mt-3">
                                <div class="avatar-xs mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-pink font-size-16">
                                            <i class="mdi mdi-instagram text-white"></i>
                                        </span>
                                </div>
                                <h5 class="font-size-15">Instagram</h5>
                                <p class="text-muted mb-0">104 sales</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="#" class="text-primary font-size-14 font-weight-medium">View All Sources <i class="mdi mdi-chevron-right"></i></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
   
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js')}}"></script>
@endsection
