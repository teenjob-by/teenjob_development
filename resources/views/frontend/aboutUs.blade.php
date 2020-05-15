@extends('layouts.frontend')
@section('seo_meta')
    <meta name="description" content="Правила публикации объявлений. Условия попадания в черный список и удаления аккаунта. Использование персональных данных. Формирование правил пользования."/>
    <meta name="language" content="RU"/>

    <title>О нас teenjob.by</title>
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

    <section class="info-page_section">
        <div class="content-wrapper">
            <div class="info-page_subsection-full">
                <h3 class="info-page-title">@lang('content.aboutUs.title')</h3>
                <div class="text-section">
                    <div class="text-row">
                        <div class="column text">
                            @lang('content.aboutUs.text.section_1')
                        </div>
                        <div class="column image">
                            <img src="/images/section-about/column-1.png">
                        </div>
                    </div>

                    <div class="text-row">
                        <div class="column image">
                            <img src="/images/section-about/column-2.png">
                            @lang('content.aboutUs.text.picture_2')
                        </div>
                        <div class="column text">
                            @lang('content.aboutUs.text.section_2')
                        </div>
                    </div>

                    <div class="text-row">
                        <div class="column text">
                            @lang('content.aboutUs.text.section_3')
                        </div>

                        <div class="column image">
                            <img src="/images/section-about/column-3.png">
                            @lang('content.aboutUs.text.picture_3')
                        </div>
                    </div>
                </div>

                <section class="home_section-team">
                    <div class="content-wrapper">
                        <h3 class="home_title-team">@lang('content.partners.title')</h3>

                        <section class="home_carousel-wrapper">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">

                                    @for ($i = 1; $i <= 5; $i++)
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
            </div>

            <div class="info-page_menu-section-absolute">
                @include('frontend.chunks.infoSideMenu')
            </div>
        </div>
    </section>
@endsection