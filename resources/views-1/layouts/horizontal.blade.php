<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
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

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="uil-search"></span>
                </div>
            </form>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-search"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-search-dropdown">
                    
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block language-switch">
                <button type="button" class="btn header-item waves-effect"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="" src="{{ URL::asset('assets/images/flags/us.jpg')}}" alt="Header Language" height="16">
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('assets/images/flags/spain.jpg')}}" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Spanish</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('assets/images/flags/germany.jpg')}}" alt="user-image" class="mr-1" height="12"> <span class="align-middle">German</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('assets/images/flags/italy.jpg')}}" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Italian</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('assets/images/flags/russia.jpg')}}" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Russian</span>
                    </a>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-apps"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="px-lg-2">
                        <div class="row no-gutters">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ URL::asset('assets/images/brands/github.png')}}" alt="Github">
                                    <span>GitHub</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ URL::asset('assets/images/brands/bitbucket.png')}}" alt="bitbucket">
                                    <span>Bitbucket</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ URL::asset('assets/images/brands/dribbble.png')}}" alt="dribbble">
                                    <span>Dribbble</span>
                                </a>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ URL::asset('assets/images/brands/dropbox.png')}}" alt="dropbox">
                                    <span>Dropbox</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ URL::asset('assets/images/brands/mail_chimp.png')}}" alt="mail_chimp">
                                    <span>Mail Chimp</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="{{ URL::asset('assets/images/brands/slack.png')}}" alt="slack">
                                    <span>Slack</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="uil-minus-path"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-bell"></i>
                    <span class="badge badge-danger badge-pill">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-16"> Notifications </h5>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small"> Mark all as read</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="uil-cart"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">Your order is placed</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">If several languages coalesce the grammar</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <img src="{{ URL::asset('assets/images/users/avatar-3.jpg')}}"
                                    class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">James Lemire</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">It will seem like simplified English.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="uil-truck"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">Your item is shipped</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">If several languages coalesce the grammar</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <img src="{{ URL::asset('assets/images/users/avatar-4.jpg')}}"
                                    class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">Salena Layfield</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                            <i class="uil-arrow-circle-right mr-1"></i> View More..
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ URL::asset('assets/images/users/avatar-4.jpg')}}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ml-1 font-weight-medium font-size-15">Marcus</span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="uil uil-user-circle font-size-18 align-middle text-muted mr-1"></i> <span class="align-middle">View Profile</span></a>
                    <a class="dropdown-item" href="#"><i class="uil uil-wallet font-size-18 align-middle mr-1 text-muted"></i> <span class="align-middle">My Wallet</span></a>
                    <a class="dropdown-item d-block" href="#"><i class="uil uil-cog font-size-18 align-middle mr-1 text-muted"></i> <span class="align-middle">Settings</span> <span class="badge badge-soft-success badge-pill mt-1 ml-2">03</span></a>
                    <a class="dropdown-item" href="#"><i class="uil uil-lock-alt font-size-18 align-middle mr-1 text-muted"></i> <span class="align-middle">Lock screen</span></a>
                    <a class="dropdown-item" href="#"><i class="uil uil-sign-out-alt font-size-18 align-middle mr-1 text-muted"></i> <span class="align-middle">Sign out</span></a>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="uil-cog"></i>
                </button>
            </div>
            
        </div>
    </div>
    <div class="container-fluid">
        <div class="topnav">

            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
    
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link" href="{{url('index')}}">
                                <i class="uil-home-alt mr-2"></i> Dashboard
                            </a>
                        </li>
    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil-flask mr-2"></i>UI Elements <div class="arrow-down"></div>
                            </a>

                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl"
                                aria-labelledby="topnav-uielement">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div>
                                            <a href="ui-alerts" class="dropdown-item">Alerts</a>
                                            <a href="ui-buttons" class="dropdown-item">Buttons</a>
                                            <a href="ui-cards" class="dropdown-item">Cards</a>
                                            <a href="ui-carousel" class="dropdown-item">Carousel</a>
                                            <a href="ui-dropdowns" class="dropdown-item">Dropdowns</a>
                                            <a href="ui-grid" class="dropdown-item">Grid</a>
                                            <a href="ui-images" class="dropdown-item">Images</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div>
                                            <a href="ui-lightbox" class="dropdown-item">Lightbox</a>
                                            <a href="ui-modals" class="dropdown-item">Modals</a>
                                            <a href="ui-rangeslider" class="dropdown-item">Range Slider</a>
                                            <a href="ui-session-timeout" class="dropdown-item">Session Timeout</a>
                                            <a href="ui-progressbars" class="dropdown-item">Progress Bars</a>
                                            <a href="ui-sweet-alert" class="dropdown-item">Sweet-Alert</a>
                                            <a href="ui-tabs-accordions" class="dropdown-item">Tabs & Accordions</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div>
                                            <a href="ui-typography" class="dropdown-item">Typography</a>
                                            <a href="ui-video" class="dropdown-item">Video</a>
                                            <a href="ui-general" class="dropdown-item">General</a>
                                            <a href="ui-colors" class="dropdown-item">Colors</a>
                                            <a href="ui-rating" class="dropdown-item">Rating</a>
                                            <a href="ui-notifications" class="dropdown-item">Notifications</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil-apps mr-2"></i>Apps <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-pages">

                                <a href="calendar" class="dropdown-item">Calendar</a>
                                <a href="chat" class="dropdown-item">Chat</a>
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Email <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-email">
                                        <a href="email-inbox" class="dropdown-item">Inbox</a>
                                        <a href="email-read" class="dropdown-item">Read Email</a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ecommerce"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ecommerce <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-ecommerce">
                                        <a href="ecommerce-products" class="dropdown-item">Products</a>
                                        <a href="ecommerce-product-detail" class="dropdown-item">Product Detail</a>
                                        <a href="ecommerce-orders" class="dropdown-item">Orders</a>
                                        <a href="ecommerce-customers" class="dropdown-item">Customers</a>
                                        <a href="ecommerce-cart" class="dropdown-item">Cart</a>
                                        <a href="ecommerce-checkout" class="dropdown-item">Checkout</a>
                                        <a href="ecommerce-shops" class="dropdown-item">Shops</a>
                                        <a href="ecommerce-add-product" class="dropdown-item">Add Product</a>
                                    </div>
                                </div>

                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-invoice"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Invoices <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-invoice">
                                        <a href="invoices-list" class="dropdown-item">Invoice List</a>
                                        <a href="invoices-detail" class="dropdown-item">Invoice Detail</a>
                                    </div>
                                </div>
                                
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-contact"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Contacts <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-contact">
                                        <a href="contacts-grid" class="dropdown-item">User Grid</a>
                                        <a href="contacts-list" class="dropdown-item">User List</a>
                                        <a href="contacts-profile" class="dropdown-item">Profile</a>
                                    </div>
                                </div>
                            </div>
                        </li>
    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil-layers mr-2"></i>Components <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-components">
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Forms <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-form">
                                        <a href="form-elements" class="dropdown-item">Basic Elements</a>
                                        <a href="form-validation" class="dropdown-item">Validation</a>
                                        <a href="form-advanced" class="dropdown-item">Advanced Plugins</a>
                                        <a href="form-editors" class="dropdown-item">Editors</a>
                                        <a href="form-uploads" class="dropdown-item">File Upload</a>
                                        <a href="form-xeditable" class="dropdown-item">Xeditable</a>
                                        <a href="form-repeater" class="dropdown-item">Repeater</a>
                                        <a href="form-wizard" class="dropdown-item">Wizard</a>
                                        <a href="form-mask" class="dropdown-item">Mask</a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-table"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Tables <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-table">
                                        <a href="tables-basic" class="dropdown-item">Bootstrap Basic</a>
                                        <a href="tables-datatable" class="dropdown-item">Datatables</a>
                                        <a href="tables-responsive" class="dropdown-item">Responsive</a>
                                        <a href="tables-editable" class="dropdown-item">Editable</a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Charts <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                        <a href="charts-apex" class="dropdown-item">Apex</a>
                                        <a href="charts-chartjs" class="dropdown-item">Chartjs</a>
                                        <a href="charts-flot" class="dropdown-item">Flot</a>
                                        <a href="charts-knob" class="dropdown-item">Jquery Knob</a>
                                        <a href="charts-sparkline" class="dropdown-item">Sparkline</a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Icons <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                        <a href="icons-unicons" class="dropdown-item">Unicons</a>
                                        <a href="icons-boxicons" class="dropdown-item">Boxicons</a>
                                        <a href="icons-materialdesign" class="dropdown-item">Material Design</a>
                                        <a href="icons-dripicons" class="dropdown-item">Dripicons</a>
                                        <a href="icons-fontawesome" class="dropdown-item">Font awesome</a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-map"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Maps <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-map">
                                        <a href="maps-google" class="dropdown-item">Google</a>
                                        <a href="maps-vector" class="dropdown-item">Vector</a>
                                        <a href="maps-leaflet" class="dropdown-item">Leaflet</a>
                                    </div>
                                </div>
                            </div>
                        </li>
    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-more" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil-copy mr-2"></i>Extra pages <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-more">
                                
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Authentication <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                        <a href="auth-login" class="dropdown-item">Login</a>
                                        <a href="auth-register" class="dropdown-item">Register</a>
                                        <a href="auth-recoverpw" class="dropdown-item">Recover Password</a>
                                        <a href="auth-lock-screen" class="dropdown-item">Lock Screen</a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-utility"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Utility <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-utility">
                                        <a href="pages-starter" class="dropdown-item">Starter Page</a>
                                        <a href="pages-maintenance" class="dropdown-item">Maintenance</a>
                                        <a href="pages-comingsoon" class="dropdown-item">Coming Soon</a>
                                        <a href="pages-timeline" class="dropdown-item">Timeline</a>
                                        <a href="pages-faqs" class="dropdown-item">FAQs</a>
                                        <a href="pages-pricing" class="dropdown-item">Pricing</a>
                                        <a href="pages-404" class="dropdown-item">Error 404</a>
                                        <a href="pages-500" class="dropdown-item">Error 500</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil-window-section mr-2"></i>Layouts <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="layouts-horizontal" class="dropdown-item">Horizontal</a>
                                <a href="layouts-dark-sidebar" class="dropdown-item">Dark Sidebar</a>
                                <a href="layouts-compact-sidebar" class="dropdown-item">Compact Sidebar</a>
                                <a href="layouts-icon-sidebar" class="dropdown-item">Icon Sidebar</a>
                                <a href="layouts-boxed" class="dropdown-item">Boxed Width</a>
                                <a href="layouts-preloader" class="dropdown-item">Preloader</a>
                                <a href="layouts-colored-sidebar" class="dropdown-item">Colored Sidebar</a>
                            </div>
                        </li>
    
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
    
