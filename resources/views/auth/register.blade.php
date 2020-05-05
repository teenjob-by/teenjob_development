@extends('layouts.frontend')
@section('seo_meta')
    <meta name="description" content="Чтобы оставить объявление, пройдите регистрацию для общественных организаций, инициатив и представителей бизнеса."/>
    <meta name="language" content="RU"/>

    <title>teenjob.by - Зарегистрируйтесь на сайте</title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/entrance.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/entrance.png">
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            var regExpMask = IMask(
                document.getElementById('unique_identifier'),
                {
                    mask: /^[1-9]\d{0,9}$/
                });


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
                        var number = (dynamicMasked.value + appended).replace(/\D/g,'');

                        return dynamicMasked.compiledMasks.find(function (m) {
                            return number.indexOf(m.startsWith) === 0;
                        });
                    }
                }
            );
        });
    </script>
@endsection

@section('content')
<div class="register_section">
    <div class="content-wrapper">
        <h3 class="register_title">@lang('auth.register.title')</h3>
        <p class="register_subtitle">@lang('auth.register.subtitle')</p>

        <form class="register_form" method="POST" action="{{ route('auth.register') }}">
            @csrf

            <h2 class="register_form-title">
                <strong>@lang('auth.register.data')</strong>
            </h2>

            <div class="register_form-group">
                <label for="name" class="register_form-group-label">@lang('auth.register.name')</label>
                <input id="name" type="text" name="name" placeholder="@lang('auth.register.namePlaceholder')" class="register_form-group-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus minlength="3">

                @error('name')
                <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="register_form-group">
                <label for="city" class="register_form-group-label">@lang('auth.register.city')</label>
                <select id="city" class="custom-select register_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autofocus>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>

                @error('city')
                <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="register_form-group">
                <label for="link" class="register_form-group-label">@lang('auth.register.link')</label>
                <input id="link" type="text" name="link" placeholder="@lang('auth.register.linkPlaceholder')" class="register_form-group-input @error('link') is-invalid @enderror" value="{{ old('link') }}" required autocomplete="link" autofocus minlength="3">

                @error('link')
                <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="register_form-group">
                <label for="type" class="register_form-group-label">@lang('auth.register.type')</label>
                <select id="type" class="custom-select register_form-group-select @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required autofocus>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>

                @error('type')
                <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="register_form-group">
                <label for="unique_identifier" class="register_form-group-label">@lang('auth.register.unique_identifier')</label>
                <input id="unique_identifier" type="text" name="unique_identifier" placeholder="@lang('auth.register.unique_identifierPlaceholder')" class="register_form-group-input @error('unique_identifier') is-invalid @enderror" value="{{ old('unique_identifier') }}" required autocomplete="unique_identifier" autofocus minlength="9" maxlength="9">

                @error('unique_identifier')
                <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <h2 class="register_form-title">
                <strong>@lang('auth.register.contactsTitle')</strong>
            </h2>

            <div class="register_form-group">
                <label for="contactPerson" class="register_form-group-label">@lang('auth.register.contactPerson')</label>
                <input id="contactPerson" type="text" name="contactPerson" placeholder="@lang('auth.register.contactPersonPlaceholder')" class="register_form-group-input @error('contactPerson') is-invalid @enderror" value="{{ old('contactPerson') }}" required autocomplete="contactPerson" autofocus minlength="3">

                @error('contactPerson')
                <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="register_form-group">
                <label for="phone" class="register_form-group-label">@lang('auth.register.phone')</label>
                <input id="phone" type="text" name="phone" placeholder="@lang('auth.register.phonePlaceholder')" class="register_form-group-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                @error('phone')
                <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="register_form-group">
                <label for="email" class="register_form-group-label">@lang('auth.register.email')</label>
                <input id="email" type="email" name="email" placeholder="@lang('auth.register.emailPlaceholder')" class="register_form-group-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus minlength="3">

                @error('email')
                <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="register_form-group">
                <label for="password" class="register_form-group-label">@lang('auth.register.password')</label>
                <input id="password" type="password" name="password" placeholder="@lang('auth.register.passwordPlaceholder')" class="register_form-group-input @error('password') is-invalid @enderror" required autofocus minlength="8">
                <i class="show-password" onclick="showPassword('password')"></i>
                @error('password')
                <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="register_form-group">
                <label for="password_confirmation" class="register_form-group-label">@lang('auth.register.password_confirmation')</label>
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="@lang('auth.register.password_confirmationPlaceholder')" class="register_form-group-input @error('password_confirmation') is-invalid @enderror" required autofocus minlength="8">
                <i class="show-password" onclick="showPassword('password_confirmation')"></i>
                @error('password_confirmation')
                <span class="login-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="register_form-group">
                <p class="register_terms">@lang('auth.register.terms')</p>
            </div>

            <div class="register_form-group">
                <button class="button-primary" type="submit">
                        <span>
                            @lang('auth.register.register')
                        </span>
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
