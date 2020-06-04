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

@section('styles')
    <link rel="stylesheet" href="{{url('/')}}/css/swiper.min.css">


@endsection


@section('scripts')
    <script src="{{url('/')}}/js/swiper.min.js"></script>


    <script>


        var swiperSlider2 = new Swiper ('#partners', {
            direction: 'horizontal',
            loop: true,
            slidesPerView : 1,

            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 1,
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 1,
                },

                1024: {
                    slidesPerView: 1,
                }
            },

            navigation: {
                nextEl: '.swiper-button-next-partners',
                prevEl: '.swiper-button-prev-partners',
            },
        })





    </script>

@endsection

@section('content')

    <section class="info-page_section">
        <div class="content-wrapper">
            <div class="info-page_subsection">
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

                        <section class="partners_wrapper">
                            <div id="partners" class="swiper-container">
                                <div class="swiper-wrapper">

                                    @for ($i = 1; $i <= 4; $i++)
                                        <div class="swiper-slide">
                                            <a href="@lang('content.partners.link_'.$i)" target="_blank" class="slide-wrapper">
                                                <div class="image-wrapper">
                                                    <img class="slide-image" src="images/home/companies/companies-{{ $i }}.png">
                                                </div>
                                            </a>
                                        </div>
                                    @endfor

                                </div>
                            </div>

                            <div class="swiper-button-prev-partners swiper-button-prev"></div>
                            <div class="swiper-button-next-partners swiper-button-next"></div>
                        </section>



                        <h5 class="organisations-block-subtitle">@lang('content.rulesForEmployers.text.needHelp')</h5>
                        <a class="button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSdAYxXLNuyauPn7Bi-rhhnF9T7hnAnfCgzp7sgPW0wKRQtGmg/viewform" target="_blank">
                        <span>
                                @lang('content.rulesForEmployers.text.button')
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="info-page_menu-section">
                @include('frontend.chunks.infoSideMenu')
            </div>
        </div>
    </section>

@endsection
