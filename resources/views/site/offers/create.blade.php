@extends('layouts.site')

@section('content')
    <div class="container offer">
        <div class="row">
            <div class="col-sm-8 offset-sm-2">
                <h2 class="display-5">Новое объявление</h2>

                <div>

                    <form method="post" action="{{ route('offers.store') }}">
                        @csrf
                        <input type="hidden" name="organisation" value="{{ $organisation }}"/>
                        <div class="form-group">
                            <label for="title">Название:</label>
                            <input type="text" class="form-control" name="title"  required/>
                        </div>
                        @error('title')
                            <div class="alert alert-danger">{{ $errors->title }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="city">Город:</label>
                            <input type="text" class="form-control" name="city"  required/>
                        </div>

                        <div class="form-group">
                            <label for="age">Возраст от:</label>
                            <input type="text" class="form-control" name="age" required/>
                        </div>
                        <div class="form-group">
                            <label for="specialization">Профобласть</label>
                            <input type="text" class="form-control" name="speciality"  required/>
                        </div>
                        <div class="form-group">
                            <label for="type">Категория:</label>
                            <input type="text" class="form-control" name="type"  required/>
                        </div>
                        <div class="form-group">
                            <label for="description">Описание:</label>
                            <textarea rows="5" type="text" class="form-control" name="description"  required>
                                <p><strong>Описание</strong></p>
                                <p><strong>Условия</strong></p>
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="contact">Контактное лицо:</label>
                            <input type="text" class="form-control" name="contact"  required/>
                        </div>
                        <div class="form-group">
                            <label for="email">EMail:</label>
                            <input type="text" class="form-control" name="email"  required/>
                        </div>
                        <div class="form-group">
                            <label for="phone">Тел:</label>
                            <input type="text" class="form-control" name="phone"  required/>
                        </div>
                        <div class="form-group">
                            <label for="alt_phone">Доп. тел.:</label>
                            <input type="text" class="form-control" name="alt_phone"/>
                        </div>
                        <button type="submit" class="btn btn-primary-outline">Отправить на модерацию</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection