@extends('layouts.frontend')

@section('seo_meta')
    <meta name="description" content="@lang('headings.home.description')"/>
    <meta name="language" content="@lang('headings.home.language')"/>
    <meta name="keywords" content="@lang('headings.home.keywords')">
    <title>@lang('headings.home.title')</title>
    <meta name="yandex-verification" content="0650b2f8f4059cd1" />
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/main_fb.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/main_vk.png">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{url('/')}}/css/swiper.min.css">
    <link href="css/justselect.min.css" rel="stylesheet" />

@endsection


@section('scripts')
    <script src="{{url('/')}}/js/swiper.min.js"></script>
    <script src="{{url('/')}}/js/justselect.min.js"></script>

    <script>

        var swiperSlider = new Swiper ('.swiper-container', {
            direction: 'horizontal',
            loop: true,
            slidesPerView : 4,

            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 2,
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 3,
                },

                1024: {
                    slidesPerView: 4,
                }
            },

            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        })
    </script>

@endsection

@section('content')

    <section class="home_section-about">
        <div class="content-wrapper">
            <h3 class="home_title-about">@lang('content.about.title')</h3>

            <section class="card-wrapper">
                @for($i = 1; $i <= 3; $i++)
                    <div class="home_card-about">
                        <div class="card-header">
                            <img class="card-header-image" src="images/section-about/card_{{ $i }}.svg" alt="@lang('content.about.card_1.imgAlt')">
                        </div>
                        <div class="card-body">
                            <h4 class="card-body-title">@lang('content.about.card_'. $i .'.title')</h4>
                            <p class="card-body-text">@lang('content.about.card_'. $i .'.text')</p>
                        </div>
                    </div>
                @endfor
            </section>

            <a role="button" class="button-primary" href="https://docs.google.com/forms/u/3/d/e/1FAIpQLScxqBqJT8hcfKPa0jzAb_XYKP8XR7HEFJe2tQFKMh3KZL2h7Q/viewform">
                <span>
                    @lang('content.about.button')
                </span>
            </a>

        </div>
    </section>

    <section class="home_section-organisations">
        <div class="content-wrapper">
            <h3 class="home_title-organisations">@lang('content.organisations.title')</h3>

            <section class="card-wrapper">
                @for($i = 1; $i <= 3; $i++)
                    <div class="home_card-organisations">
                        <div class="card-header">
                            <img class="card-header-image" src="images/section-organisations/card_{{ $i }}.svg" alt="@lang('content.organisations.card_1.imgAlt')">
                        </div>
                        <div class="card-body">
                            <p class="card-body-text">@lang('content.organisations.card_'. $i .'.text')</p>
                        </div>
                    </div>
                @endfor
            </section>

            {{--

            <p class="button-subtitle">@lang('content.organisations.buttonSubtitle')</p>
            <a role="button" class="button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSdAYxXLNuyauPn7Bi-rhhnF9T7hnAnfCgzp7sgPW0wKRQtGmg/viewform">
                <span>
                    @lang('content.organisations.button')
                </span>
            </a>

            --}}

            <div class="organisations-block">
                <h4 class="organisations-block-title">@lang('content.rulesForEmployers.text.assistantNeeded')</h4>
                <div class="organisations-block-description">
                    <a href="https://iqido.biz/">
                        <img src="/images/partners/organisation-1.png">
                    </a>
                </div>
                <h4 class="organisations-block-subtitle">@lang('content.organisations.needHelp')</h4>
                <a role="button" class="button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSdAYxXLNuyauPn7Bi-rhhnF9T7hnAnfCgzp7sgPW0wKRQtGmg/viewform">
                            <span>
                                @lang('content.rulesForEmployers.text.button')
                            </span>
                </a>
                <a class="rules-link-mobile" href="/rules-for-employers">@lang('content.organisations.link')</a>
            </div>


        </div>
    </section>

    <section class="home_section-team">
        <div class="content-wrapper">
            <h3 class="home_title-team">@lang('content.partners.title')</h3>

            <section class="home_carousel-wrapper">
                <div class="swiper-container">
                    <div class="swiper-wrapper">

                        @for ($i = 1; $i <= 6; $i++)
                            <div class="swiper-slide">
                                <div class="slide-wrapper">
                                    <div class="slide-header">
                                        <img class="slide-header-image" src="images/section-team/image-{{ $i }}.png">
                                    </div>

                                    <p class="slide-name">@lang("team.team_".$i.".name") @lang("team.team_".$i.".surname")</p>
                                    <p class="slide-role">@lang("team.team_".$i.".role")</p>
                                    <div class="slide-social">
                                        <a href="@lang('team.team_'.$i.'.social.link_1')" target="_blank">
                                            <img class="social-icon" src="images/section-team/fb.svg">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endfor

                    </div>
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </section>

            <a role="button" class="button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSeF9aN5IB5q-Bdt6wxt3LErIl8frng04X6lflCwjD1WZcnEqg/viewform">
                <span>
                    @lang('content.partners.button')
                </span>
            </a>

        </div>
    </section>

@endsection
