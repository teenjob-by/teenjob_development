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

@section('content')

    <div class="container-fluid">
        <div class="container info-page">
            <div class="content-section">
                <h3 class="info-page-title">@lang('conditions_page.title')</h3>
                <div class="text-section">
                    @lang('conditions_page.text')
                </div>
            </div>

            <div class="menu-section">
                @include('site.blocks.infoSideMenu')
            </div>
        </div>
    </div>

@endsection