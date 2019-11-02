@extends('layouts.app')

@section('content')
    <div class="container-fluid internship-form">
        <div class="container">
            <div class="row flex-column align-items-center">

                <h2 class="display-5">Редактировать объявление</h2>


                <form method="post" action="{{ route('volunteering.update', $volunteering->id) }}">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="organisation" value="{{ $volunteering->organisation_id }}"/>
                    <div class="form-group">
                        <label for="title">Название:</label>
                        <input type="text" class="form-control" name="title" value="{{ $volunteering->title }}"/>
                    </div>
                    @error('title')
                    <div class="alert alert-danger">{{ $errors->title }}</div>
                    @enderror
                    <div class="form-group">
                        <label class="label-title" for="filter-city">Город</label>
                        <select name="city">
                            @foreach($cities as $city)
                                <option {{ ($city->id == $volunteering->city_id)? 'selected': '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-title" for="filter-age">Возраст</label>
                        <select name="age">
                            <option {{ (14 == $volunteering->age)? 'selected': '' }} value="{{ 14 }}">14+</option>
                            <option {{ (15 == $volunteering->age)? 'selected': '' }} value="{{ 15 }}">15+</option>
                            <option {{ (16 == $volunteering->age)? 'selected': '' }} value="{{ 16 }}">16+</option>
                            <option {{ (17 == $volunteering->age)? 'selected': '' }} value="{{ 17 }}">17+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="label-title" for="filter-speciality">Профобласть</label>
                        <select name="speciality">
                            @foreach($specialities as $speciality)
                                <option {{ ($speciality->id == $volunteering->speciality)? 'selected': '' }} value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group texteditor">
                        <textarea name="description" id="summernote">{{ $volunteering->description }}</textarea>
                    </div>
                    <div class="form-group m-n">
                        <h3 class="title">Контакты</h3>
                    </div>

                    <div class="form-group">
                        <label for="contact">Контактное лицо*</label>
                        <input type="text" class="form-control" name="contact" value="{{ $volunteering->contact }}"/>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail*</label>
                        <input type="text" class="form-control" name="email" value="{{ $volunteering->email }}"/>
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон*</label>
                        <input type="text" class="form-control" name="phone" value="{{ $volunteering->phone }}"/>
                    </div>
                    <div class="form-group">
                        <label for="alt_phone">Дополнительный контакт:</label>
                        <input type="text" class="form-control" name="alt_phone" value="{{ $volunteering->alt_phone }}"/>
                    </div>
                    <div class="form-group m-n">
                        <button type="submit" class="btn btn-success">Отправить на модерацию</button>
                    </div>
                    <p class="notification">Будет опубликовано в ближайшее время после прохождения предварительной модерации.</p>
                </form>

            </div>
        </div>
    </div>
@endsection