@extends('layouts.site')
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
@section('body_class', 'page-home')

@section('content')
    <div class="container-fluid background">
        <div class="container conditions">
            <div class="row justify-content-center">
                <h3>@lang('content.termsOfUse.title')</h3>
                <hr/>
                @lang('content.termsOfUse.description')
            </div>
        </div>
    </div>



@endsection