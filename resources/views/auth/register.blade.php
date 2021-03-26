@extends('layouts.master-without-nav')
@section('title')
Register
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
                            <h5 class="text-primary">Criar Conta</h5>
                            <p class="text-muted">Crie uma conta para acessar o painel</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="name">{{ __('Nome') }}</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Digite o nome">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('Endereço de E-Mail') }}</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Digite o endereço de e-mail">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ __('Senha') }}</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Digite a senha">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm">{{ __('Confirme a Senha') }}</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Digite a senha">
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="auth-terms-condition-check">
                                    <label class="custom-control-label" for="auth-terms-condition-check">Eu aceito <a href="javascript: void(0);" class="text-dark">os termos e condições</a></label>
                                </div>
                                
                                <div class="mt-3 text-right">
                                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">{{ __('Criar') }}</button>
                                </div>

                                <div class="mt-4 text-center">
                                    <p class="text-muted mb-0">Já tem uma conta ? <a href="{{url('login')}}" class="font-weight-medium text-primary"> Entrar</a></p>
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

