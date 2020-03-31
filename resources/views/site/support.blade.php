@extends('layouts.site')
@section('seo_meta')
    <meta name="description" content="Напишите на teenjob.by@gmail.com или заполните форму обратной связи. Будем рады сотрудничеству."/>
    <meta name="language" content="RU"/>

    <title>Контакты teenjob.by</title>
@endsection
@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/support.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/support.png">
@endsection


@section('content')

    <div class="container-fluid">
        <div class="container info-page">
            <div class="content-section">
                <h3 class="info-page-title">@lang('content.support.title')</h3>
                <div class="text-section">
                    <p class="notification">@lang('content.support.subtitle')</p>


                        <form method="post" class="contact-form" action="{{ route('site.support') }}">
                            @csrf

                            @if(!empty($message))
                                <div class="alert alert-danger">{{ $message }}</div>
                            @endif
                            <div class="form-group contact-form-field">
                                <label class="title-label" for="subject">@lang('content.support.theme')</label>
                                <input type="text" required class="form-control" name="subject" />
                            </div>

                            @error('title')
                            <div class="alert alert-danger">@lang('content.support.error')</div>
                            @enderror

                            <div class="form-group contact-form-message">
                                <label for="message" class="title-label">@lang('content.support.yourMessage')</label>
                                <textarea type="text" required class="form-control contact-form-message" name="description">@if(!empty($_GET['abuse'])){{url()->previous()}}@endif</textarea>
                            </div>

                            <div class="form-group contact-form-field">
                                <label for="last_name">@lang('content.support.yourName')</label>
                                <input type="text" required class="form-control" name="name" placeholder="@lang('content.support.yourNamePlaceholder')"/>
                            </div>

                            <div class="form-group contact-form-field">
                                <label for="city">@lang('content.support.yourEmail')</label>
                                <input type="text" required class="form-control" name="email" placeholder="@lang('content.support.yourEmailPlaceholder')"/>
                            </div>

                            <div class="form-group contact-form-field">
                                <label for="city">@lang('content.support.yourPhone')</label>
                                <input type="text" required  class="form-control" name="phone" placeholder="@lang('content.support.yourPhonePlaceholder')"/>
                            </div>

                            <button type="submit" class="btn btn-primary contact-form-button">@lang('content.support.send')</button>
                        </form>
                </div>
            </div>

            <div class="menu-section">
                @include('site.blocks.infoSideMenu')
            </div>
        </div>
    </div>


@endsection