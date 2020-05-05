@extends('layouts.frontend')
@section('seo_meta')
    <meta name="description" content="Администрация ресурса не несет ответственность за какие-либо последствия, вызванные использованием предоставленной информации, ее неверным толкованием или пониманием."/>
    <meta name="language" content="RU"/>

    <title>Отказ от ответственности - teenjob.by</title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/main_fb.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/main_vk.png">
@endsection

@section('content')

    <section class="info-page_section">
        <div class="content-wrapper">
            <div class="info-page_subsection">
                <h3 class="info-page-title">@lang('conditions_page.title')</h3>
                <div class="text-section">
                    <p>@lang('conditions_page.text')</p>
                </div>
            </div>

            <div class="info-page_menu-section">
                @include('frontend.chunks.infoSideMenu')
            </div>
        </div>
    </section>

@endsection