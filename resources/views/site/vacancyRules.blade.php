@extends('layouts.site')
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
@section('body_class', 'page-home')

@section('content')
    <div class="container-fluid background">
        <div class="container conditions">
            <div class="row justify-content-center">
                <h3>@lang('content.vacancyRules.title')</h3>
                <hr/>

                <div class="article">
                    <div>
                        <img src="{{url('/')}}/images/rules-block-1-icon.png">
                    </div>
                    <div class="article-description">
                        <h2>@lang('content.vacancyRules.text.section_1.title')</h2>
                        <ul>
                            @lang('content.vacancyRules.text.section_1.description')
                        </ul>
                    </div>
                </div>

                <div class="article">
                    <div>
                        <img src="{{url('/')}}/images/rules-block-2-icon.png">
                    </div>
                    <div class="article-description">
                        <h2>@lang('content.vacancyRules.text.section_2.title')</h2>
                        <ul>
                            @lang('content.vacancyRules.text.section_2.description')
                        </ul>
                    </div>
                </div>
                <div class="article">
                    <div>
                        <img src="{{url('/')}}/images/rules-block-3-icon.png">
                    </div>
                    <div class="article-description">
                        <h2>@lang('content.vacancyRules.text.section_3.title')</h2>
                        <ul>
                            @lang('content.vacancyRules.text.section_3.description')
                        </ul>
                    </div>
                </div>

                <div class="article">
                    <div>
                        <img src="{{url('/')}}/images/rules-block-4-icon.png">
                    </div>
                    <div class="article-description">
                        <h2>@lang('content.vacancyRules.text.section_4.title')</h2>
                        <ul>
                            @lang('content.vacancyRules.text.section_4.description')
                        </ul>
                    </div>
                </div>

                <div class="article">
                    <div>
                        <img src="{{url('/')}}/images/rules-block-5-icon.png">
                    </div>
                    <div class="article-description">
                        <h2>@lang('content.vacancyRules.text.section_5.title')</h2>
                        <ul>
                            @lang('content.vacancyRules.text.section_5.description')
                        </ul>
                    </div>
                </div>

                <div class="article">
                    <div>
                        <img src="{{url('/')}}/images/rules-block-6-icon.png">
                    </div>
                    <div class="article-description">
                        <h2>@lang('content.vacancyRules.text.section_6.title')</h2>
                        <ul>
                            @lang('content.vacancyRules.text.section_6.description')
                        </ul>
                    </div>
                </div>

                <div class="article">
                    <div>
                        <img src="{{url('/')}}/images/rules-block-7-icon.png">
                    </div>
                    <div class="article-description">
                        <h2>@lang('content.vacancyRules.text.section_7.title')</h2>
                        <ul>
                            @lang('content.vacancyRules.text.section_7.description')
                        </ul>
                    </div>
                </div>

                <div class="article">
                    <div>
                        <img src="{{url('/')}}/images/rules-block-8-icon.png">
                    </div>
                    <div class="article-description">
                        <h2>@lang('content.vacancyRules.text.section_8.title')</h2>
                        <ul>
                            @lang('content.vacancyRules.text.section_8.description')
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection