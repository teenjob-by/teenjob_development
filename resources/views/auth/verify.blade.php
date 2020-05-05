@extends('layouts.frontend')

@section('content')

    <section class="login_section">
        <div class="content-wrapper">

            <h3 class="login_title">@lang('auth.verify.title')</h3>

            @if (session('resent'))
                <p class="login_subtitle">
                    <br>
                    @lang('auth.verify.link')
                </p>
            @endif

            <p class="login_subtitle">
                <br>@lang('auth.verify.check')<br>
                <br>@lang('auth.verify.notAppear'), <a href="{{ route('verification.resend') }}">@lang('auth.verify.click')</a>.<br>
            </p>
        </div>
    </section>

@endsection