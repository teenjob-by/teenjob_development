@extends('layouts.frontend')
@section('seo_meta')
    <meta name="description" content="Правила публикации объявлений. Условия попадания в черный список и удаления аккаунта. Использование персональных данных. Формирование правил пользования."/>
    <meta name="language" content="RU"/>

    <title>Правила сайта teenjob.by</title>
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
                <h3 class="info-page-title">@lang('content.termsOfUse.title')</h3>
                <div class="text-section">
                    @lang('content.termsOfUse.description')
                </div>
            </div>

            <div class="info-page_menu-section">
                @include('frontend.chunks.infoSideMenu')
            </div>
        </div>
    </section>

@endsection