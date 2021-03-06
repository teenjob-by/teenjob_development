@extends('layouts.app')

@section('content')
    <div class="container-fluid internship-form">
        <div class="container">
            <div class="row flex-column align-items-center">

                <h2 class="display-5">@lang('content.job.edit.title')</h2>


                <form method="post" action="{{ route('jobs-for-teens.update', $job->id) }}">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="organisation" value="{{ $job->organisation_id }}"/>
                    <div class="form-group">
                        <label for="title">@lang('content.job.edit.name')</label>
                        <input type="text" class="form-control" name="title" value="{{ $job->title }}"/>
                    </div>
                    @error('title')
                    <div class="alert alert-danger">{{ $errors->title }}</div>
                    @enderror
                    <div class="form-group">
                        <label class="label-title" for="filter-city">@lang('content.job.edit.city')</label>
                        <select name="city">
                            @foreach($cities as $city)
                                <option {{ ($city->id == $job->city_id)? 'selected': '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-title" for="filter-age">@lang('content.job.edit.age')</label>
                        <select name="age">
                            <option {{ (14 == $job->age)? 'selected': '' }} value="{{ 14 }}">14</option>
                            <option {{ (15 == $job->age)? 'selected': '' }} value="{{ 15 }}">15</option>
                            <option {{ (16 == $job->age)? 'selected': '' }} value="{{ 16 }}">16</option>
                            <option {{ (17 == $job->age)? 'selected': '' }} value="{{ 17 }}">17</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="label-title" for="filter-speciality">@lang('content.job.edit.area')</label>
                        <select name="speciality">
                            @foreach($specialities as $speciality)
                                <option {{ ($speciality->id == $job->speciality)? 'selected': '' }} value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group texteditor">
                        <textarea name="description" id="summernote">{{ $job->description }}</textarea>
                    </div>
                    <div class="form-group m-n">
                        <h3 class="title">@lang('content.job.edit.contacts')</h3>
                    </div>

                    <div class="form-group">
                        <label for="contact">@lang('content.job.edit.person')</label>
                        <input type="text" class="form-control" name="contact" value="{{ $job->contact }}"/>
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('content.job.edit.email')</label>
                        <input type="text" class="form-control" name="email" value="{{ $job->email }}"/>
                    </div>
                    <div class="form-group">
                        <label for="phone">@lang('content.job.edit.phone')</label>
                        <input type="text" class="form-control" name="phone" value="{{ $job->phone }}"/>
                    </div>
                    <div class="form-group">
                        <label for="alt_phone">@lang('content.job.edit.addPhone')</label>
                        <input type="text" class="form-control" name="alt_phone" value="{{ $job->alt_phone }}"/>
                    </div>
                    <div class="form-group m-n">
                        <button type="submit" class="btn btn-success">@lang('content.job.edit.moderate')</button>
                    </div>
                    <p class="notification">@lang('content.job.edit.notification')</p>
                </form>

            </div>
        </div>
    </div>
@endsection