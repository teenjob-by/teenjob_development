@extends('layouts.site')
@section('seo_meta')
    <meta name="description" content="Администрация ресурса не несет ответственность за какие-либо последствия, вызванные использованием предоставленной информации, ее неверным толкованием или пониманием."/>
    <meta name="language" content="RU"/>

    <title>Отказ от ответственности - teenjob.by</title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/main_fb.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/main_vk.png">
@endsection
@section('body_class', 'page-home')

@section('content')
    <div class="container-fluid background">
        <div class="container conditions">
            <div class="row justify-content-center">
                <h3>@lang('conditions_page.title')</h3>
                <hr/>
                <p>@lang('conditions_page.text')</p>
            </div>
        </div>
    </div>



@endsection