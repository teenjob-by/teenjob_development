@extends('layouts.app')

@section('content')
    <div class="container-fluid internship-form">
        <div class="container">
            <div class="row flex-column align-items-center">

                <h2 class="display-5">@lang('content.internship.edit.title')</h2>


                <form method="post" action="{{ route('internship.update', $internship->id) }}">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="organisation" value="{{ $internship->organisation_id }}"/>
                    <div class="form-group">
                        <label for="title">@lang('content.internship.edit.name')</label>
                        <input type="text" class="form-control" name="title" value="{{ $internship->title }}"/>
                    </div>
                    @error('title')
                    <div class="alert alert-danger">{{ $errors->title }}</div>
                    @enderror
                    <div class="form-group">
                        <label class="label-title" for="filter-city">@lang('content.internship.edit.city')</label>
                        <select name="city">
                            @foreach($cities as $city)
                                <option {{ ($city->id == $internship->city_id)? 'selected': '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-title" for="filter-age">@lang('content.internship.edit.age')</label>
                        <select class="select-selectric" name="age">
                            <option {{ (14 == $internship->age)? 'selected': '' }} value="{{ 14 }}">14</option>
                            <option {{ (15 == $internship->age)? 'selected': '' }} value="{{ 15 }}">15</option>
                            <option {{ (16 == $internship->age)? 'selected': '' }} value="{{ 16 }}">16</option>
                            <option {{ (17 == $internship->age)? 'selected': '' }} value="{{ 17 }}">17</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="label-title" for="filter-speciality">@lang('content.internship.edit.area')</label>
                        <select name="speciality">
                            @foreach($specialities as $speciality)
                                <option {{ ($speciality->id == $internship->speciality)? 'selected': '' }} value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group texteditor">
                        <textarea name="description" id="summernote">{{ $internship->description }}</textarea>
                    </div>
                    <div class="form-group m-n">
                        <h3 class="title">@lang('content.internship.edit.contacts')</h3>
                    </div>

                    <div class="form-group">
                        <label for="contact">@lang('content.internship.edit.person')</label>
                        <input type="text" class="form-control" name="contact" value="{{ $internship->contact }}"/>
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('content.internship.edit.email')</label>
                        <input type="text" class="form-control" name="email" value="{{ $internship->email }}"/>
                    </div>
                    <div class="form-group">
                        <label for="phone">@lang('content.internship.edit.phone')</label>
                        <input type="text" class="form-control" name="phone" value="{{ $internship->phone }}"/>
                    </div>
                    <div class="form-group">
                        <label for="alt_phone">@lang('content.internship.edit.addPhone')</label>
                        <input type="text" class="form-control" name="alt_phone" value="{{ $internship->alt_phone }}"/>
                    </div>
                    <div class="form-group m-n">
                        <button type="submit" class="btn btn-success">@lang('content.internship.edit.moderate')</button>
                    </div>
                    <p class="notification">@lang('content.internship.edit.notification')</p>
                </form>

            </div>
        </div>
    </div>
@endsection
