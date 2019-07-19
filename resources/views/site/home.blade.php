@extends('layouts.site')

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
                        <img class="mx-auto" src="images/about/card_1.svg" alt="@lang('content.about.card_1.title')">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-center">@lang('content.about.card_1.title')</h4>
                        <p class="card-text text-center">@lang('content.about.card_1.text')</p>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-img-top mx-auto">
                        <img class="mx-auto" src="images/about/card_2.svg" alt="@lang('content.about.card_2.title')">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-center">@lang('content.about.card_2.title')</h4>
                        <p class="card-text text-center">@lang('content.about.card_2.text')</p>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-img-top mx-auto">
                        <img class="mx-auto" src="images/about/card_3.svg" alt="@lang('content.about.card_3.title')">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-center">@lang('content.about.card_3.title')</h4>
                        <p class="card-text text-center">@lang('content.about.card_3.text')</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="btn btn-success mx-auto">
                    <span>
                        @lang('content.about.button')
                    </span>
                </div>
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
                <div class="btn btn-success mx-auto">
                    <span>
                        @lang('content.organisations.button')
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid section-partners">
        <div class="row">
            <h3 class="mx-auto">@lang('content.partners.title')</h3>
        </div>


        <div class="row">

            <div class="container text-center">
                <div class="row">
                    <div class="partners-carousel mr-auto ml-auto">
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-1.png">
                                <p class="partner-name">Iмяiмяiмя Фамiлiя</p>
                                <p class="partner-role">Роля у камандзе</p>
                                <img class="social" src="images/partners/vk.svg">
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-2.png">
                                <p class="partner-name">Iмяiмяiмя Фамiлiя</p>
                                <p class="partner-role">Роля у камандзе</p>
                                <img class="social" src="images/partners/vk.svg">
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-3.png">
                                <p class="partner-name">Iмяiмяiмя Фамiлiя</p>
                                <p class="partner-role">Роля у камандзе</p>
                                <img class="social" src="images/partners/fb.svg">
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-4.png">
                                <p class="partner-name">Iмяiмяiмя Фамiлiя</p>
                                <p class="partner-role">Роля у камандзе</p>
                                <img class="social" src="images/partners/fb.svg">
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-1.png">
                                <p class="partner-name">Iмяiмяiмя Фамiлiя</p>
                                <p class="partner-role">Роля у камандзе</p>
                                <img class="social" src="images/partners/vk.svg">
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-2.png">
                                <p class="partner-name">Iмяiмяiмя Фамiлiя</p>
                                <p class="partner-role">Роля у камандзе</p>
                                <img class="social" src="images/partners/vk.svg">
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-3.png">
                                <p class="partner-name">Iмяiмяiмя Фамiлiя</p>
                                <p class="partner-role">Роля у камандзе</p>
                                <img class="social" src="images/partners/fb.svg">
                            </div>
                        </div>
                        <div>
                            <div class="partner-card mx-auto">
                                <img src="images/partners/image-4.png">
                                <p class="partner-name">Iмяiмяiмя Фамiлiя</p>
                                <p class="partner-role">Роля у камандзе</p>
                                <img class="social" src="images/partners/fb.svg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <div class="row">
            <div class="btn btn-success mx-auto">
                <span>
                    @lang('content.partners.button')
                </span>
            </div>
        </div>
    </div>
@endsection