@extends('layouts.site')

@section('body_class', 'page-home')

@section('content')
    <div class="container auth">

        <div class="row justify-content-center">
            <h3>@lang('auth.verified.title')</h3>

            <hr align="center" width="627" color="lightgray" />

            
                <p>
                    @lang('auth.verified.verified')
                </p>
            

            <p>
                
                <br><a href="/organisation">@lang('auth.verified.login')</a><br>
            </p>
        </div>
    </div>



@endsection