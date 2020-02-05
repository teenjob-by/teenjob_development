@extends('layouts.site')

@section('body_class', 'page-home')

@section('content')
    <div class="container auth">

        <div class="row justify-content-center">
            <h3>@lang('auth.verify.title')</h3>

            <hr align="center" width="627" color="lightgray" />

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    @lang('auth.verify.link')
                </div>
            @endif

            <p>
                <br>@lang('auth.verify.check')<br>
                <br>@lang('auth.verify.notAppear'), <a href="{{ route('verification.resend') }}">@lang('auth.verify.click')</a>.<br>
            </p>
        </div>
    </div>



@endsection