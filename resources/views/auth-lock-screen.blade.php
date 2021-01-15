@extends('layouts.master-without-nav')
@section('title')
@lang('translation.Lock_Screen')
@endsection
@section('content')
<div class="home-btn d-none d-sm-block">
    <a href="{{url('index')}}" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
</div>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="{{url('index')}}" class="mb-5 d-block auth-logo">
                        <img src="{{ URL::asset('assets/images/logo-dark.png')}}" alt="" height="22" class="logo logo-dark">
                        <img src="{{ URL::asset('assets/images/logo-light.png')}}" alt="" height="22" class="logo logo-light">
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card">
                
                <div class="card-body p-4"> 

                    <div class="text-center mt-2">
                        <h5 class="text-primary">Lock screen</h5>
                        <p class="text-muted">Enter your password to unlock the screen!</p>
                    </div>
                    <div class="p-2 mt-4">
                        <div class="user-thumb text-center mb-4">
                            <img src="{{ URL::asset('assets/images/users/avatar-4.jpg')}}" class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                            <h5 class="font-size-15 mt-3">Marcus</h5>
                        </div>
                        <form action="{{url('index')}}">

                            <div class="form-group">
                                <label for="userpassword">Password</label>
                                <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                            </div>
                            
                            <div class="mt-3 text-right">
                                <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Unlock</button>
                            </div>


                            <div class="mt-4 text-center">
                                <p class="mb-0">Not you ? return <a href="{{url('auth-login')}}" class="font-weight-medium text-primary"> Sign In </a></p>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="mt-5 text-center">
                <p>© 2020 Minible. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
            </div>
        </div>
    </div>
</div>
<!-- end container -->
</div>
@endsection
