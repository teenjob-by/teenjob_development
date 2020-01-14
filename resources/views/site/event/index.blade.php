@extends('layouts.site')

@section('seo_meta')
    <meta name="description" content="Тренинги, мастер-классы, конференции, дискуссии и другие события для подростков от 14 до 18 лет."/>
    <meta name="language" content="RU"/>
    <meta name="keywords" content="мероприятия в городе, мероприятия сегодня, мероприятия 2019, мероприятия для детей, мероприятия в беларуси, куда сходить">

    <title>Мероприятия для подростков - teenjob.by</title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/main_fb.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/main_vk.png">
@endsection

@section('content')
    <div class="container-fluid events">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 filter-mobile closed">
                    <div class="filter-panel">
                        <div class="window-cross" onclick="closeFilter()"><i class="fa fa-times"></i></div>

                        <form method="get" action="{{ route('site.events') }}">


                            @if(!empty($_GET['query']))
                                <input type="hidden" name="query" value="{{ $_GET['query'] }}">
                            @endif

                                @if(!empty($_GET['city_id']))
                                    <input type="hidden" name="city_id" value="{{ $_GET['city_id'] }}">
                                @endif



                                <div class="form-group">
                                    <label class="label-title" for="filter-type">Состоится</label>
                                    <div class="form-check">
                                        <label class="custom-control overflow-checkbox">
                                            <input type="checkbox" {{ (!empty($_GET['today']))? 'checked="checked"': '' }} class="overflow-control-input" name="today" >
                                            <span class="overflow-control-indicator"></span>
                                            <span class="overflow-control-description">Сегодня</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="custom-control overflow-checkbox">
                                            <input type="checkbox" {{ (!empty($_GET['tomorrow']))? 'checked="checked"': '' }} class="overflow-control-input" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'tomorrow'))? 'checked="checked"': '' }} name="tomorrow" >
                                            <span class="overflow-control-indicator"></span>
                                            <span class="overflow-control-description">Завтра</span>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <label class="custom-control overflow-checkbox">
                                            <input type="checkbox" {{ (!empty($_GET['week']))? 'checked="checked"': '' }} class="overflow-control-input" name="week" >
                                            <span class="overflow-control-indicator"></span>
                                            <span class="overflow-control-description">На этой неделе</span>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <label class="custom-control overflow-checkbox">
                                            <input type="checkbox" {{ (!empty($_GET['nextweek']))? 'checked="checked"': '' }} class="overflow-control-input" name="nextweek" >
                                            <span class="overflow-control-indicator"></span>
                                            <span class="overflow-control-description">На следующей неделе</span>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <label class="custom-control overflow-checkbox">
                                            <input type="checkbox" {{ (!empty($_GET['past']))? 'checked="checked"': '' }} class="overflow-control-input" name="past" >
                                            <span class="overflow-control-indicator"></span>
                                            <span class="overflow-control-description">Прошедшие</span>
                                        </label>
                                    </div>
                                </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['payment']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="payment" >
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Платно</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['free']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="free" >
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Бесплатно</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['donate']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="donate" >
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">За донейт</span>
                                    </label>
                                </div>
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
                                    <button class="btn btn-success" type="submit">Найти</button>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 filter-mobile-compact">

                        <form method="get" action="{{ route('site.events') }}" class="filter-panel-compact">


                            @if(!empty($_GET['query']))
                                <input type="hidden" name="query" value="{{ $_GET['query'] }}">
                            @endif


                            <div class="form-group filter-city-mobile">

                                <select name="city_id" class="js-select2-basic-single" onchange="validate(this.form)">
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
                        <form method="get" action="{{ route('site.events') }}">


                            @if(!empty($_GET['query']))
                                <input type="hidden" name="query" value="{{ $_GET['query'] }}">
                            @endif


                            <div class="form-group">
                                <label class="label-title" for="filter-city">Город</label>
                                <select name="city_id" class="js-select2-basic-single" onchange="validate(this.form)">
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
                                <label class="label-title" for="filter-type">Состоится</label>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['today']))? 'checked="checked"': '' }} class="overflow-control-input" name="today" onchange="validate(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Сегодня</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['tomorrow']))? 'checked="checked"': '' }} class="overflow-control-input" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'tomorrow'))? 'checked="checked"': '' }} name="tomorrow" onchange="validate(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Завтра</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['week']))? 'checked="checked"': '' }} class="overflow-control-input" name="week" onchange="validate(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">На этой неделе</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['nextweek']))? 'checked="checked"': '' }} class="overflow-control-input" name="nextweek" onchange="validate(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">На следующей неделе</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['past']))? 'checked="checked"': '' }} class="overflow-control-input" name="past" onchange="validate(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Прошедшие</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['payment']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="payment" onchange="validate(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Платно</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['free']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="free" onchange="validate(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Бесплатно</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['donate']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="donate" onchange="validate(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">За донейт</span>
                                    </label>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="label-title" for="filter-age">Возраст</label>
                                <select name="age" onchange="validate(this.form)" class="select-selectric">

                                    @foreach($ages as $age)
                                        @isset($_GET['age'])
                                            <option {{ ($age['value'] == $_GET['age'])? 'selected': '' }} value="{{ $age['value'] }}">{{ $age['name'] }}</option>
                                        @else
                                            <option value="{{ $age['value'] }}">{{ $age['name'] }}</option>
                                        @endisset
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-8 card-wrapper">
                    @foreach($events as $event)
                        <a class="card event-card {{ ($event->status == 2)? "card-overlay":"" }}" href="/events/{{$event->id}}">
                            <div class="event-header">
                                <div class="event-time">
                                    <p>{{$event->date_start->format('d.m.Y')}}, <span>{{$event->date_start->format('H:i')}}</span></p>
                                </div>
                                <img src="{{$event->image}}" class="event-card-img">
                            </div>
                            <p class="event-location">{{$event->city->name}}</p>
                            <h3 class="event-title">{{$event->title}}</h3>
                            <div class="event-description">
                                <p>
                                {!!  $event->getPreviewDesc() !!}
                                </p>
                            </div>
                        </a>
                    @endforeach
                        <div class="row justify-content-center paginator">
                            {{ $events->appends($_GET)->links() }}
                        </div>
                </div>
            </div>
        </div>

    </div>


@endsection
