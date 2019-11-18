@extends('layouts.site')

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

                            <select name="city_id" class="js-select2-basic-single" onchange="getData(getPage())">
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
            <div class="row align-items-start">
                <div class="col-lg-4 filter-non-mobile">
                    <div class="filter-panel">
                        <form method="get" action="{{ route('site.events') }}" id="filter">


                            @if(!empty($_GET['query']))
                                <input type="hidden" name="query" value="{{ $_GET['query'] }}">
                            @endif


                            <div class="form-group">
                                <label class="label-title" for="filter-city">Город</label>
                                <select name="city_id" class="js-select2-basic-single" onchange="getData(getPage())">
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
                                        <input type="checkbox" {{ (!empty($_GET['today']))? 'checked="checked"': '' }} class="overflow-control-input" name="today" onchange="getData(getPage())">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Сегодня</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['tomorrow']))? 'checked="checked"': '' }} class="overflow-control-input" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'tomorrow'))? 'checked="checked"': '' }} name="tomorrow" onchange="getData(getPage())">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Завтра</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['week']))? 'checked="checked"': '' }} class="overflow-control-input" name="week" onchange="getData(getPage())">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">На этой неделе</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['nextweek']))? 'checked="checked"': '' }} class="overflow-control-input" name="nextweek" onchange="getData(getPage())">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">На следующей неделе</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['past']))? 'checked="checked"': '' }} class="overflow-control-input" name="past" onchange="getData(getPage())">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Прошедшие</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['payment']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="payment" onchange="getData(getPage())">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Платно</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['free']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="free" onchange="getData(getPage())">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Бесплатно</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['donate']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="donate" onchange="getData(getPage())">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">За донейт</span>
                                    </label>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="label-title" for="filter-age">Возраст</label>
                                <select name="age" onchange="getData(getPage())" class="select-selectric">

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



                <div class="col-sm-12 col-lg-8 card-wrapper" id="dynWrapper">
                    @if($ajax)
                        <img id="loader" src="/images/loading.svg">
                    @endif
                    @include('presult')
                </div>

            </div>
        </div>
    </div>
@endsection

            @section('pagescript')
                <script>

                    $(window).on('hashchange', function() {
                        if (window.location.hash) {
                            var page = window.location.hash.replace('#', '');
                            if (page == Number.NaN || page <= 0) {
                                return false;
                            }else{
                                getData(page);
                            }
                        }
                    });

                    $(document).ready(function()
                    {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $(document).on('click', '.pagination a',function(event)
                        {
                            event.preventDefault();

                            $('li').removeClass('active');
                            $(this).parent('li').addClass('active');

                            var myurl = $(this).attr('href');
                            var page=$(this).attr('href').split('page=')[1];


                            getData(page);
                        });

                    });

                    function getPage() {
                        var page = window.location.hash.replace('#', '');
                        console.log('hash' + page);
                        return page;
                    }

                    function getData(page){
                        console.log(page);
                        var url = '?page=' + page;

                        var emptyinputs = $('#filter').find('input').filter(function(){
                            return !$.trim(this.value).length;  // get all empty fields
                        }).prop('disabled',true);
                        var emptyselects = $('#filter').find('select').filter(function(){
                            return !$.trim(this.value).length;  // get all empty fields
                        }).prop('disabled',true).selectric('refresh');
                        console.log($('#filter').serialize());
                        url = url + '&' + $('#filter').serialize();

                        var emptyinputs = $('#filter').find('input').prop('disabled',false);
                        var emptyselects = $('#filter').find('select').prop('disabled',false).selectric('refresh');


                        $.ajax(
                            {
                                url: url,
                                type: "get",
                                datatype: "html"
                            }).done(function(data){
                            $("#dynWrapper").empty().html(data);
                            location.hash = page;




                        }).fail(function(jqXHR, ajaxOptions, thrownError){
                                $("#dynWrapper").empty().html("Ничего не найдено(");
                        });
                    }





                </script>
@endsection
