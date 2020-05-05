@extends('layouts.frontend')
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

@section('scripts')
    <script>
        $(document).ready(function() {

            var phoneMask = IMask(document.getElementById('phone'), {
                    mask: [
                        {
                            mask: '+000 {00} 000-00-00',
                            startsWith: '375',
                            lazy: false,
                            country: 'Belarus'
                        },
                        {
                            mask: '+0 (000) 000-00-00',
                            startsWith: '7',
                            lazy: false,
                            country: 'Russia'
                        },
                        {
                            mask: '0000000000000',
                            startsWith: '',
                            country: 'unknown'
                        }
                    ],
                    dispatch: function (appended, dynamicMasked) {
                        var number = (dynamicMasked.value + appended).replace(/\D/g, '');

                        return dynamicMasked.compiledMasks.find(function (m) {
                            return number.indexOf(m.startsWith) === 0;
                        });
                    }
                }
            )
        });
    </script>
@endsection


@section('content')

    <section class="info-page_section">
        <div class="content-wrapper">
            <div class="info-page_subsection">
                <h3 class="info-page-title">@lang('content.support.title')</h3>
                <p class="notification">@lang('content.support.subtitle')</p>

                        <form method="post" class="contact-form" action="{{ route('frontend.feedback') }}">
                            @csrf

                            @if(!empty($message))
                                <div class="alert alert-danger">{{ $message }}</div>
                            @endif


                            <div class="contact-form_form-group">
                                <label for="subject" class="contact-form_form-group-label">@lang('content.support.theme')</label>
                                <input id="subject" type="text" name="subject" placeholder="" class="contact-form_form-group-input @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required autocomplete="subject" autofocus minlength="3">

                                @error('subject')
                                <span class="login-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            @error('title')
                            <div class="alert alert-danger">@lang('content.support.error')</div>
                            @enderror

                            <div class="contact-form_form-group">
                                <label for="message" class="contact-form_form-group-label">@lang('content.support.yourMessage')</label>
                                <textarea type="text" required class="contact-form_form-group-textarea" name="description">@if(!empty($_GET['abuse'])){{url()->previous()}}@endif</textarea>
                            </div>

                            <div class="contact-form_form-group">
                                <label for="last_name" class="contact-form_form-group-label-light">@lang('content.support.yourName')</label>
                                <input id="last_name" type="text" name="name" placeholder="@lang('content.support.yourNamePlaceholder')" class="contact-form_form-group-input @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required autocomplete="subject" autofocus minlength="3">

                                @error('last_name')
                                <span class="login-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="contact-form_form-group">
                                <label for="email" class="contact-form_form-group-label-light">@lang('content.support.yourEmail')</label>
                                <input id="email" type="email" name="email" placeholder="@lang('content.support.yourEmailPlaceholder')" class="contact-form_form-group-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="subject" autofocus minlength="3">

                                @error('email')
                                <span class="login-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="contact-form_form-group">
                                <label for="phone" class="contact-form_form-group-label-light">@lang('content.support.yourPhone')</label>
                                <input id="phone" type="text" name="phone" placeholder="@lang('content.support.yourPhonePlaceholder')" class="contact-form_form-group-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required autocomplete="subject" autofocus>

                                @error('phone')
                                <span class="login-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <button type="submit" class="button-secondary">
                                 <span>
                                    @lang('content.support.send')
                                </span>
                            </button>
                        </form>
                </div>


            <div class="info-page_menu-section">
                @include('frontend.chunks.infoSideMenu')
            </div>
        </div>
    </section>

@endsection