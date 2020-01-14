@extends('layouts.site')

@section('content')
    <div class="container-fluid offers">

        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="filter-panel">
                        <form method="get" action="{{ route('site.offers') }}">

                            @if(!empty($_GET['query']))
                                <input type="hidden" name="query" value="{{ $_GET['query'] }}">
                            @endif

                            <div class="form-group">
                                <label class="label-title" for="filter-city">Город</label>
                                <select name="city_id" onchange="validate(this.form)">
                                    <option selected value> Все города </option>
                                    @foreach($cities as $city)
                                        @isset($_GET['city_id'])
                                            <option {{ ($city->id == $_GET['city_id'])? 'selected': '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                                        @else
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endisset
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="label-title" for="filter-speciality">Профобласть</label>
                                <select name="speciality" onchange="validate(this.form)">
                                    <option selected value> Все профобласти </option>
                                    @foreach($specialities as $speciality)
                                        @isset($_GET['speciality'])
                                            <option {{ ($speciality->id == $_GET['speciality'])? 'selected': '' }} value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                                        @else
                                            <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                                        @endisset
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="label-title" for="filter-age">Возраст</label>
                                <select name="age" onchange="validate(this.form)">
                                    <option selected value> Не выбрано </option>
                                    @foreach($ages as $age)
                                        @isset($_GET['age'])
                                            <option {{ ($age['value'] == $_GET['age'])? 'selected': '' }} value="{{ $age['value'] }}">{{ $age['name'] }}</option>
                                        @else
                                            <option value="{{ $age['value'] }}">{{ $age['name'] }}</option>
                                        @endisset
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="label-title" for="filter-date">Опубликовано</label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-today" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == '0'))? 'checked="checked"': '' }} name="publish_date" value="0" onchange="validate(this.form)">
                                    <label class="custom-control-label" for="date-today">Сегодня</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-days" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == '3'))? 'checked="checked"': '' }} name="publish_date" value="3" onchange="validate(this.form)">
                                    <label class="custom-control-label" for="date-days">За 3 дня</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-week" name="publish_date" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == '7'))? 'checked="checked"': '' }} value="7" onchange="validate(this.form)">
                                    <label class="custom-control-label" for="date-week">За 7 дней</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-month" name="publish_date" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == '30'))? 'checked="checked"': '' }} value="30" onchange="validate(this.form)">
                                    <label class="custom-control-label" for="date-month">За месяц</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-sm-8">
                    @foreach($offers as $offer)
                        <div class="card mt-3 card-offer">
                            <h3 class="offer-title">
                                <a href="/offer/{{ $offer->id }}">{{$offer->title}}</a>
                                @if($offer->organisation['status'])
                                    <span class="approved"></span>
                                @endif

                                @if($offer->offer_type == 0)
                                    <span class="volunteer-icon"></span>
                                @elseif($offer->offer_type == 1)
                                    <span class="intern-icon"></span>
                                @endif


                            </h3>
                            <h4 class="offer-organisation">{{$offer->organisation['name']}}</h4>
                            <p class="offer-description">{{$offer->description}}</p>

                            <div class="offer-footer">
                                <p class="offer-city">{{$offer->city->name}}</p>
                                <p class="offer-date">{{$offer->published_at->format('j F')}}</p>
                            </div>
                        </div>
                    @endforeach


                    {{ $offers->appends($_GET)->links() }}

                </div>
            </div>
        </div>

    </div>

@endsection