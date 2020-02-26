@extends('layouts.site')

@section('content')
    <div class="container-fluid internship-form">
        <div class="container">
            <div class="row flex-column align-items-center">

                <h2 class="display-5">@lang('content.volunteering.edit.title')</h2>


                <form method="post" action="{{ route('volunteering.update', $volunteering->id) }}">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="organisation" value="{{ $volunteering->organisation_id }}"/>
                    <div class="form-group">
                        <label for="title">@lang('content.volunteering.edit.name')</label>
                        <input type="text" class="form-control" name="title" value="{{ $volunteering->title }}"/>
                    </div>
                    @error('title')
                    <div class="alert alert-danger">{{ $errors->title }}</div>
                    @enderror
                    <div class="form-group">
                        <label class="label-title" for="filter-city">@lang('content.volunteering.edit.city')</label>
                        <select name="city">
                            @foreach($cities as $city)
                                <option {{ ($city->id == $volunteering->city_id)? 'selected': '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-title" for="filter-age">@lang('content.volunteering.edit.age')</label>
                        <select name="age">
                            <option {{ (14 == $volunteering->age)? 'selected': '' }} value="{{ 14 }}">14</option>
                            <option {{ (15 == $volunteering->age)? 'selected': '' }} value="{{ 15 }}">15</option>
                            <option {{ (16 == $volunteering->age)? 'selected': '' }} value="{{ 16 }}">16</option>
                            <option {{ (17 == $volunteering->age)? 'selected': '' }} value="{{ 17 }}">17</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="label-title" for="filter-speciality">@lang('content.volunteering.edit.area')</label>
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
                        <h3 class="title">@lang('content.volunteering.edit.contacts')</h3>
                    </div>

                    <div class="form-group">
                        <label for="contact">@lang('content.volunteering.edit.person')</label>
                        <input type="text" class="form-control" name="contact" value="{{ $volunteering->contact }}"/>
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('content.volunteering.edit.email')</label>
                        <input type="text" class="form-control" name="email" value="{{ $volunteering->email }}"/>
                    </div>
                    <div class="form-group">
                        <label for="phone">@lang('content.volunteering.edit.phone')</label>
                        <input type="text" class="form-control" name="phone" value="{{ $volunteering->phone }}"/>
                    </div>
                    <div class="form-group">
                        <label for="alt_phone">@lang('content.volunteering.edit.addPhone')</label>
                        <input type="text" class="form-control" name="alt_phone" value="{{ $volunteering->alt_phone }}"/>
                    </div>
                    <div class="form-group m-n">
                        <button type="submit" class="btn btn-success">@lang('content.volunteering.edit.moderate')</button>
                    </div>
                    <p class="notification">@lang('content.volunteering.edit.notification')</p>
                </form>

            </div>
        </div>
    </div>
@endsection