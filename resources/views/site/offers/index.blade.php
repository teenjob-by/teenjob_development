@extends('layouts.site')

@section('seo_meta')
    <meta name="description" content="Вакансии волонтерства и стажировок для тех, кому от 14 до 18 лет."/>
    <meta name="language" content="RU"/>

    <title>Вакансии для подростков - teenjob.by</title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/main_fb.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/main_vk.png">
@endsection

@section('content')
    <div class="container-fluid offers">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 filter-mobile closed">
                    <div class="filter-panel">
                        <form method="get" action="{{ route('site.offers') }}">
                            <div class="window-cross" onclick="closeFilter()"><i class="fa fa-times"></i></div>


                            @if(!empty($_GET['query']))
                                <input type="hidden" name="query" value="{{ $_GET['query'] }}">
                            @endif

                                @if(!empty($_GET['city_id']))
                                    <input type="hidden" name="city_id" value="{{ $_GET['city_id'] }}">
                                @endif


                                <div class="form-group">
                                    <label class="label-title" for="filter-type">Вид деятельности</label>
                                    <div class="form-check">
                                        <label class="custom-control overflow-checkbox">
                                            <input type="checkbox" class="overflow-control-input" {{ empty($_GET['volunteering'])? '': 'checked="checked"'}} name="volunteering" onchange="validate(this.form)">
                                            <span class="overflow-control-indicator"></span>
                                            <span class="overflow-control-description">Волонтерство</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="custom-control overflow-checkbox">
                                            <input type="checkbox" class="overflow-control-input" {{ empty($_GET['internship'])? '': 'checked="checked"'}} name="internship" onchange="validate(this.form)">
                                            <span class="overflow-control-indicator"></span>
                                            <span class="overflow-control-description">Стажировка</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="label-title" for="filter-speciality">Профобласть</label>
                                    <select name="speciality" class="select-selectric">
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
                                    <select class="select-selectric" name="age" >

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
                                        <input type="radio" class="custom-control-input" id="date-today" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'today'))? 'checked="checked"': '' }} name="publish_date" value="today" >
                                        <label class="custom-control-label" for="date-today">Сегодня</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="date-days" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == '3'))? 'checked="checked"': '' }} name="publish_date" value="3" >
                                        <label class="custom-control-label" for="date-days">За 3 дня</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="date-week" name="publish_date" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'week'))? 'checked="checked"': '' }} value="week" >
                                        <label class="custom-control-label" for="date-week">За 7 дней</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="date-month" name="publish_date" value="month" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'month'))? 'checked="checked"': '' }} >
                                        <label class="custom-control-label" for="date-month">За месяц</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success" onclick="validate(this.form)">Найти</button>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 filter-mobile-compact">

                    <form method="get" action="{{ route('site.offers') }}" class="filter-panel-compact">


                        @if(!empty($_GET['query']))
                            <input type="hidden" name="query" value="{{ $_GET['query'] }}">
                        @endif

                            @if(!empty($_GET['publish_date']))
                                <input type="hidden" name="publish_date" value="{{ $_GET['publish_date'] }}">
                            @endif

                            @if(!empty($_GET['age']))
                                <input type="hidden" name="age" value="{{ $_GET['age'] }}">
                            @endif

                            @if(!empty($_GET['speciality']))
                                <input type="hidden" name="speciality" value="{{ $_GET['speciality'] }}">
                            @endif

                            @if(!empty($_GET['volunteering']))
                                <input type="hidden" name="volunteering" value="{{ $_GET['volunteering'] }}">
                            @endif

                            @if(!empty($_GET['internship']))
                                <input type="hidden" name="internship" value="{{ $_GET['internship'] }}">
                            @endif
                        <div class="form-group filter-city-mobile">

                            <select name="city_id" class="city-select js-select2-basic-single" onchange="validate(this.form)">
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
                            <div class="filter-button" onclick="openFilter()">
                            </div>
                    </form>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 filter-non-mobile">
                    <div class="filter-panel">
                        <form method="get" action="{{ route('site.offers') }}">

                            @if(!empty($_GET['query']))
                                <input type="hidden" name="query" value="{{ $_GET['query'] }}">
                            @endif

                            <div class="form-group">
                                <label class="label-title" for="filter-city">Город</label>
                                <select name="city_id" class="city-select js-select2-basic-single" onchange="validate(this.form)">
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
                                <label class="label-title" for="filter-type">Вид деятельности</label>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" class="overflow-control-input" {{ empty($_GET['volunteering'])? '': 'checked="checked"'}} name="volunteering" onchange="validate(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Волонтерство</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" class="overflow-control-input" {{ empty($_GET['internship'])? '': 'checked="checked"'}} name="internship" onchange="validate(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Стажировка</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="label-title" for="filter-speciality">Профобласть</label>
                                <select name="speciality" onchange="validate(this.form)" class="select-selectric">
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
                                <select name="age" onchange="validate(this.form)" class="select-selectric">
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
                                    <input type="radio" class="custom-control-input" id="date-today" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'today'))? 'checked="checked"': '' }} name="publish_date" value="today" onchange="validate(this.form)">
                                    <label class="custom-control-label" for="date-today">Сегодня</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-days" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == '3'))? 'checked="checked"': '' }} name="publish_date" value="3" onchange="validate(this.form)">
                                    <label class="custom-control-label" for="date-days">За 3 дня</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-week" name="publish_date" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'week'))? 'checked="checked"': '' }} value="week" onchange="validate(this.form)">
                                    <label class="custom-control-label" for="date-week">За 7 дней</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-month" name="publish_date" value="month" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'month'))? 'checked="checked"': '' }} onchange="validate(this.form)">
                                    <label class="custom-control-label" for="date-month">За месяц</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-8">
                    @foreach($offers as $offer)
                        <div class="card mt-3 card-offer">
                            <h3 class="offer-title">
                                <a href="{{ '/'.($offer->offer_type?'internship':'volunteering').'/'.$offer->id }}">{{$offer->title}}</a>
                                @if(false)
                                    <span class="approved"></span>
                                @endif
                                @if($offer->offer_type == 0)
                                    <span class="volunteer-icon"></span>
                                @elseif($offer->offer_type == 1)
                                    <span class="intern-icon"></span>
                                @endif
                            </h3>
                            <h4 class="offer-organisation"><a href="{{ $offer->organisation['link'] }}" target="_blank">{{$offer->organisation['name']}}</a></h4>
                            <div class="offer-description">{!! $offer->getPreviewDesc() !!}</div>

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
