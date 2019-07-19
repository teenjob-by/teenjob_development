@extends('layouts.site')

@section('body_class', 'page-home')

@section('content')
    <div class="container conditions">
        <div class="row">
            <a class="mr-auto" href="#">@lang('conditions_page.back')</a>
        </div>
        <div class="row justify-content-center">
            <h3>@lang('conditions_page.title')</h3>
            <hr align="center" width="627" color="lightgray" />
            <p>@lang('conditions_page.text')</p>
        </div>
    </div>



@endsection