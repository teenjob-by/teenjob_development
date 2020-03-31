@extends('layouts.site')
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

@section('content')

    <div class="container-fluid">
        <div class="container info-page">
            <div class="content-section full">
                <h3 class="info-page-title">@lang('content.aboutUs.title')</h3>
                <div class="text-section">
                    <div class="text-row">
                        <div class="column text">
                            @lang('content.aboutUs.text.section_1')
                        </div>
                        <div class="column image">
                            <img src="/images/about/column-1.png">
                        </div>
                    </div>

                    <div class="text-row">
                        <div class="column image">
                            <img src="/images/about/column-2.png">
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
                            <img src="/images/about/column-3.png">
                            @lang('content.aboutUs.text.picture_3')
                        </div>
                    </div>

                </div>


                <div class="container-fluid team-section">
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
            </div>

            <div class="menu-section-absolute">
                @include('site.blocks.infoSideMenu')
            </div>
        </div>
    </div>


@endsection