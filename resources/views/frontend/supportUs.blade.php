@extends('layouts.frontend')

@section('seo_meta')
    <meta name="description" content="Присоединяйтесь к teenjob.by и развивайте проект вместе с нами либо становитесь нашим партнером."/>
    <meta name="language" content="RU"/>

    <title>Поддержать волонтерский проект для подростков teenjob.by</title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/support.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/support.png">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{url('/')}}/css/swiper.min.css">
@endsection


@section('scripts')
    <script src="{{url('/')}}/js/swiper.min.js"></script>
    <script src="{{url('/')}}/js/swiper.min.js"></script>

    <script>

        var swiperSlider = new Swiper ('.swiper-container', {
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
                    slidesPerView: 2,
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 3,
                },

                1024: {
                    slidesPerView: 3,
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
            <div class="info-page_subsection-full support-us">
                <h3 class="info-page-title">@lang('content.help.title')</h3>
                <h4 class="info-page-subtitle">@lang('content.help.subtitle')</h4>


                <div class="donate-widget">
                    <iframe width="100%" height="320" src="https://molamola.by/campaigns/widget/1579" frameborder="0" scrolling="no"></iframe>
                </div>
                <div class="card-wrapper">
                    <div class="support-card mb-0">
                        <div class="circle">
                            <img src="/images/charity.png">
                        </div>
                            <h3>@lang('content.help.column-1')</h3>
                            <p>@lang('content.help.column-1-text')</p>
                    </div>
                </div>
                <div class="card-wrapper mb-0">                  
                    <div class="support-card mb-0 bottom-margin">
                        <div class="circle">
                            <img src="/images/collaboration.png">
                        </div>
                        <h3>@lang('content.help.column-2')</h3>
                        <p>@lang('content.help.column-2-text')</p>
                    </div>
                    <div class="support-card mb-0">
                        <div class="circle">
                            <img src="/images/heart.png">
                        </div>
                        <h3>@lang('content.help.column-3')</h3>
                        <p>@lang('content.help.column-3-text')</p>
                    </div>
                </div>

                <section class="partners">
                        <h3 class="partners_title">@lang('content.help.partner')</h3>

                        <section class="partners_wrapper">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">

                                    @for ($i = 1; $i <= 3; $i++)
                                        <div class="swiper-slide">
                                            <div class="slide-wrapper">
                                                <a href="@lang("content.partners_".$i.".link")">
                                                    <img class="slide-image" src="images/section-partners/partner-logo-{{ $i }}.png">
                                                </a>
                                            </div>
                                        </div>
                                    @endfor

                                </div>
                            </div>

                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </section>

                </section>
            </div>
        </div>
    </section>



@endsection
