@extends('layouts.site')

@section('body_class', 'page-home')

@section('content')
    <div class="container auth">

        <div class="row justify-content-center">
            <h3>{{ __('Подтверждение вашей почты') }}</h3>

            <hr align="center" width="627" color="lightgray" />

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('Ссылка на активацию аккаунта была отправлена на вашу почту') }}
                </div>
            @endif

            <p>
                <br>{{ __('Перед продолжением, проверьте свой e-mail адрес') }}<br>
                <br>{{ __('Если вы не получили письмо') }}, <a href="{{ route('verification.resend') }}">{{ __('Нажмите, чтобы выслать еще раз') }}</a>.<br>
            </p>
        </div>
    </div>



@endsection