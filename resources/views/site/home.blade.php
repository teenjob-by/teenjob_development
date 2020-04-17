@extends('layouts.site')

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

@section('body_class', 'page-home')

@section('content')
    <div class="container-fluid section-about">
        <div class="container">
            <div class="row">
                <h3 class="mx-auto">@lang('content.about.title')</h3>
            </div>
            <div class="row justify-content-between">
                <div class="card border-0">
                    <div class="card-img-top mx-auto">
                        <img class="mx-auto" src="images/about/card_1.svg" alt="Для подростков">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-center">@lang('content.about.card_1.title')</h4>
                        <p class="card-text text-center">@lang('content.about.card_1.text')</p>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-img-top mx-auto">
                        <img class="mx-auto" src="images/about/card_2.svg" alt="Волонтерство">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-center">@lang('content.about.card_2.title')</h4>
                        <p class="card-text text-center">@lang('content.about.card_2.text')</p>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-img-top mx-auto">
                        <img class="mx-auto" src="images/about/card_3.svg" alt="Мероприятия">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-center">@lang('content.about.card_3.title')</h4>
                        <p class="card-text text-center">@lang('content.about.card_3.text')</p>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <a class="btn btn-success mx-auto" href="/offers">
                    <span>
                        @lang('content.about.button')
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid section-organisations">
        <div class="container">
            <div class="row">
                <h3 class="mx-auto">@lang('content.organisations.title')</h3>
            </div>
            <div class="row justify-content-between">
                <div class="card border-0">
                    <div class="card-img-top mx-auto">
                        <img class="mx-auto" src="images/organisations/card_1.svg" alt="@lang('content.organisations.card_1.title')">
                    </div>
                    <div class="card-body">
                        <p class="card-text text-center">@lang('content.organisations.card_1.text')</p>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-img-top mx-auto">
                        <img class="mx-auto" src="images/organisations/card_2.svg" alt="@lang('content.organisations.card_2.title')">
                    </div>
                    <div class="card-body">
                        <p class="card-text text-center">@lang('content.organisations.card_2.text')</p>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-img-top mx-auto">
                        <img class="mx-auto" src="images/organisations/card_3.svg" alt="@lang('content.organisations.card_3.title')">
                    </div>
                    <div class="card-body">
                        <p class="card-text text-center">@lang('content.organisations.card_3.text')</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <a class="btn btn-success mx-auto" href="{{ route('register') }}">
                    <span>
                        @lang('content.organisations.button')
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid section-partners">
        <div class="row">
            <h3 class="mx-auto">@lang('content.partners.title')</h3>
        </div>


        <div class="row carousel-wrapper">

            <div class="container text-center">
                <div class="row">
                    <div class="partners-carousel mr-auto ml-auto">
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-4.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_1.name") @lang("team.team_1.surname")</p>
                                <p class="partner-role">@lang("team.team_1.role")</p>
                                <div class="d-flex">
                                    <a href="https://www.facebook.com/alexey.kirpichenkau" target="_blank">
                                        <img class="social" src="images/partners/fb.svg">
                                    </a>
                                    <a class="ml-1" href="https://github.com/fr0zen" target="_blank">
                                        <img class="social" src="images/github.svg">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-1.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_4.name") @lang("team.team_4.surname")</p>
                                <p class="partner-role">@lang("team.team_4.role")</p>
                                <a href="https://www.facebook.com/valeriya.omeliusik" target="_blank">
                                    <img class="social" src="images/partners/fb.svg">
                                </a>
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-6.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_3.name") @lang("team.team_3.surname")</p>
                                <p class="partner-role">@lang("team.team_3.role")</p>
                                <div class="d-flex">
                                    <a href="https://www.facebook.com/profile.php?id=100034265058592" target="_blank">
                                        <img class="social" src="images/partners/fb.svg">
                                    </a>
                                </div>
                            </div>
                        </div>                        
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-5.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_2.name") @lang("team.team_2.surname")</p>
                                <p class="partner-role">@lang("team.team_2.role")</p>
                                <div class="d-flex">
                                    <a href="https://www.facebook.com/profile.php?id=100021516801825" target="_blank">
                                        <img class="social" src="images/partners/fb.svg">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-2.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_5.name") @lang("team.team_5.surname")</p>
                                <p class="partner-role">@lang("team.team_5.role")</p>
                                <a href="https://www.facebook.com/anastasiya.novemberfrost" target="_blank">
                                    <img class="social" src="images/partners/fb.svg">
                                </a>
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-3.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_6.name") @lang("team.team_6.surname")</p>
                                <p class="partner-role">@lang("team.team_6.role")</p>
                                <a href="https://www.facebook.com/yaroslava.golubova" target="_blank">
                                    <img class="social" src="images/partners/fb.svg">
                                </a>
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-4.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_1.name") @lang("team.team_1.surname")</p>
                                <p class="partner-role">@lang("team.team_1.role")</p>
                                <div class="d-flex">
                                    <a href="https://www.facebook.com/alexey.kirpichenkau" target="_blank">
                                        <img class="social" src="images/partners/fb.svg">
                                    </a>
                                    <a class="ml-1" href="https://github.com/fr0zen" target="_blank">
                                        <img class="social" src="images/github.svg">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-1.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_4.name") @lang("team.team_4.surname")</p>
                                <p class="partner-role">@lang("team.team_4.role")</p>
                                <a href="https://www.facebook.com/valeriya.omeliusik" target="_blank">
                                    <img class="social" src="images/partners/fb.svg">
                                </a>
                            </div>
                        </div>                        
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-6.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_3.name") @lang("team.team_3.surname")</p>
                                <p class="partner-role">@lang("team.team_3.role")</p>
                                <div class="d-flex">
                                    <a href="https://www.facebook.com/profile.php?id=100034265058592" target="_blank">
                                        <img class="social" src="images/partners/fb.svg">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-1.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_4.name") @lang("team.team_4.surname")</p>
                                <p class="partner-role">@lang("team.team_4.role")</p>
                                <a href="https://www.facebook.com/valeriya.omeliusik" target="_blank">
                                    <img class="social" src="images/partners/fb.svg">
                                </a>
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-5.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_2.name") @lang("team.team_2.surname")</p>
                                <p class="partner-role">@lang("team.team_2.role")</p>
                                <div class="d-flex">
                                    <a href="https://www.facebook.com/profile.php?id=100021516801825" target="_blank">
                                        <img class="social" src="images/partners/fb.svg">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-2.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_5.name") @lang("team.team_5.surname")</p>
                                <p class="partner-role">@lang("team.team_5.role")</p>
                                <a href="https://www.facebook.com/anastasiya.novemberfrost" target="_blank">
                                    <img class="social" src="images/partners/fb.svg">
                                </a>
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-3.png" class="slick-image">
                                <p class="partner-name">@lang("team.team_6.name") @lang("team.team_6.surname")</p>
                                <p class="partner-role">@lang("team.team_6.role")</p>
                                <a href="https://www.facebook.com/yaroslava.golubova" target="_blank">
                                    <img class="social" src="images/partners/fb.svg">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <a href="https://docs.google.com/forms/d/e/1FAIpQLSeF9aN5IB5q-Bdt6wxt3LErIl8frng04X6lflCwjD1WZcnEqg/viewform" class="btn btn-success mx-auto">
                <span>
                    @lang('content.partners.button')
                </span>
            </a>
        </div>
    </div>
@endsection
