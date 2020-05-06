@extends('layouts.site')
@section('seo_meta')
    <meta name="description" content="Ограниченная во времени занятость, во время которой вы пробуете и приобретаете навыки на практике как часть какой-либо организации."/>
    <meta name="language" content="RU"/>

    <title>Информация для организаций - teenjob.by</title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/main_fb.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/main_vk.png">
@endsection
@section('body_class', 'page-home')

@section('content')

    <div class="container-fluid">
        <div class="container info-page">
            <div class="content-section">
                <h3 class="info-page-title">@lang('content.rulesForEmployers.title')</h3>

                <div class="text-section">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="article">
                            <div class="article-heading">
                                <img src="{{url('/')}}/images/organisations/rules-block-{{ $i }}-icon.svg">
                                <h4>@lang('content.rulesForEmployers.text.section_'. $i .'.title')</h4>
                            </div>
                            <div class="article-description">
                                <ul>
                                    @lang('content.rulesForEmployers.text.section_'. $i .'.description')
                                </ul>
                            </div>
                        </div>
                    @endfor

                    <div class="article">
                        <div class="article-description">
                           @lang('content.rulesForEmployers.text.notification')
                        </div>
                    </div>

                    <div class="article-info">
                        <div class="article-info-description">
                            @lang('content.rulesForEmployers.text.info') <a href="{{ route('frontend.whoIsVolunteer') }}">@lang('content.volunteerRules.title')</a> <a href="{{ route('frontend.whoIsIntern') }}">@lang('content.internRules.title')</a>
                        </div>
                    </div>

                    <div class="organisations-block">
                        <h4 class="organisations-block-title">@lang('content.rulesForEmployers.text.assistantNeeded')</h4>
                        <div class="organisations-block-description">
                            <a href="https://iqido.biz/">
                                <img src="/images/partners/organisation-1.png">
                            </a>
                        </div>
                        <h5 class="organisations-block-subtitle">@lang('content.rulesForEmployers.text.needHelp')</h5>
                        <a class="btn btn-success btn-orange mx-auto" href="https://docs.google.com/forms/d/e/1FAIpQLSdAYxXLNuyauPn7Bi-rhhnF9T7hnAnfCgzp7sgPW0wKRQtGmg/viewform">
                            <span>
                                @lang('content.rulesForEmployers.text.button')
                            </span>
                        </a>
                    </div>

                </div>
            </div>

            <div class="menu-section">
                @include('frontend.blocks.infoSideMenu')
            </div>
        </div>
    </div>


@endsection
