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
                <h3>Добро пожаловать!</h3>
                <p class="subtitle">Зарегистрируйтесь для размещения объявления</p>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2>Данные об организации</h2>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-12 col-lg-5 col-form-label padding-0">Название (офиц.)*</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text"  name="name" placeholder="Название организации" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="city" class="col-sm-12 col-lg-5 col-form-label padding-0">Город*</label>

                                    <div class="col-sm-12 col-lg-7">
                                        <select class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('name') }}" required>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="link" class="col-sm-12 col-lg-5 col-form-label">Сайт/группа в соц. сети</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text" name="link" placeholder="www.hello1everyone.com" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ old('link') }}" required autocomplete="link">

                                        @error('link')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="type" class="col-sm-12 col-lg-5 col-form-label">Тип*</label>
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
                                    <label for="unique_identifier" class="col-sm-12 col-lg-5 col-form-label">УНП*</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text" name="unique_identifier" placeholder="Для проверки статуса организации" class="form-control @error('unique_identifier') is-invalid @enderror" name="unique_identifier" value="{{ old('unique_identifier') }}" required autocomplete="unique_identifier">

                                        @error('unique_identifier')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2>Контактные данные</h2>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact" class="col-sm-12 col-lg-5 col-form-label">Контактное лицо</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text" name="contact" placeholder="Иванов Иван Иванович" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="contact">

                                        @error('contact')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-12 col-lg-5 col-form-label">Телефон*</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text" name="phone" placeholder="375440000000" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-12 col-lg-5 col-form-label">Email*</label>
                                    <div class="col-sm-12 col-lg-7">
                                        <input type="text" name="email" placeholder="yourcompany@domain.com" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" >

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-sm-12 col-lg-5 col-form-label">Пароль*</label>
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
                                    <label for="password_confirmation" class="col-sm-12 col-lg-5 col-form-label">Повторите пароль*</label>
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
                                        <p class="terms">Нажимая “Зарегистрировать организацию” вы подтверждаете согласие с <a href="/terms-of-use">правилами пользования</a>. Согласие на телефонное и/или офлайн интервью с организаторами проекта, при необходимости удостовериться в существовании организации и ее регистрации.</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 offset-lg-5 col-lg-7">
                                        <button class="btn btn-success ml-auto" type="submit" class="btn btn-success">
                                            Зарегистрировать организацию
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
