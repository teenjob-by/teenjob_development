@extends('layouts.site')
@section('seo_meta')
    <meta name="description" content="Войдите, чтобы опубликовать объявление, или зарегистрируйтесь."/>
    <meta name="language" content="RU"/>

    <title>teenjob.by - Вход в личный кабинет </title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/entrance.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/entrance.png">
@endsection

@section('content')
<div class="container-fluid login">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0">
                <h3>@lang('auth.login.title')</h3>
                <p>@lang('auth.login.subtitle')</p>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group flex-column row">
                            <div >
                                <label for="email" class="col-form-label text-md-left">@lang('auth.login.email')</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group flex-column row mb-0">
                            <div class="">
                                <label for="password" class="col-form-label text-md-left">@lang('auth.login.password')</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group flex-column row mb-4">
                            <!--<div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Запомнить меня
                                    </label>
                                </div>
                            </div>-->
                            <div>
                                @if (Route::has('password.request'))
                                    <a class="btn remind-password btn-link text-md-left" href="{{ route('password.request') }}">
                                        @lang('auth.login.remember')
                                    </a>
                                @endif
                            </div>

                        </div>

                        <div class="form-group flex-column row">
                            <div class="text-center ">
                                <button type="submit" class="btn btn-success btn-orange">
                                    @lang('auth.login.signin')
                                </button>
                            </div>
                        </div>

                        <div class="form-group flex-column row">
                            <div class="col-md-2 text-center">
                                <hr>
                                <p class="mb-0">@lang('auth.login.or')</p>
                            </div>
                        </div>
                    </form>

                    <div class="form-group flex-column row">
                        <div class="text-center">
                            <a href="{{ route('register') }}" class="btn btn-success btn-orange" id="register">
                                @lang('auth.login.register')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
