<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{url('index')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-dark.png')}}" alt="" height="20">
            </span>
        </a>

        <a href="{{url('index')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-light.png')}}" alt="" height="20">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('translation.Menu')</li>

                <li>
                    <a href="{{url('index')}}">
                        <i class="uil-home-alt"></i><span class="badge badge-pill badge-primary float-right">01</span>
                        <span>@lang('translation.Dashboard')</span>
                    </a>
                </li>

                <li class="menu-title">@lang('translation.Modules')</li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="uil-user-square"></i>
                        <span>@lang('translation.Customers')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="uil-invoice"></i>
                        <span>@lang('translation.Orders')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-money-withdrawal"></i>
                        <span>@lang('translation.Commissions')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="/comissoes">@lang('translation.Calculate_Commission')</a></li>
                        <li><a href="/representantes">@lang('translation.Agents')</a>
                        <li><a href="/configurar-comissoes">@lang('translation.Settings')</a>
                            <!--
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">@lang('translation.Tables')</a></li>
                                <li><a href="javascript: void(0);">@lang('translation.Discounts')</a></li>
                                <li><a href="javascript: void(0);">@lang('translation.Commission_Percentage')</a></li>
                                <li><a href="javascript: void(0);">@lang('translation.States')</a></li>
                            </ul>
                            -->
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class=" waves-effect">
                        <i class="uil-bag-alt"></i>
                        <span>@lang('translation.Sales')</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->