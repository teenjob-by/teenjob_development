@extends('layouts.frontend')

@section('content')

    <section class="login_section">
        <div class="content-wrapper">

            <h3 class="login_title">@lang('auth.verified.title')</h3>

            <p class="login_subtitle">
                @lang('auth.verified.verified')
            </p>

            <p class="login_subtitle">
                <br><a href="{{ route('organisation.index') }}">@lang('auth.verified.login')</a><br>
            </p>
        </div>
    </section>

@endsection