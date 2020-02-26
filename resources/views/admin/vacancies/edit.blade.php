@extends('layouts.site')

@section('content')
    <div class="container-fluid internship-form">
        <div class="container">
            <div class="row flex-column align-items-center">

                <h2 class="display-5">@lang('content.vacancy.edit.title')</h2>


                <form method="post" action="{{ route('vacancy.update', $vacancy->id) }}">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="organisation" value="{{ $vacancy->organisation_id }}"/>
                    <div class="form-group">
                        <label for="title">@lang('content.vacancy.edit.name')</label>
                        <input type="text" class="form-control" name="title" value="{{ $vacancy->title }}"/>
                    </div>
                    @error('title')
                    <div class="alert alert-danger">{{ $errors->title }}</div>
                    @enderror
                    <div class="form-group">
                        <label class="label-title" for="filter-city">@lang('content.vacancy.edit.city')</label>
                        <select name="city">
                            @foreach($cities as $city)
                                <option {{ ($city->id == $vacancy->city_id)? 'selected': '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-title" for="filter-age">@lang('content.vacancy.edit.age')</label>
                        <select name="age">
                            <option {{ (14 == $vacancy->age)? 'selected': '' }} value="{{ 14 }}">14</option>
                            <option {{ (15 == $vacancy->age)? 'selected': '' }} value="{{ 15 }}">15</option>
                            <option {{ (16 == $vacancy->age)? 'selected': '' }} value="{{ 16 }}">16</option>
                            <option {{ (17 == $vacancy->age)? 'selected': '' }} value="{{ 17 }}">17</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="label-title" for="filter-speciality">@lang('content.vacancy.edit.area')</label>
                        <select name="speciality">
                            @foreach($specialities as $speciality)
                                <option {{ ($speciality->id == $vacancy->speciality)? 'selected': '' }} value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group texteditor">
                        <textarea name="description" id="summernote">{{ $vacancy->description }}</textarea>
                    </div>
                    <div class="form-group m-n">
                        <h3 class="title">@lang('content.vacancy.edit.contacts')</h3>
                    </div>

                    <div class="form-group">
                        <label for="contact">@lang('content.vacancy.edit.person')</label>
                        <input type="text" class="form-control" name="contact" value="{{ $vacancy->contact }}"/>
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('content.vacancy.edit.email')</label>
                        <input type="text" class="form-control" name="email" value="{{ $vacancy->email }}"/>
                    </div>
                    <div class="form-group">
                        <label for="phone">@lang('content.vacancy.edit.phone')</label>
                        <input type="text" class="form-control" name="phone" value="{{ $vacancy->phone }}"/>
                    </div>
                    <div class="form-group">
                        <label for="alt_phone">@lang('content.vacancy.edit.addPhone')</label>
                        <input type="text" class="form-control" name="alt_phone" value="{{ $vacancy->alt_phone }}"/>
                    </div>
                    <div class="form-group m-n">
                        <button type="submit" class="btn btn-success">@lang('content.vacancy.edit.moderate')</button>
                    </div>
                    <p class="notification">@lang('content.vacancy.edit.notification')</p>
                </form>

            </div>
        </div>
    </div>
@endsection