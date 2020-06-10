@extends('layouts.frontend')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection
@section('seo_meta')
    <meta name="description" content="Редактирование объявления"/>
    <meta name="language" content="RU"/>

    <title>Редактирование объявления</title>
@endsection

@section('scripts')
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



        function showModal(name) {

            var modals = {
                success: {
                    content: "@lang('content.internship.update.modal.success.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.internship.update.modal.success.confirm')",
                            action: function(){
                                location.href = "/organisation#internships-for-teens";
                            }
                        },
                    },
                },

                leave: {
                    content: "@lang('content.internship.create.modal.leave.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.internship.create.modal.leave.confirm')",
                            action: function(){
                                location.href = "{{ url()->previous() }}";
                            }
                        },
                        refuse: {
                            text: "@lang('content.internship.create.modal.leave.refuse')",
                            action: function () {
                                MicroModal.close("modal_leave");
                            }
                        },
                    },
                },

                error: {
                    content: "@lang('content.internship.update.modal.error.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.internship.update.modal.error.confirm')",
                            action: function () {
                                MicroModal.close("modal_error");
                            }
                        },
                    }
                },

                fail: {
                    content: "@lang('content.internship.update.modal.fail.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.internship.update.modal.fail.confirm')",
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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#form').on('submit', function(ev){

                    callAjax()
                    return false;
                });

            }catch(e) {
                console.log(e)
            }





            try {
                MicroModal.init();
            }catch (e) {
                console.log(e)
            }

            try {
                var phoneMask = IMask(document.getElementById('phone'), {
                    mask: [
                        {
                            mask: '+000 {00} 000-00-00',
                            startsWith: '375',
                            lazy: false,
                            country: 'Belarus'
                        },
                        {
                            mask: '+0 (000) 000-00-00',
                            startsWith: '7',
                            lazy: false,
                            country: 'Russia'
                        },
                        {
                            mask: '0000000000000',
                            startsWith: '',
                            country: 'unknown'
                        }
                    ],
                    dispatch: function (appended, dynamicMasked) {
                        var number = (dynamicMasked.value + appended).replace(/\D/g,'');

                        return dynamicMasked.compiledMasks.find(function (m) {
                            return number.indexOf(m.startsWith) === 0;
                        });
                    }
                });



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

        });

        function callAjax() {



            $("#submit").toggleClass('loading');

            $.ajax(
                {
                    url: '/organisation/internships/{{ $internship->id }}',
                    type: "PATCH",
                    data: $('#form').serialize(),
                    dataType: 'text'
                })
                .done(
                    function(data){

                        data = JSON.parse(data)
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
@endsection

@section('content')

    <section class="internship_section">
        <div class="content-wrapper">




            <form id="form" method="PATCH"  action="{{ route('organisation.internships.update', $internship->id) }}" class="internship_form">
                @csrf
                @method('PATCH')



                <div class="internship_form-group">
                    <div class="left-aligned">
                        <a class="back-link" href="{{ url()->previous() }}">@lang('content.volunteering.card.back')</a>
                    </div>
                    <div class="right-aligned">
                    </div>
                </div>

                <div class="internship_form-group">
                    <div class="centered">
                        <h3 class="internship_form-title">
                            <strong>@lang('content.internship.update.title')</strong>
                        </h3>
                    </div>
                </div>


                <div class="internship_form-group">
                    <div class="centered-title">
                        <div class="inner-icon">
                            <input id="title" onfocus="this.selectionStart = this.selectionEnd = this.value.length;" required type="text" class="internship_form-group-input title-input @error('title') is-invalid @enderror" name="title" placeholder="@lang('content.internship.update.name')" value="{{ $internship->title }}" autofocus>

                            @error('title')
                            <span class="message-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="internship_form-group">
                    <div class="left-aligned">
                        <label for="city" class="internship_form-group-label">@lang('content.internship.create.city')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="city" class="custom-select-search internship_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ $internship->title }}" required autofocus>
                                @foreach($cities as $city)
                                    <option {{ ($city->id == $internship->city_id)? 'selected': '' }} value="{{ $city->id }}">{{ $city->name }}</option>
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

                <div class="internship_form-group">
                    <div class="left-aligned">
                        <label for="age" class="internship_form-group-label">@lang('content.internship.create.age')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="age" class="custom-select internship_form-group-select @error('age') is-invalid @enderror" name="age" value="{{ $internship->age }}" required autofocus>
                                @foreach($ages as $age)
                                    <option {{ ($age->id == $internship->age)? 'selected': '' }} value="{{ $age->id }}">{{ $age->name }}</option>
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

                {{--<div class="internship_form-group">
                    <div class="left-aligned">
                        <label for="salary" class="internship_form-group-label">@lang('content.internship.create.salary')</label>
                    </div>
                    <div class="right-aligned">

                        <div class="inner-icon">
                            <div class="inline-group">
                                <input id="salary" type="text" class="internship_form-group-input @error('salary') is-invalid @enderror" name="salary" placeholder="@lang('content.internship.create.salaryPlaceholder')" value="{{ $internship->salary }}" autofocus>

                                @error('salary')
                                <span class="message-invalid" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                <select id="salaryType" class="custom-select internship_form-group-select @error('salaryType') is-invalid @enderror" name="salaryType" value="{{$internship->salary_type_id }}" required autofocus>
                                    @foreach($salary_types as $salaryType)
                                        <option {{ ($salaryType->id == $internship->salary_type_id)? 'selected': '' }} value="{{ $salaryType->id }}">{{ $salaryType->name }}</option>
                                    @endforeach
                                </select>

                                @error('salaryType')
                                <span class="message-invalid" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                    </div>
                </div>--}}


                <div class="internship_form-group">
                    <div class="left-aligned">
                        <label for="speciality" class="internship_form-group-label">@lang('content.internship.create.speciality')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="speciality" class="custom-select-search internship_form-group-select @error('speciality') is-invalid @enderror" name="speciality" value="{{ $internship->speciality }}" required autofocus>
                                @foreach($specialities as $speciality)
                                    <option {{ ($speciality->id == $internship->speciality_id)? 'selected': '' }} value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                                @endforeach
                            </select>

                            @error('speciality')
                            <span class="message-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="internship_form-group">
                    <div class="left-aligned">
                        <label for="workTime" class="internship_form-group-label">@lang('content.internship.create.workTime')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="workTime" class="custom-select internship_form-group-select @error('workTime') is-invalid @enderror" name="workTime" value="{{ $internship->work_time_type_id }}" required autofocus>
                                @foreach($work_times as $workTime)
                                    <option {{ ($workTime->id == $internship->work_time_type_id)? 'selected': '' }} value="{{ $workTime->id }}">{{ $workTime->name }}</option>
                                @endforeach
                            </select>

                            @error('orkTime')
                            <span class="message-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="internship_form-group">
                    <div class="inner-icon stretch raw-text">
                        <textarea id="description" name="description" type="text" class="internship_form-group-input textarea raw-text @error('description') is-invalid @enderror"  name="description" placeholder="@lang('content.internship.update.description')" >{{ $internship->description }}</textarea>

                        @error('description')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="internship_form-group">
                    <div class="left-aligned">
                    </div>
                    <div class="right-aligned">
                        <h3 class="internship_form-title">
                            <strong>@lang('content.internship.create.contactsTitle')</strong>
                        </h3>
                    </div>
                </div>

                <div class="internship_form-group">
                    <div class="left-aligned">
                        <label for="contactPerson" class="internship_form-group-label">@lang('content.internship.create.contactPerson')</label>
                    </div>
                    <div class="right-aligned">
                        <input id="contactPerson" type="text" name="contactPerson" placeholder="@lang('content.internship.create.contactPerson')" class="internship_form-group-input @error('contactPerson') is-invalid @enderror"  value="{{ $internship->contact }}" required autocomplete="contactPerson" autofocus>

                        @error('contactPerson')
                        <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="internship_form-group">
                    <div class="left-aligned">
                        <label for="email" class="internship_form-group-label">@lang('content.internship.create.email')</label>
                    </div>
                    <div class="right-aligned">
                        <input id="email" type="email" name="email" placeholder="@lang('content.internship.create.email')" class="internship_form-group-input @error('email') is-invalid @enderror" value="{{ $internship->email }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="internship_form-group">
                    <div class="left-aligned">
                        <label for="phone" class="internship_form-group-label">@lang('content.internship.create.phone')</label>
                    </div>
                    <div class="right-aligned">
                        <input id="phone" type="text" name="phone" placeholder="@lang('content.internship.create.phone')" class="internship_form-group-input @error('phone') is-invalid @enderror" value="{{ $internship->phone }}" required autocomplete="phone" autofocus>

                        @error('phone')
                        <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="internship_form-group">
                    <div class="left-aligned">
                        <label for="alt_phone" class="internship_form-group-label">@lang('content.internship.create.alt_phone')</label>
                    </div>
                    <div class="right-aligned">
                        <input id="alt_phone" type="text" name="alt_phone" placeholder="@lang('content.internship.create.alt_phone')" class="internship_form-group-input @error('alt_phone') is-invalid @enderror" value="{{ $internship->alt_phone }}" autocomplete="alt_phone" autofocus>

                        @error('alt_phone')
                        <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>



                <div class="internship_form-group">
                    <div class="centered">
                        <button id="submit" class="button-account" role="button" type="submit">
                        <span>
                            @lang('content.internship.create.save')
                        </span>
                            <div class="loading-icon"></div>
                        </button>
                    </div>
                </div>



                <p class="tip">@lang('content.internship.create.notification')</p>


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
