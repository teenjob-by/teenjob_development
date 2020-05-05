@extends('layouts.frontend')
@section('seo_meta')
    <meta name="description" content="Войдите, чтобы опубликовать объявление, или зарегистрируйтесь."/>


    <title>teenjob.by - Вход в личный кабинет </title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/entrance.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/entrance.png">
@endsection

@section('content')


<section class="login_section">
    <div class="content-wrapper">

        <h3 class="login_title">@lang('auth.login.title')</h3>
        <p class="login_subtitle">@lang('auth.login.subtitle')</p>

        <form class="login_form" method="POST" action="{{ route('auth.login') }}">
            @csrf


            <div class="login_form-group">
                <label for="email" class="login_form-group-label">@lang('auth.login.email')</label>
                <input id="email" class="login_form-group-input @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus minlength="3">

                @error('email')
                    <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="login_form-group">
                <label for="password" class="login_form-group-label">@lang('auth.login.password')</label>
                <input id="password" type="password" class="login_form-group-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" minlength="8">
                <i class="show-password" onclick="showPassword('password')"></i>

                @error('password')
                    <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="login_remember-section">

                {{--<label class="remember_form">Запомнить меня
                    <input type="checkbox" class="remember_form-input" checked="checked"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                </label>--}}

                @if (!Route::has('password.request'))
                    <a class="remind-link" href="{{ route('auth.password.request') }}">
                        @lang('auth.login.remember')
                    </a>
                @endif

            </div>


            <button type="submit" class="button-primary">
                <span>@lang('auth.login.signin')</span>
            </button>

            <div class="login_delimeter">
                <hr>
                <p class="login_delimeter-text">@lang('auth.login.or')</p>
            </div>

            <a href="{{ route('auth.register') }}" class="button-primary" id="register">
                <span>@lang('auth.login.register')</span>
            </a>
        </form>

    </div>
</section>
@endsection
