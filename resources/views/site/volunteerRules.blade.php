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
@section('body_class', 'page-home')

@section('content')
    <div class="container-fluid background">
        <div class="container conditions">
            <div class="row justify-content-center">
                <h3>@lang('content.volunteerRules.title')</h3>
                <hr/>
                @lang('content.volunteerRules.subtitle')
                @lang('content.volunteerRules.description')
            </div>
        </div>
    </div>



@endsection