@extends('layouts.frontend')

@section('content')
    <div class="container-fluid internship-form event-form">
        <div class="container">
            <div class="row flex-column align-items-center">

                    <h2 class="display-5">Новое объявление</h2>


                        <form method="post" action="{{ route('events.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="organisation" value="{{ $organisation }}"/>
                            <div class="form-group">
                                <label for="title">Название:</label>
                                <input type="text" class="form-control" name="title"/>
                            </div>
                            @error('title')
                                <div class="alert alert-danger">{{ $errors->title }}</div>
                            @enderror
                            <div class="form-group">
                                <label class="label-title" for="filter-city">Город</label>
                                <select name="city">
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">

                                <label for="date_start">Дата начала</label>
                                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2" id="date_start" name="date_start"/>
                                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>

                                <label for="date_start">Время</label>
                                <div class="input-group time" id="datetimepicker3" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" name="time_start"/>
                                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                    </div>
                                </div>


                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker2').datetimepicker({
                                            locale: 'ru',
                                            minDate: moment(),
                                            format: "DD.MM.YYYY",
                                            allowInputToggle: true
                                        });

                                        $('#datetimepicker3').datetimepicker({
                                            format: 'HH.mm',
                                            allowInputToggle: true
                                        });
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label for="address">Адрес</label>
                                <input type="text" class="form-control" name="address"/>
                            </div>

                            <div class="form-group">
                                <label class="label-title" for="filter-age">Возраст</label>
                                <select name="age">
                                    <option value="14" selected="selected">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label class="label-title" for="filter-speciality">Условия участия</label>
                                <select name="type">
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group texteditor">
                                <textarea name="description" id="summernote"></textarea>
                            </div>

                            <div class="form-group">

                                <label for="event-image">Загрузить обложку*</label>
                                <div class="custom-file">
                                    <label class="custom-file-label" for="event-image">png, jpg, jpeg</label>
                                    <input type="file" class="custom-file-input" name="image" id="event-image" required accept="image/gif, image/jpeg, image/jpg, image/png">
                                    <img id="uploadedimage"/>
                                    <p>
                                        <span id="imageerror" style="font-weight: bold; color: red"></span>
                                    </p>
                                </div>

                            </div>





                            <div class="form-group map" id="map">
                                <!--<div class="mapouter">
                                    <div class="gmap_canvas">
                                        <iframe width="644" height="384" id="gmap_canvas" src="https://maps.google.com/maps?q=minsk&t=&z=11&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                    </div>

                                </div>-->
                            </div>
                            <input type="hidden" name="location" id="event-location">

                            <div class="form-group m-n">
                                <button type="submit" class="btn btn-success">Опубликовать</button>
                            </div>
                            <p class="notification">Будет опубликовано в ближайшее время после прохождения предварительной модерации.</p>
                        </form>

            </div>
        </div>
    </div>
@endsection

@section('pagescript')

    <script>

        function initMap() {


            var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 13, center: {lat: 53.890763, lng: 27.565134}});

            var marker;

            google.maps.event.addListener(map, 'click', function(event) {

                placeMarker(event.latLng);

            });

            function placeMarker(location) {

                if (marker == null)
                {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map
                    });
                    document.getElementById('event-location').setAttribute('value', location);
                }
                else
                {
                    marker.setPosition(location);
                    document.getElementById('event-location').setAttribute('value', location);
                }
            }


            var infoWindow = new google.maps.InfoWindow;

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent('Location found.');
                    infoWindow.open(map);
                    map.setCenter(pos);
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }


            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
                infoWindow.open(map);
            }
        }




    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk-L7v6RJ1QVUtF48zHH8_eY7VWUvtluQ&callback=initMap">
    </script>
@stop