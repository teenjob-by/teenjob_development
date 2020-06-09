@extends('layouts.frontend')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('seo_meta')
    <meta name="description" content="Создание объявления"/>
    <meta name="language" content="RU"/>

    <title>Создание объявления</title>
@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.3/moment.min.js"></script>
    <script src="/js/micromodal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>


        $('#description').summernote({
            placeholder: 'Введите описание',
            tabsize: 2,
            height: 300,
            maxWidth: 543,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

    </script>
    <script>

        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);
                console.log(input.files[0]);

            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }
        $('.image-upload-wrap').bind('dragover', function () {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function () {
            $('.image-upload-wrap').removeClass('image-dropping');
        });


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


        function showModal(name) {

            var modals = {
                success: {
                    content: "@lang('content.event.create.modal.success.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.event.create.modal.success.confirm')",
                            action: function(){
                                location.href = "/organisation#events-for-teens";
                            }
                        },
                    },
                },

                error: {
                    content: "@lang('content.event.create.modal.error.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.event.create.modal.error.confirm')",
                            action: function () {
                                MicroModal.close("modal_error");
                            }
                        },
                    }
                },

                leave: {
                    content: "@lang('content.event.create.modal.leave.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.event.create.modal.leave.confirm')",
                            action: function(){
                                location.href = "{{ url()->previous() }}";
                            }
                        },
                        refuse: {
                            text: "@lang('content.event.create.modal.leave.refuse')",
                            action: function () {
                                MicroModal.close("modal_leave");
                            }
                        },
                    },
                },

                fail: {
                    content: "@lang('content.event.create.modal.fail.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.event.create.modal.fail.confirm')",
                            action: function (name) {

                                MicroModal.close("modal_fail");
                            }
                        },
                    }
                }
            };

            $(".modal").attr("id", "modal_" + name);

            $("#modal-content").empty().append("<p>" + modals[name].content + "</p>");

            $(".modal__footer").empty();
            for (let [key, value] of  Object.entries(modals[name].buttons)) {

                $(".modal__footer").append( '<button class="modal__btn modal__btn-primary" id="modal-' + key + '">' + value.text + '</button>');
                $("#modal-" + key).unbind()
                $("#modal-" + key).bind("click", value.action)
            }

            MicroModal.show("modal_" + name)
        }
        $(document).ready(function () {

            $(window).on('load', function(event) {
                history.pushState("", "");
            });

            $(window).on('popstate', function(e) {
                e.preventDefault()
                showModal("leave")
            });

            $(".back-link").click(function (e) {
                e.preventDefault()
                showModal("leave")
            });

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
            var momentFormat = 'DD/MM/YYYY';
            var dateInputs = document.getElementsByClassName("datePicker");
            for (var i = 0; i < dateInputs.length; i++) {
                new IMask(dateInputs[i], {

                    mask: Date,
                    pattern: momentFormat,
                    lazy: false,
                    min: new Date(1970, 0, 1),
                    max: new Date(2030, 0, 1),

                    format: function (date) {
                        return moment(date).format(momentFormat);
                    },
                    parse: function (str) {
                        return moment(str, momentFormat);
                    },

                    blocks: {
                        YYYY: {
                            mask: IMask.MaskedRange,
                            from: 2000,
                            to: 2030,
                            placeholderChar: '0',
                        },
                        MM: {
                            mask: IMask.MaskedRange,
                            from: 1,
                            to: 12,

                            placeholderChar: '0',
                        },
                        DD: {
                            mask: IMask.MaskedRange,
                            from: 1,
                            to: 31,

                            placeholderChar: '0',
                        }
                    }
                });
            }


            var timeInputs = document.getElementsByClassName("timePicker");
            for (var i = 0; i < timeInputs.length; i++) {
                new IMask(timeInputs[i], {
                    overwrite: true,
                    autofix: true,
                    mask: 'HH:MM',
                    pattern: 'HH:`MM',
                    blocks: {
                        HH: {
                            mask: IMask.MaskedRange,
                            placeholderChar: 'HH',
                            from: 0,
                            to: 23,
                            maxLength: 2
                        },
                        MM: {
                            mask: IMask.MaskedRange,
                            placeholderChar: 'MM',
                            from: 0,
                            to: 59,
                            maxLength: 2
                        }
                    }
                });
            }


            try {

                $('#form').on('submit', function(ev){
                    ev.preventDefault();
                    //showModal("send");

                    callAjax();
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
            var form = $('#form')[0];
            $.ajax(
                {
                    url: '{{ route('organisation.events.store') }}',
                    type: "POST",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    dataType: 'text'
                })
                .done(
                    function(data){

                        data = JSON.parse(data);
                        $("#submit").toggleClass('loading');


                        for (let [key, value] of Object.entries(data)) {

                            if(key == 'message') {
                                showModal('success');
                            }
                            else {
                                showModal('error');
                                $("#" + key).addClass('is-invalid').after(
                                    "<span class=\"message-invalid\" role=\"alert\"><strong>" + value + "</strong></span>" );
                            }
                        }
                    })
                .fail(
                    function(jqXHR, ajaxOptions, thrownError) {
                        showModal('fail');
                        $("#submit").toggleClass('loading');

                    });

        }

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk-L7v6RJ1QVUtF48zHH8_eY7VWUvtluQ&callback=initMap">
    </script>
@endsection


@section('content')

    <section class="event_section">
        <div class="content-wrapper">

            <form id="form" method="POST" class="event_form" action="{{ route('organisation.events.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="event_form-group">
                    <div class="left-aligned">
                        <a class="back-link" href="{{ url()->previous() }}">@lang('content.event.card.back')</a>
                    </div>
                    <div class="right-aligned">
                    </div>

                </div>



                <div class="event_form-group">
                    <div class="centered-title">
                        <div class="inner-icon">
                            <input id="title" required type="text" class="event_form-group-input title-input @error('title') is-invalid @enderror" name="title" placeholder="@lang('content.event.create.name')" value="{{ old('title') }}" autofocus>

                            @error('title')
                            <span class="message-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="event_form-group">
                    <div class="left-aligned">
                        <label for="city" class="event_form-group-label">@lang('content.event.create.city')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="city" class="custom-select-search event_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autofocus>
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
                    </div>
                </div>

                <div class="event_form-group">
                    <div class="left-aligned">
                        <label for="age" class="event_form-group-label">@lang('content.event.create.age')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="age" class="custom-select event_form-group-select @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autofocus>
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
                    </div>
                </div>

                <div class="event_form-group date-group">
                    <div class="left-aligned">
                        <label class="event_form-group-label" for="date_start">@lang('content.event.create.dateStart')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <div class="event_form-date-group">
                                <input type="text" required class="event_form-group-input datePicker" id="date_start" name="date_start" placeholder="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"/>
                            </div>

                            <div class="event_form-date-group time-group">
                                <label for="date_start" class="event_form-group-label">@lang('content.event.create.timeStart')</label>
                                <input required type="text" class="event_form-group-input timePicker" id="time_start" name="time_start" placeholder="{{ \Carbon\Carbon::now()->format('H:i') }}"/>
                            </div>
                        </div>
                    </div>
                </div>


                {{--<div class="event_form-group">
                    <label class="event_form-group-label" for="date_finish">@lang('content.event.create.dateFinish')</label>
                    <div class="event_form-date-group">
                        <input type="text" required class="event_form-group-input datePicker" id="date_finish" name="date_finish"/>
                        <label for="date_finish" class="event_form-group-label">@lang('content.event.create.timeFinish')</label>
                        <input required type="text" class="event_form-group-input timePicker" id="time_finish" name="time_finish"/>
                    </div>
                </div>--}}


                <div class="event_form-group">
                    <div class="left-aligned">
                        <label for="address" class="event_form-group-label">@lang('content.event.create.address')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <input id="address" required type="text" class="event_form-group-input @error('address') is-invalid @enderror" name="address" placeholder="@lang('content.event.create.address')" value="{{ old('address') }}" autofocus>

                            @error('address')
                            <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="event_form-group">
                    <div class="left-aligned">
                        <label for="type" class="event_form-group-label">@lang('content.event.create.type')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="type" class="custom-select event_form-group-select @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required autofocus>
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
                    </div>
                </div>

                <div class="event_form-group">
                    <div class="inner-icon stretch raw-text">
                        <textarea id="description" name="description" type="text" class="event_form-group-input textarea raw-text @error('description') is-invalid @enderror"  name="description" placeholder="@lang('content.event.create.description')" value="{{ old('description') }}"></textarea>

                        @error('description')
                            <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="event_form-group">

                    <div class="centered-title">
                        <div class="inner-icon">
                            <div class="file-upload">
                                <button class="button-secondary" type="button" onclick="$('.file-upload-input').trigger( 'click' )"><span>@lang('content.event.create.loadPreview')</span></button>

                                <div class="image-upload-wrap">
                                    <input class="file-upload-input" type='file' name="image" onchange="readURL(this);" accept="image/jpeg, image/png" />
                                    <div class="drag-text">
                                        <h3>@lang('content.event.create.loadImage')</h3>
                                    </div>
                                </div>
                                <div class="file-upload-content">
                                    <img class="file-upload-image" src="#" alt="your image" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUpload()" class="button-secondary"><span>@lang('content.event.create.removeImage') &nbsp;</span> <span class="image-title">@lang('content.event.create.uploadImage')</span></button>
                                    </div>
                                </div>
                            </div>

                            @error('image')
                                <span class="message-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>




                <div class="event_form-group event_form-map-group">
                    <div class="centered-full">
                        <div class="inner-icon">
                            <p class="map-title">@lang('content.event.create.map')</p>
                            <div class="map" id="map">
                            </div>
                            <input type="hidden" name="location" id="event-location">

                            @error('location')
                            <span class="message-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="volunteering_form-group">
                    <div class="centered">
                        <button id="submit" class="button-account" role="button" type="submit">
                        <span>
                            @lang('content.volunteering.create.save')
                        </span>
                            <div class="loading-icon"></div>
                        </button>
                    </div>
                </div>

                <p class="tip">@lang('content.volunteering.create.notification')</p>

            </form>
        </div>
    </section>


    <div class="modal micromodal-slide" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-title">
                <header class="modal__header">
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-content">
                </main>
                <footer class="modal__footer">
                </footer>
            </div>
        </div>
    </div>




@endsection


