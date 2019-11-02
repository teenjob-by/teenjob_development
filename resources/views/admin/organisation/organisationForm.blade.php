@extends('layouts.app')

@section('content')
    <div class="container-fluid organisation organisation-form">
        <div class="container">

            <form method="POST" action="{{ route('admin.organisation.update') }}">
                @csrf

                <input type="hidden" name="id" value="{{ $organisation->id }}">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3>Править персональную информацию</h3>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-5 col-form-label padding-0">Название</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="name" value="{{ $organisation->name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-sm-5 col-form-label">Тип</label>
                            <div class="col-sm-7">
                                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ $organisation->type }}" required>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}" {{ ($organisation->type == $type->id) ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
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
                            <label for="unique_identifier" class="col-sm-5 col-form-label padding-0">УНП</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control @error('unique_identifier') is-invalid @enderror" name="unique_identifier" value="{{ $organisation->unique_identifier }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link" class="col-sm-5 col-form-label padding-0">Сайт</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ $organisation->link }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unique_identifier" class="col-sm-5 col-form-label padding-0">Контактное лицо</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ $organisation->contact }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-sm-5 col-form-label padding-0">Основной email</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $organisation->email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="link" class="col-sm-5 col-form-label">Дополнительный email</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="alt_email" value="{{ $organisation->alt_email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-5 col-form-label">Телефон*</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $organisation->phone }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="request" class="col-sm-5 col-form-label">Запрос на изменение контактного лица,
                                сайта или email</label>
                            <div class="col-sm-7">
                                <textarea type="text" class="form-control @error('request') is-invalid @enderror " name="request" maxlength="255" placeholder="Укажите:
1. Что и на что нужно изменить.
2. Какова причина?
Запросы без описания причины не будут рассмотрены">{{ $organisation->request }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="offset-sm-3 col-sm-9">
                                <h2>Сменить пароль</h2>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-5 col-form-label">Новый пароль</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control @error('password') is-invalid @enderror " name="password" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-5 col-form-label">Повторите пароль</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror " name="password_confirmation" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <button type="submit" class="btn btn-success mx-auto">Сохранить изменения</button>
                        </div>
                        <div class="form-group row">
                            <a class="mx-auto remove" href="{{ '/organisation/remove/'.$organisation->id }} ">Удалить учетную запись</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection