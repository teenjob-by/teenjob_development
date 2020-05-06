@extends('layouts.frontend')
@section('seo_meta')
    <meta name="description" content="Ограниченная во времени занятость, во время которой вы пробуете и приобретаете навыки на практике как часть какой-либо организации."/>
    <meta name="language" content="RU"/>

    <title>Правила трудоустройства для подростков - teenjob.by</title>
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
                <h3 class="info-page-title">@lang('content.jobRules.title')</h3>

                <div class="text-section">
                    @for ($i = 1; $i <= 8; $i++)
                        <div class="article">
                            <div class="article-heading">
                                <img src="{{url('/')}}/images/rules-block-{{ $i }}-icon.svg">
                                <h4>@lang('content.jobRules.text.section_'. $i .'.title')</h4>
                            </div>
                            <div class="article-description">
                                <ul>
                                    @lang('content.jobRules.text.section_'. $i .'.description')
                                </ul>
                            </div>
                        </div>
                    @endfor

                    <div class="article">
                        <div class="article-description">
                           @lang('content.jobRules.text.notification')
                        </div>
                    </div>

                    <div class="article-info">
                        <div class="article-info-description">
                            @lang('content.rulesForEmployers.text.info') <a href="{{ route('frontend.whoIsVolunteer') }}">@lang('content.volunteerRules.title')</a> <a href="{{ route('frontend.whoIsIntern') }}">@lang('content.internRules.title')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-page_menu-section">
                @include('frontend.chunks.infoSideMenu')
            </div>
        </div>
    </section>

@endsection
