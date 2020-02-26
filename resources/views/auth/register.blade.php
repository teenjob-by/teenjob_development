@extends('layouts.site')
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

@section('content')
<div class="container-fluid register">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0">
                <h3>@lang('auth.register.title')</h3>
                <p class="subtitle">@lang('auth.register.subtitle')</p>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2>@lang('auth.register.data')</h2>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-12 col-lg-5 col-form-label padding-0">@lang('auth.register.name')</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text"  name="name" placeholder="@lang('auth.register.namePlaceholder')" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!--<div class="form-group row">
                                    <label for="city" class="col-sm-12 col-lg-5 col-form-label padding-0">Город*</label>

                                    <div class="col-sm-12 col-lg-7">
                                        <select class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('name') }}" required>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>-->

                                <div class="form-group row">
                                    <label for="link" class="col-sm-12 col-lg-5 col-form-label">@lang('auth.register.site')</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text" name="link" placeholder="@lang('auth.register.sitePlaceholder')" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ old('link') }}" required autocomplete="link">

                                        @error('link')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="type" class="col-sm-12 col-lg-5 col-form-label">@lang('auth.register.type')</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type') }}" required>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="unique_identifier" class="col-sm-12 col-lg-5 col-form-label">@lang('auth.register.UNP')</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text" name="unique_identifier" placeholder="@lang('auth.register.UNPPlaceholder')" class="form-control @error('unique_identifier') is-invalid @enderror" name="unique_identifier" value="{{ old('unique_identifier') }}" required autocomplete="unique_identifier">

                                        @error('unique_identifier')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2>@lang('auth.register.contactsTitle')</h2>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact" class="col-sm-12 col-lg-5 col-form-label">@lang('auth.register.contactPerson')</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text" name="contact" placeholder="@lang('auth.register.contactPersonPlaceholder')" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="contact">

                                        @error('contact')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-12 col-lg-5 col-form-label">@lang('auth.register.phone')</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text" name="phone" placeholder="@lang('auth.register.phonePlaceholder')" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-12 col-lg-5 col-form-label">@lang('auth.register.email')</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text" name="email" placeholder="@lang('auth.register.emailPlaceholder')" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" >

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-sm-12 col-lg-5 col-form-label">@lang('auth.register.password')</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required >

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-sm-12 col-lg-5 col-form-label">@lang('auth.register.additionalPhone')</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required >

                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 offset-lg-5 col-lg-7">
                                        <p class="terms">@lang('auth.register.terms')</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 offset-lg-5 col-lg-7">
                                        <button class="btn btn-success ml-auto" type="submit" class="btn btn-success">
                                            @lang('auth.register.register')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
