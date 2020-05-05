@extends('layouts.frontend')
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

    <section class="info-page_section">
        <div class="content-wrapper">
            <div class="info-page_subsection">
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

            <div class="info-page_menu-section">
                @include('frontend.chunks.infoSideMenu')
            </div>
        </div>
    </section>

@endsection