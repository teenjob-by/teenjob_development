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
                        <form method="get" >
                            <div class="window-cross" onclick="closeFilter()"><i class="fa fa-times"></i></div>


                            @if(!empty($_GET['query']))
                                <input type="hidden" name="query" value="{{ $_GET['query'] }}">
                            @endif

                            @if(!empty($_GET['city_id']))
                                <input type="hidden" name="city_id" value="{{ $_GET['city_id'] }}">
                            @endif


                            <div class="form-group">
                                <label class="label-title" for="filter-type">@lang('content.offers.search.type')</label>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" class="overflow-control-input" {{ empty($_GET['volunteering'])? '': 'checked="checked"'}} name="volunteering" onchange="getData(getPage(), this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">@lang('content.offers.search.volunteering')</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" class="overflow-control-input" {{ empty($_GET['internship'])? '': 'checked="checked"'}} name="internship" onchange="getData(getPage(), this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">@lang('content.offers.search.internship')</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" class="overflow-control-input" {{ empty($_GET['vacancy'])? '': 'checked="checked"'}} name="vacancy" onchange="getData(getPage(), this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">@lang('content.offers.search.vacancy')</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="label-title" for="filter-speciality">@lang('content.offers.search.area')</label>
                                <select name="speciality" onchange="getData(getPage(), this.form)" class="select-selectric">
                                    <option selected value>@lang('content.offers.search.areas')</option>
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
                                <label class="label-title" for="filter-age">@lang('content.offers.search.age')</label>
                                <select onchange="getData(getPage(), this.form)" class="select-selectric" name="age" >

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
                                <label class="label-title" for="filter-date">@lang('content.offers.search.published')</label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-today" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'today'))? 'checked="checked"': '' }} name="publish_date" value="today" onchange="getData(getPage(), this.form)" >
                                    <label class="custom-control-label" for="date-today">@lang('content.offers.search.today')</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-days" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == '3'))? 'checked="checked"': '' }} name="publish_date" value="3" onchange="getData(getPage(), this.form)">
                                    <label class="custom-control-label" for="date-days">@lang('content.offers.search.threeDays')</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-week" name="publish_date" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'week'))? 'checked="checked"': '' }} value="week" onchange="getData(getPage(), this.form)" >
                                    <label class="custom-control-label" for="date-week">@lang('content.offers.search.week')</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-month" name="publish_date" value="month" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'month'))? 'checked="checked"': '' }} onchange="getData(getPage(), this.form)">
                                    <label class="custom-control-label" for="date-month">@lang('content.offers.search.month')</label>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-sm-12 filter-mobile-compact">

                    <form method="get"  class="filter-panel-compact">


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

                        @if(!empty($_GET['vacancy']))
                            <input type="hidden" name="internship" value="{{ $_GET['vacancy'] }}">
                        @endif
                        <div class="form-group filter-city-mobile">

                            <select name="city_id" class="city-select js-select2-basic-single" onchange="getData(getPage(), this.form)">
                                <option selected value>@lang('content.offers.search.cities')</option>
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
                        <form method="get"  class="filter">

                            @if(!empty($_GET['query']))
                                <input type="hidden" name="query" value="{{ $_GET['query'] }}">
                            @endif

                            <div class="form-group">
                                <label class="label-title" for="filter-city">@lang('content.offers.search.city')</label>
                                <select name="city_id" class="city-select js-select2-basic-single" onchange="getData(getPage(), this.form)" id="cities">

                                </select>
                            </div>

                            <div class="form-group">
                                <label class="label-title" for="filter-type">@lang('content.offers.search.type')</label>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" class="overflow-control-input" {{ empty($_GET['volunteering'])? '': 'checked="checked"'}} name="volunteering" onchange="getData(getPage(), this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">@lang('content.offers.search.volunteering')</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" class="overflow-control-input" {{ empty($_GET['internship'])? '': 'checked="checked"'}} name="internship" onchange="getData(getPage(), this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">@lang('content.offers.search.internship')</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" class="overflow-control-input" {{ empty($_GET['vacancy'])? '': 'checked="checked"'}} name="vacancy" onchange="getData(getPage(), this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">@lang('content.offers.search.vacancy')</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="label-title" for="filter-speciality">@lang('content.offers.search.area')</label>
                                <select name="speciality" onchange="getData(getPage(), this.form)" class="select-selectric" id="specialities">
                                    <option selected value>@lang('content.offers.search.areas')</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label class="label-title" for="filter-age">@lang('content.offers.search.age')</label>
                                <select name="age" onchange="getData(getPage(), this.form)" class="select-selectric">
                                    <option selected value>@lang('content.offers.search.notSelected')</option>
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
                                <label class="label-title" for="filter-date">@lang('content.offers.search.published')</label>


                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-today-non-mobile" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'today'))? 'checked="checked"': '' }} name="publish_date" value="today" onchange="getData(getPage(), this.form)">
                                    <label class="custom-control-label" for="date-today-non-mobile">
                                        @lang('content.offers.search.today')
                                    </label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-days-non-mobile" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == '3'))? 'checked="checked"': '' }} name="publish_date" value="3" onchange="getData(getPage(), this.form)">
                                    <label class="custom-control-label" for="date-days-non-mobile">@lang('content.offers.search.threeDays')</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-week-non-mobile" name="publish_date" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'week'))? 'checked="checked"': '' }} value="week" onchange="getData(getPage(), this.form)">
                                    <label class="custom-control-label" for="date-week-non-mobile">@lang('content.offers.search.week')</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="date-month-non-mobile" name="publish_date" value="month" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'month'))? 'checked="checked"': '' }} onchange="getData(getPage(), this.form)">
                                    <label class="custom-control-label" for="date-month-non-mobile">@lang('content.offers.search.month')</label>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-8" id="dynWrapper">
                    @if($ajax)
                        <img id="loader" src="/images/loading.svg">
                    @endif
                    @include('presultoffers')
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


                        $.get('/cities', function(data) {
                            $('#cities').append(data).selectric();
                        });

                        $.get('/specialities', function(data) {
                            $('#specialities').append(data).selectric();
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

                    function getData(page, filter = $('.filter')){

                        var url = '?page=' + page;

                        var emptyinputs = $(filter).find('input').filter(function(){
                            return !$.trim(this.value).length;  // get all empty fields
                        }).prop('disabled',true);
                        var emptyselects = $(filter).find('select').filter(function(){
                            return !$.trim(this.value).length;  // get all empty fields
                        }).prop('disabled',true).selectric('refresh');

                        url = url + '&' + $(filter).serialize();

                        var emptyinputs = $(filter).find('input').prop('disabled',false);
                        var emptyselects = $(filter).find('select').prop('disabled',false).selectric('refresh');


                        $.ajax(
                            {
                                url: url,
                                type: "get",
                                datatype: "html"
                            }).done(function(data){
                            $("#dynWrapper").empty().html(data);
                            location.hash = page;




                        }).fail(function(jqXHR, ajaxOptions, thrownError){
                            $("#dynWrapper").empty().html("@lang('content.notFound')");
                        });
                    }





                </script>
@endsection
