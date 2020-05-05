@extends('layouts.frontend')
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

    <section class="info-page_section">
        <div class="content-wrapper">
            <div class="info-page_subsection">
                <h3 class="info-page-title">@lang('content.volunteerRules.title')</h3>
                <div class="text-section">
                    @lang('content.volunteerRules.subtitle')
                    @lang('content.volunteerRules.description')
                </div>

                <div class="article-info">
                    <div class="article-info-description">
                        @lang('content.rulesForEmployers.text.info') <a href="{{ route('site.whatisvacancy') }}">@lang('content.vacancyRules.title')</a> <a href="{{ route('site.whoisintern') }}">@lang('content.internRules.title')</a>
                    </div>
                </div>
            </div>
            <div class="info-page_menu-section">
                @include('frontend.chunks.infoSideMenu')
            </div>
        </div>
    </section>

@endsection