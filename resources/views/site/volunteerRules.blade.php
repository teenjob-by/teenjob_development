@extends('layouts.site')
@section('seo_meta')
    <meta name="description" content="Волонтер - это человек, выполняющий какой-либо труд добровольно, не ожидая взамен вознаграждения. Правила, которыми мы рекомендуем руководствоваться волонтерам:..."/>
    <meta name="language" content="RU"/>
    <meta name="keywords" content="волонтер">

    <title>Кто такой волонтер - teenjob.by</title>
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
                <h3 class="info-page-title">@lang('content.volunteerRules.title')</h3>
                <div class="text-section">
                    @lang('content.volunteerRules.subtitle')
                    @lang('content.volunteerRules.description')
                </div>
            </div>

            <div class="menu-section">
                @include('site.blocks.infoSideMenu')
            </div>
        </div>
    </div>

@endsection