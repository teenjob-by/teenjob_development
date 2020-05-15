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

        var a = 0;
        $(window).scroll(function() {

            var oTop = $('#counter').offset().top - window.innerHeight;
            if (a == 0 && $(window).scrollTop() > oTop) {
                $('.counter-value').each(function() {
                    var $this = $(this),
                        countTo = $this.attr('data-count');
                    $({
                        countNum: $this.text()
                    }).animate({
                            countNum: countTo
                        },

                        {

                            duration: 2000,
                            easing: 'swing',
                            step: function() {
                                $this.text(Math.floor(this.countNum));
                            },
                            complete: function() {
                                $this.text(this.countNum);
                                //alert('finished');
                            }

                        });
                });
                a = 1;
            }

        });
    </script>

@endsection

@section('content')

    <section class="home_section-achievements">
        <div class="content-wrapper">
            <h3 class="home_title-about">@lang('content.counter.title')</h3>

            <section id="counter" class="card-wrapper counter-value-wrapper">

                @for($i = 1; $i <= 3; $i++)

                    <div class="home_card-counter-value">
                        <div class="card-header">
                            @if($i == 1)
                                <span>></span>
                            @endif
                            <div class="counter-value" data-count="@lang('content.counter.card_'. $i .'.value')">0</div>
                        </div>
                        <div class="card-body">
                            <p class="card-body-text">@lang('content.counter.card_'. $i .'.text')</p>
                        </div>
                    </div>
                @endfor
            </section>
        </div>
    </section>

    <section class="home_section-for-teens">
        <div class="content-wrapper">
            <h3 class="home_title-about">@lang('content.teens.title')</h3>

            <section class="card-wrapper">
                @for($i = 1; $i <= 3; $i++)
                    <div class="home_card-for-teens">
                        <div class="card-body">
                            <img class="card-header-image" src="images/section-about/teens-{{ $i }}.png">
                            <h4 class="card-body-title">@lang('content.teens.card_'. $i .'.title')</h4>
                            <p class="card-body-text">@lang('content.teens.card_'. $i .'.text')</p>
                        </div>
                    </div>
                @endfor
            </section>

        </div>
    </section>

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


            <a role="button" class="button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSdAYxXLNuyauPn7Bi-rhhnF9T7hnAnfCgzp7sgPW0wKRQtGmg/viewform">
                <span>
                    @lang('content.rulesForEmployers.text.button')
                </span>
            </a>


        </div>
    </section>

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

@endsection
