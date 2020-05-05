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
                <h2 class="partners_title">@lang('content.help.partner')</h2>
                <div class="partners_wrapper">
                    <a class="partners_card" href="https://hoster.by" target="_blank">
                        <img src="images/section-team/partner-logo-1.png">
                    </a>
                    <a class="partners_card" href="https://www.facebook.com/TerytoryjaPravou/" target="_blank">
                        <img src="images/section-team/partner-logo-2.png">
                    </a>
                    <a class="partners_card" href="http://eduexpo.by/" target="_blank">
                        <img src="images/section-team/partner-logo-3.png">
                    </a>
                </div>
            </div>
        </div>
    </section>



@endsection
