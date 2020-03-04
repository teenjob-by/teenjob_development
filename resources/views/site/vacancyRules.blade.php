@extends('layouts.site')
@section('seo_meta')
    <meta name="description" content="Стажировка - это отличная возможность получить навыки в определенной сфере деятельности, попробовать и развить свои способности."/>
    <meta name="language" content="RU"/>

    <title>Что такое стажировка - teenjob.by</title>
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
                <h3>@lang('content.vacancyRules.title')</h3>
                <hr/>
               @lang('content.vacancyRules.subtitle')
               @lang('content.vacancyRules.description')
            </div>
        </div>
    </div>
@endsection