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

                            <select name="city_id" class="js-select2-basic-single" onchange="getData(this.form)">
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
                                <select name="city_id" class="js-select2-basic-single" onchange="getData(this.form)">
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
                                        <input type="checkbox" {{ (!empty($_GET['today']))? 'checked="checked"': '' }} class="overflow-control-input" name="today" onchange="getData(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Сегодня</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['tomorrow']))? 'checked="checked"': '' }} class="overflow-control-input" {{ ((!empty($_GET['publish_date'])) && ($_GET['publish_date'] == 'tomorrow'))? 'checked="checked"': '' }} name="tomorrow" onchange="getData(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Завтра</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['week']))? 'checked="checked"': '' }} class="overflow-control-input" name="week" onchange="getData(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">На этой неделе</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['nextweek']))? 'checked="checked"': '' }} class="overflow-control-input" name="nextweek" onchange="getData(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">На следующей неделе</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input type="checkbox" {{ (!empty($_GET['past']))? 'checked="checked"': '' }} class="overflow-control-input" name="past" onchange="getData(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Прошедшие</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['payment']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="payment" onchange="getData(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Платно</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['free']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="free" onchange="getData(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">Бесплатно</span>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="custom-control overflow-checkbox">
                                        <input {{ (!empty($_GET['donate']))? 'checked="checked"': '' }} type="checkbox" class="overflow-control-input" name="donate" onchange="getData(this.form)">
                                        <span class="overflow-control-indicator"></span>
                                        <span class="overflow-control-description">За донейт</span>
                                    </label>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="label-title" for="filter-age">Возраст</label>
                                <select name="age" onchange="getData(this.form)" class="select-selectric">

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
            <img id="loader" src="/images/loading.svg">
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

        $(document).ready(function () {

            $(document).on('click', '.pagination a',function(event)
            {
                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var myurl = $(this).attr('href');
                var page=$(this).attr('href').split('page=')[1];

                getData(page);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /*  When user click add user button */
            $('#create-new-user').click(function () {
                $('#btn-save').val("create-user");
                $('#userForm').trigger("reset");
                $('#userCrudModal').html("Add New User");
                $('#ajax-crud-modal').modal('show');
            });




            $.ajax(
                {
                    url: 'eventsDyn?page=' + 1,
                    type: "get"
                }).done(function(data){
                var received = JSON.parse(data);

                $("#dynWrapper").empty();



                function myFunction(item, index) {

                    $('#dynWrapper').append( '<a class="card event-card ' + ((item.status == 2)? "card-overlay" : "") + '" href="/events/' + item.id + '">\
                        <div class="event-header">\
                            <div class="event-time">\
                                <p>' + item.date_start + ', <span>' + item.time_start + '</span></p>\
                            </div>\
                            <img src="' + item.image +'" class="event-card-img" onError="this.onerror=null;this.src=\'/images/noimg.png\';" >\
                        </div>\
                        <p class="event-location">' + item.city_name + '</p>\
                        <h3 class="event-title">' + item.title + '</h3>\
                        <div class="event-description">' + item.description + '</div>\
                    </a>');
                }
                received.data.forEach(myFunction);
                location.hash = 1;
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                alert('No response from server');
            });


            $('body').on('click', '#edit-user', function () {
                var user_id = $(this).data('id');
                $.get('ajax-crud/' + user_id +'/edit', function (data) {
                    $('#userCrudModal').html("Edit User");
                    $('#btn-save').val("edit-user");
                    $('#ajax-crud-modal').modal('show');
                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                })
            });
            //delete user login
            $('body').on('click', '.delete-user', function () {
                var user_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ url('ajax-crud')}}"+'/'+user_id,
                    success: function (data) {
                        $("#user_id_" + user_id).remove();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });
        });

        if ($("#userForm").length > 0) {
            $("#userForm").getData({

                submitHandler: function(form) {

                    var actionType = $('#btn-save').val();
                    $('#btn-save').html('Sending..');

                    $.ajax({
                        data: $('#userForm').serialize(),
                        url: "https://www.tutsmake.com/laravel-example/ajax-crud/store",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            var user = '<tr id="user_id_' + data.id + '"><td>' + data.id + '</td><td>' + data.name + '</td><td>' + data.email + '</td>';
                            user += '<td><a href="javascript:void(0)" id="edit-user" data-id="' + data.id + '" class="btn btn-info">Edit</a></td>';
                            user += '<td><a href="javascript:void(0)" id="delete-user" data-id="' + data.id + '" class="btn btn-danger delete-user">Delete</a></td></tr>';


                            if (actionType == "create-user") {
                                $('#users-crud').prepend(user);
                            } else {
                                $("#user_id_" + data.id).replaceWith(user);
                            }

                            $('#userForm').trigger("reset");
                            $('#ajax-crud-modal').modal('hide');
                            $('#btn-save').html('Save Changes');

                        },
                        error: function (data) {
                            console.log('Error:', data);
                            $('#btn-save').html('Save Changes');
                        }
                    });
                }
            })
        }

        function getData(obj, page) {
            var emptyinputs = $(obj).find('input').filter(function(){
                return !$.trim(this.value).length;  // get all empty fields
            }).prop('disabled',true);
            var emptyselects = $(obj).find('select').filter(function(){
                return !$.trim(this.value).length;  // get all empty fields
            }).prop('disabled',true).selectric('refresh');

            //obj.submit();

            $.ajax(
                {
                    url: 'eventsDyn?page=' + page + '&' + $(obj).serialize(),
                    type: "get"
                }).done(function(data){
                var received = JSON.parse(data);

                $("#dynWrapper").empty();

                function myFunction(item, index) {

                    $('#dynWrapper').append( '<a class="card event-card ' + ((item.status == 2)? "card-overlay" : "") + '" href="/events/' + item.id + '">\
                        <div class="event-header">\
                            <div class="event-time">\
                                <p>' + item.date_start + ', <span>' + item.time_start + '</span></p>\
                            </div>\
                            <img src="' + item.image +'" class="event-card-img" onError="this.onerror=null;this.src=\'/images/noimg.png\';" >\
                        </div>\
                        <p class="event-location">' + item.city_name + '</p>\
                        <h3 class="event-title">' + item.title + '</h3>\
                        <div class="event-description">' + item.description + '</div>\
                    </a>');
                }
                received.data.forEach(myFunction);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                alert('No response from server');
            });
        }
    </script>
@endsection
