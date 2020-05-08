@extends('layouts.frontend')

@section('styles')
    <link rel="stylesheet" href="/js/trumbowyg/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="/js/trumbowyg/plugins/emoji/ui/trumbowyg.emoji.min.css">
    <link rel="stylesheet" href="/js/trumbowyg/plugins/giphy/ui/trumbowyg.giphy.min.css">
@endsection

@section('scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk-L7v6RJ1QVUtF48zHH8_eY7VWUvtluQ&callback=initMap">
    </script>
    <script src="/js/micromodal.min.js"></script>
    <script src="/js/trumbowyg/trumbowyg.min.js"></script>
    <script src="/js/trumbowyg/plugins/fontsize/trumbowyg.fontsize.min.js"></script>
    <script src="/js/trumbowyg/plugins/fontfamily/trumbowyg.fontfamily.min.js"></script>
    <script src="/js/trumbowyg/plugins/allowtagsfrompaste/trumbowyg.allowtagsfrompaste.min.js"></script>
    <script src="/js/trumbowyg/plugins/cleanpaste/trumbowyg.cleanpaste.min.js"></script>
    <script src="/js/trumbowyg/plugins/colors/trumbowyg.colors.min.js"></script>
    <script src="/js/trumbowyg/plugins/emoji/trumbowyg.emoji.min.js"></script>
    <script src="/js/trumbowyg/plugins/giphy/trumbowyg.giphy.min.js"></script>
    <script src="/js/trumbowyg/plugins/history/trumbowyg.history.min.js"></script>
    <script src="/js/trumbowyg/plugins/insertAudio/trumbowyg.insertAudio.min.js"></script>
    <script src="/js/trumbowyg/plugins/lineheight/trumbowyg.lineheight.min.js"></script>
    <script src="/js/trumbowyg/plugins/noembed/trumbowyg.noembed.min.js"></script>
    <script src="/js/trumbowyg/plugins/pasteembed/trumbowyg.pasteembed.min.js"></script>
    <script src="/js/trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.min.js"></script>
    <script type="text/javascript" src="/js/trumbowyg/langs/be.min.js"></script>
    <script type="text/javascript" src="/js/trumbowyg/langs/ru.min.js"></script>

    <script>


        function initMap() {
            console.log("init map");
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


        $('#description').trumbowyg({
            btns: [['strong', 'em',], ['insertImage'], ['foreColor', 'backColor'], ['emoji'], ['fontfamily'], ['fontsize'],['historyUndo', 'historyRedo'],['lineheight'],['noembed'], ],
            autogrow: true,
            lang: 'ru',
        });

        function showModal(name) {

            var modals = {
                remove: {
                    title: "@lang('content.event.modal.remove.title')",
                    content: "@lang('content.event.modal.remove.content')",
                    buttons: {
                        confirm: "@lang('content.event.modal.remove.confirm')",
                        refuse: "@lang('content.event.modal.remove.refuse')"
                    },
                    action: function () {
                        window.location.replace("{{ route('organisation.destroy') }}");
                    }
                },
                send: {
                    title: "@lang('content.event.modal.send.title')",
                    content: "@lang('content.event.modal.send.content')",
                    buttons: {
                        confirm: "@lang('content.event.modal.send.confirm')",
                        refuse: "@lang('content.event.modal.send.refuse')"
                    },
                    action: function () {
                        callAjax()
                    }
                }
            };

            $(".modal").attr("id", "modal_" + name + "_confirmation");
            $("#modal_confirmation-title").empty().append(modals[name].title);
            $("#modal_confirmation-content").empty().append("<p>" + modals[name].content + "</p>");
            $("#modal_confirmation-confirm").empty().append(modals[name].buttons.confirm);
            $("#modal_confirmation-refuse").empty().append(modals[name].buttons.refuse);
            $("#modal_confirmation-confirm").unbind('click');             $("#modal_confirmation-confirm").click( function (e) {
                MicroModal.close("modal_" + name + "_confirmation")
                modals[name].action();
            });

            MicroModal.show("modal_" + name + "_confirmation")
        }
        $(document).ready(function () {

            try {
                MicroModal.init();
            }catch (e) {
                console.log(e)
            }





            function clearErrors() {
                try {
                    $(".operation-result").removeClass('show');
                    $(".operation-result").empty();

                    $(".is-invalid").removeClass('is-invalid');
                    $('.message-invalid').remove();

                }catch (e) {
                    console.log(e)
                }
            }


            try {

                $('#form').on('submit', function(ev){
                    ev.preventDefault();
                    showModal("send");
                });

            }catch(e) {
                console.log(e)
            }
        });

        function callAjax() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#submit").toggleClass('loading');

            $.ajax(
                {
                    url: '{{ route('organisation.events.store') }}',
                    type: "POST",
                    data: $('#form').serialize(),
                    dataType: 'text'
                })
                .done(
                    function(data){

                        data = JSON.parse(data);
                        $("#submit").toggleClass('loading');

                        for (var prop in data) {
                            $(".operation-result").append(prop.va);
                        }

                        for (let [key, value] of Object.entries(data)) {

                            if(key == 'message') {
                                $(".operation-result").toggleClass('show');
                                $(".operation-result").empty().append(value);
                            }
                            else {
                                $("#" + key).addClass('is-invalid').after(
                                    "<span class=\"message-invalid\" role=\"alert\"><strong>" + value + "</strong></span>" );
                            }
                        }
                    })
                .fail(
                    function(jqXHR, ajaxOptions, thrownError) {

                        $(".operation-result").toggleClass('show');
                        $(".operation-result").empty().append("Сохранение не удалось");
                        $("#submit").toggleClass('loading');

                    });

        }


        /*$(function () {
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
*/
    </script>
@endsection


@section('content')

    <section class="event_section">
        <div class="content-wrapper">


            <form id="form" method="POST" class="event_form" action="{{ route('organisation.events.store') }}" enctype="multipart/form-data">
                @csrf

                <h3 class="event_form-title">
                    <strong>@lang('content.event.create.title')</strong>
                </h3>

                <div class="event_form-group">
                    <label for="title" class="event_form-group-label">@lang('content.event.create.title')</label>
                    <input id="title" required type="text" class="event_form-group-input @error('title') is-invalid @enderror" name="title" placeholder="@lang('content.event.create.titlePlaceholder')" minlength="3" value="{{ old('title') }}" autofocus>

                    @error('title')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="event_form-group">
                    <label for="city" class="event_form-group-label">@lang('content.event.create.city')</label>
                    <select id="city" class="custom-select event_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autofocus>
                        <option selected value>@lang('content.event.create.cityPlaceholder')</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>

                    @error('city')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="event_form-group">
                    <label for="age" class="event_form-group-label">@lang('content.event.create.age')</label>
                    <select id="age" class="custom-select event_form-group-select @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autofocus>
                        <option selected value>@lang('content.event.create.agePlaceholder')</option>
                        @foreach($ages as $age)
                            <option value="{{ $age->id }}">{{ $age->name }}</option>
                        @endforeach
                    </select>

                    @error('age')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="event_form-group">
                    <label class="event_form-group-label" for="date_start">@lang('content.event.create.dateStart')</label>
                    <div class="event_form-date-group">
                        <input type="text" required class="event_form-group-input datePicker"id="date_start" name="date_start"/>
                        <label for="date_start" class="event_form-group-label">@lang('content.event.create.timeStart')</label>
                        <input required type="text" class="event_form-group-input timePicker" name="time_start"/>
                    </div>
                </div>

                <div class="event_form-group">
                    <label for="address" class="event_form-group-label">@lang('content.event.create.address')</label>
                    <input id="address" required type="text" class="event_form-group-input @error('address') is-invalid @enderror" name="address" placeholder="@lang('content.event.create.addressPlaceholder')" minlength="3" value="{{ old('address') }}" autofocus>

                    @error('address')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="event_form-group">
                    <label for="type" class="event_form-group-label">@lang('content.event.create.type')</label>
                    <select id="type" class="custom-select event_form-group-select @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required autofocus>
                        <option selected value>@lang('content.event.create.typePlaceholder')</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>

                    @error('type')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="event_form-group description">
                    <label for="description" class="event_form-group-label">@lang('content.event.create.description')</label>
                    <textarea id="description" name="description" required minlength="20" type="text" class="event_form-group-input textarea @error('description') is-invalid @enderror"  name="description" placeholder="@lang('content.event.create.descriptionPlaceholder')" value="{{ old('description') }}"></textarea>

                    @error('description')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>



                <div class="event_form-group">
                    <label for="event-image">@lang('content.event.create.loadPreview')</label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="event-image">png, jpg, jpeg</label>
                        <input type="file" class="custom-file-input" value="{{ old('image') }}" name="image" id="event-image" required accept="image/gif, image/jpeg, image/jpg, image/png">
                        <img id="uploadedimage"/>
                        <p>
                            <span id="imageerror" style="font-weight: bold; color: red"></span>
                        </p>
                    </div>
                </div>

                <div class="event_form-group event_form-map-group">
                    <p class="map-title">@lang('content.event.create.map')</p>
                    <div class="map" id="map">
                    </div>
                    <input type="hidden" name="location" id="event-location">
                </div>

                <div class="event_form-group">
                    <button id="submit" class="button-secondary" role="button" type="submit">
                        <span>
                            @lang('content.event.create.save')
                        </span>
                        <div class="loading-icon"></div>
                    </button>
                </div>
                <div class="content-loader"></div>
                <p class="operation-result">
                </p>

                <p class="tip">@lang('content.event.create.notification')</p>

            </form>
        </div>
    </section>


    <div class="modal micromodal-slide" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal_confirmation-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal_confirmation-title">
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal_confirmation-content">
                </main>
                <footer class="modal__footer">
                    <button class="modal__btn modal__btn-primary" id="modal_confirmation-confirm"></button>
                    <button class="modal__btn" id="modal_confirmation-refuse" data-micromodal-close aria-label="Close this dialog window"></button>
                </footer>
            </div>
        </div>
    </div>




@endsection


