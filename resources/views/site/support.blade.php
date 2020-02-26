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

@section('body_class', 'page-home')

@section('content')
    <div class="container-fluid support-page">
        <div class="container">
            <div class="row">
                <h3 class="mx-auto">@lang('content.support.title')</h3>
            </div>
            <div class="row">
                <p class="notification">@lang('content.support.subtitle')</p>
            </div>
            <div class="row">
                <form method="post" action="{{ route('site.support') }}">
                    @csrf

                    @if(!empty($message))
                        <div class="alert alert-danger">{{ $message }}</div>
                    @endif
                    <div class="form-group support-form-subject col-lg-12">
                        <label for="subject">Тема</label>
                        <input type="text" required class="form-control" name="subject" />
                    </div>

                    @error('title')
                    <div class="alert alert-danger">@lang('content.support.error')</div>
                    @enderror

                    <div class="form-group support-form-message col-lg-12">
                        <label for="message">@lang('content.support.yourMessage')</label>
                        <textarea type="text" required class="form-control support-form-message-text" name="description">@if(!empty($_GET['abuse'])){{url()->previous()}}@endif</textarea>
                    </div>

                    <div class="form-group support-form-field col-lg-12">
                        <label for="last_name">@lang('content.support.yourName')</label>
                        <input type="text" required class="form-control" name="name" />
                    </div>

                    <div class="form-group support-form-field col-lg-12">
                        <label for="city">@lang('content.support.yourEmail')</label>
                        <input type="text" required class="form-control" name="email" />
                    </div>

                    <div class="form-group support-form-field col-lg-12">
                        <label for="city">@lang('content.support.yourPhone')</label>
                        <input type="text" required  class="form-control" name="phone" />
                    </div>

                    <button type="submit" class="ml-3 btn btn-primary">@lang('content.support.send')</button>
                </form>
            </div>
        </div>
    </div>
@endsection