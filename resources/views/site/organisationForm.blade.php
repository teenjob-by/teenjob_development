@extends('layouts.site')

@section('content')
    <div class="container-fluid organisation organisation-form">
        <div class="container">

            <form method="POST" action="{{ route('update') }}">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3>Править персональную информацию</h3>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-lg-5 col-sm-12 col-form-label padding-0">Основной email</label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="text" readonly style="background-color: #828282;" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $organisation->email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="link" class="col-lg-5 col-sm-12 col-form-label">Дополнительный email</label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="alt_email" value="{{ $organisation->alt_email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-lg-5 col-sm-12 col-form-label">Телефон*</label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $organisation->phone }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="request" class="col-lg-5 col-sm-12 col-form-label">Запрос на изменение контактного лица,
                                сайта или email</label>
                            <div class="col-sm-12 col-lg-7">
                                <textarea type="text" maxlength="250" class="form-control @error('request') is-invalid @enderror " name="request" placeholder="Укажите:
1. Что и на что нужно изменить.
2. Какова причина?
Запросы без описания причины не будут рассмотрены">{{ $organisation->request }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="offset-lg-3 col-lg-9 col-sm-12">
                                <h2>Сменить пароль</h2>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-12 col-lg-5 col-form-label">Новый пароль</label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="password" class="form-control @error('password') is-invalid @enderror " name="password" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-12 col-lg-5 col-form-label">Повторите пароль</label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror " name="password_confirmation" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="tip">Для сохранения изменений введите действующий пароль</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="current_password" class="col-sm-12 col-lg-5 col-form-label"><strong>Действующий пароль*</strong></label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <button type="submit" class="btn btn-success mx-auto">Сохранить изменения</button>
                        </div>
                        <div class="form-group row">
                            <a class="mx-auto remove" onclick='showModal()'>Удалить учетную запись</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="alert" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Удаление учетной записи</h4>
                    <button type="button" class="close" onclick="closeModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Вы действительно хотите удалить учетную запись и все объявления?</p>
                </div>
                <div class="form-group row">
                    <a class="mx-auto remove" href="{{ '/organisation/destroy' }} ">Удалить учетную запись</a>
                </div>
            </div>

        </div>
    </div>
@endsection
