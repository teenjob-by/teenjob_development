@extends('layouts.site')

@section('content')
    <div class="container-fluid internship-form">
        <div class="container">
            <div class="row flex-column align-items-center">

                    <h2 class="display-5">@lang('content.vacancy.create.title')</h2>


                        <form method="post" action="{{ route('vacancy.store') }}">
                            @csrf
                            <input type="hidden" name="organisation" value="{{ $organisation }}"/>
                            <div class="form-group">
                                <label for="title">@lang('content.vacancy.create.name')</label>
                                <input type="text" required class="form-control" name="title"/>
                            </div>
                            @error('title')
                                <div class="alert alert-danger">{{ $errors->title }}</div>
                            @enderror
                            <div class="form-group">
                                <label class="label-title" for="filter-city">@lang('content.vacancy.create.city')</label>
                                <select name="city" class="js-select2-basic-single">
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="label-title" for="filter-age">@lang('content.vacancy.create.age')</label>
                                <select name="age">
                                    <option value="14" selected="selected">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="label-title" for="filter-speciality">@lang('content.vacancy.create.area')</label>
                                <select name="speciality">
                                    @foreach($specializations as $specialization)
                                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group texteditor">
                                <textarea name="description" id="summernote"></textarea>
                            </div>
                            <div class="form-group m-n">
                                <h3 class="title">@lang('content.vacancy.create.contacts')</h3>
                            </div>

                            <div class="form-group">
                                <label for="contact">@lang('content.vacancy.create.person')</label>
                                <input type="text" required class="form-control" name="contact"/>
                            </div>
                            <div class="form-group">
                                <label for="email">@lang('content.vacancy.create.email')</label>
                                <input type="text" required class="form-control" name="email"/>
                            </div>
                            <div class="form-group">
                                <label for="phone">@lang('content.vacancy.create.phone')</label>
                                <input type="text" required class="form-control" name="phone"/>
                            </div>
                            <div class="form-group">
                                <label for="alt_phone">@lang('content.vacancy.create.addPhone')</label>
                                <input type="text" class="form-control" name="alt_phone"/>
                            </div>
                            <div class="form-group m-n">
                                <button type="submit" class="btn btn-success">@lang('content.vacancy.create.moderate')</button>
                            </div>
                            <p class="notification">@lang('content.vacancy.create.notification')</p>
                        </form>

            </div>
        </div>
    </div>
@endsection
