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

@section('content')

    <div class="container-fluid">
        <div class="container info-page">
            <div class="content-section">
                <h3 class="info-page-title">@lang('content.internRules.title')</h3>
                <div class="text-section">
                    @lang('content.internRules.subtitle')
                    @lang('content.internRules.description')
                </div>

                <div class="article-info">
                    <div class="article-info-description">
                        @lang('content.rulesForEmployers.text.info') <a href="{{ route('site.whoisvolunteer') }}">@lang('content.volunteerRules.title')</a> <a href="{{ route('site.whatisvacancy') }}">@lang('content.vacancyRules.title')</a>
                    </div>
                </div>
            </div>

            <div class="menu-section">
                @include('site.blocks.infoSideMenu')
            </div>
        </div>
    </div>

@endsection