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

        var swiperSlider = new Swiper ('#reviews', {
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
                nextEl: '.swiper-button-next-reviews',
                prevEl: '.swiper-button-prev-reviews',
            },
        })
        var swiperSlider2 = new Swiper ('#partners', {
            direction: 'horizontal',
            loop: true,
            slidesPerView : 3,

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
                    slidesPerView: 2,
                },

                1024: {
                    slidesPerView: 3,
                }
            },

            navigation: {
                nextEl: '.swiper-button-next-partners',
                prevEl: '.swiper-button-prev-partners',
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

        $('.open-menu').click(function(e) {
            e.preventDefault();
            document.body.scrollTop = document.documentElement.scrollTop = 0;

            setTimeout(function() {

                if(!($(".header_menu").is(":visible"))) {
                    $('.burger').click()
                }

            }, 500);



        });

    </script>

@endsection

@section('content')

    <section class="home_section-achievements">
        <div class="content-wrapper">
            <h3 class="home_title-achievements">@lang('content.counter.title')</h3>

            <section id="counter" class="card-wrapper counter-value-wrapper">

                @for($i = 1; $i <= 3; $i++)

                    <div class="home_card-counter-value">
                        <div class="card-header">
                            @if($i == 1)
                                <span>></span>
                            @endif
                            <div class="counter-value" data-count="{{ $counters[$i - 1] }}">0</div>
                        </div>
                        <div class="card-body">
                            <p class="card-body-text">@lang('content.counter.card_'. $i .'.text')</p>
                        </div>
                    </div>
                @endfor
            </section>
        </div>
    </section>

    <section class="home_section-for-teens section_gray">
        <div class="content-wrapper">
            <h3 class="home_title-about">@lang('content.teens.title')</h3>

            <section class="card-wrapper">
                @for($i = 1; $i <= 3; $i++)
                    <div class="home_card-for-teens">
                        <div class="card-header">
                            <img class="card-header-image" src="images/section-about/for-teens-{{ $i }}.svg" alt="@lang('content.about.card_1.imgAlt')">
                        </div>
                        <div class="card-body">
                            <h4 class="card-body-title">@lang('content.teens.card_'. $i .'.title')</h4>
                            <p class="card-body-text">@lang('content.teens.card_'. $i .'.text')</p>
                        </div>
                    </div>
                @endfor
            </section>

            <a role="button" class="button-primary" href="https://docs.google.com/forms/u/3/d/e/1FAIpQLScxqBqJT8hcfKPa0jzAb_XYKP8XR7HEFJe2tQFKMh3KZL2h7Q/viewform" target="_blank">
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
                            <img class="card-header-image" src="images/section-about/for-companies-{{ $i }}.svg" alt="@lang('content.organisations.card_1.imgAlt')">
                        </div>
                        <div class="card-body">
                            <p class="card-body-text">@lang('content.organisations.card_'. $i .'.text')</p>
                        </div>
                    </div>
                @endfor
            </section>

            <p class="home_organisations-subtitle">@lang('content.organisations.buttonSubtitle')</p>


            <a role="button" class="button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSdAYxXLNuyauPn7Bi-rhhnF9T7hnAnfCgzp7sgPW0wKRQtGmg/viewform" target="_blank">
                <span>
                    @lang('content.rulesForEmployers.text.button')
                </span>
            </a>


        </div>
    </section>

    <section class="home_section-important section_gray">
        <div class="content-wrapper">
            <div class="important-description">
                <div class="important-text">
                    <h3 class="home_title-important">@lang('content.important.title')</h3>
                    <p class="home_organisations-subtitle">@lang('content.important.subtitle')</p>
                    <p class="card-body-text">@lang('content.important.text')</p>
                </div>

                <div class="important-image">
                    <img src="/images/important.svg">
                </div>
            </div>

            {{--<a role="button" class="button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSdAYxXLNuyauPn7Bi-rhhnF9T7hnAnfCgzp7sgPW0wKRQtGmg/viewform">
                <span>
                    @lang('content.rulesForEmployers.text.button')
                </span>
            </a>--}}
        </div>
    </section>


    <section class="home_section-partners">
        <div class="content-wrapper">
            <h3 class="home_title-partners">@lang('content.partners.title')</h3>

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

            <a role="button" class="button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSdAYxXLNuyauPn7Bi-rhhnF9T7hnAnfCgzp7sgPW0wKRQtGmg/viewform" target="_blank">
                <span>
                    @lang('content.partners.button')
                </span>
            </a>

        </div>
    </section>


    <section class="home_section-reviews section_gray">
        <div class="content-wrapper">
            <h3 class="home_title-reviews">@lang('content.reviews.title')</h3>

            <section class="reviews_wrapper">
                <div id="reviews" class="swiper-container reviews-container">
                    <div class="swiper-wrapper">

                        @for ($i = 1; $i <= 2; $i++)
                            <div class="swiper-slide">
                                <div class="slide-wrapper">
                                    <div class="slide-image-wrapper">
                                        <img class="slide-image" src="images/home/reviews/review-{{ $i }}.png">
                                    </div>

                                   <p class="slide-name">@lang('content.reviews.card_'.$i.'.name')</p>
                                   <p class="slide-text">@lang('content.reviews.card_'.$i.'.text')</p>
                                </div>
                            </div>
                        @endfor

                    </div>
                </div>

                <div class="swiper-button-prev-reviews swiper-button-prev"></div>
                <div class="swiper-button-next-reviews swiper-button-next"></div>
            </section>

            <a role="button" class="button-primary open-menu">
                <span>
                    @lang('content.reviews.button')
                </span>
            </a>

        </div>
    </section>

@endsection
