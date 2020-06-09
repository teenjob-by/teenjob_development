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
                    content: "@lang('content.volunteering.update.modal.success.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.volunteering.update.modal.success.confirm')",
                            action: function(){
                                location.href = "/organisation#volunteerings-for-teens";
                            }
                        },
                    },
                },

                leave: {
                    content: "@lang('content.volunteering.create.modal.leave.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.volunteering.create.modal.leave.confirm')",
                            action: function(){
                                location.href = "{{ url()->previous() }}";
                            }
                        },
                        refuse: {
                            text: "@lang('content.volunteering.create.modal.leave.refuse')",
                            action: function () {
                                MicroModal.close("modal_leave");
                            }
                        },
                    },
                },

                error: {
                    content: "@lang('content.volunteering.update.modal.error.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.volunteering.update.modal.error.confirm')",
                            action: function () {
                                MicroModal.close("modal_error");
                            }
                        },
                    }
                },

                fail: {
                    content: "@lang('content.volunteering.update.modal.fail.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.volunteering.update.modal.fail.confirm')",
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
                    url: '/organisation/volunteerings/{{ $volunteering->id }}',
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

    <section class="volunteering_section">
        <div class="content-wrapper">




            <form id="form" method="PATCH"  action="{{ route('organisation.volunteerings.update', $volunteering->id) }}" class="volunteering_form">
                @csrf
                @method('PATCH')



                <div class="volunteering_form-group">
                    <div class="left-aligned">
                        <a class="back-link" href="{{ url()->previous() }}">@lang('content.volunteering.card.back')</a>
                    </div>
                    <div class="right-aligned">
                    </div>
                </div>

                <div class="volunteering_form-group">
                    <div class="centered">
                        <h3 class="volunteering_form-title">
                            <strong>@lang('content.volunteering.update.title')</strong>
                        </h3>
                    </div>
                </div>


                <div class="volunteering_form-group">
                    <div class="centered-title">
                        <div class="inner-icon">
                            <input id="title" required type="text" class="volunteering_form-group-input title-input @error('title') is-invalid @enderror" name="title" placeholder="@lang('content.volunteering.update.name')" value="{{ $volunteering->title }}" autofocus>

                            @error('title')
                            <span class="message-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="volunteering_form-group">
                    <div class="left-aligned">
                        <label for="city" class="volunteering_form-group-label">@lang('content.volunteering.create.city')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="city" class="custom-select-search volunteering_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ $volunteering->title }}" required autofocus>
                                @foreach($cities as $city)
                                    <option {{ ($city->id == $volunteering->city_id)? 'selected': '' }} value="{{ $city->id }}">{{ $city->name }}</option>
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

                <div class="volunteering_form-group">
                    <div class="left-aligned">
                        <label for="age" class="volunteering_form-group-label">@lang('content.volunteering.create.age')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="age" class="custom-select volunteering_form-group-select @error('age') is-invalid @enderror" name="age" value="{{ $volunteering->age }}" required autofocus>
                                @foreach($ages as $age)
                                    <option {{ ($age->id == $volunteering->age)? 'selected': '' }} value="{{ $age->id }}">{{ $age->name }}</option>
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

                {{--<div class="volunteering_form-group">
                    <div class="left-aligned">
                        <label for="salary" class="volunteering_form-group-label">@lang('content.volunteering.create.salary')</label>
                    </div>
                    <div class="right-aligned">

                        <div class="inner-icon">
                            <div class="inline-group">
                                <input id="salary" type="text" class="volunteering_form-group-input @error('salary') is-invalid @enderror" name="salary" placeholder="@lang('content.volunteering.create.salaryPlaceholder')" value="{{ $volunteering->salary }}" autofocus>

                                @error('salary')
                                <span class="message-invalid" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                <select id="salaryType" class="custom-select volunteering_form-group-select @error('salaryType') is-invalid @enderror" name="salaryType" value="{{$volunteering->salary_type_id }}" required autofocus>
                                    @foreach($salary_types as $salaryType)
                                        <option {{ ($salaryType->id == $volunteering->salary_type_id)? 'selected': '' }} value="{{ $salaryType->id }}">{{ $salaryType->name }}</option>
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


                <div class="volunteering_form-group">
                    <div class="left-aligned">
                        <label for="speciality" class="volunteering_form-group-label">@lang('content.volunteering.create.speciality')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="speciality" class="custom-select-search volunteering_form-group-select @error('speciality') is-invalid @enderror" name="speciality" value="{{ $volunteering->speciality }}" required autofocus>
                                @foreach($specialities as $speciality)
                                    <option {{ ($speciality->id == $volunteering->speciality_id)? 'selected': '' }} value="{{ $speciality->id }}">{{ $speciality->name }}</option>
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

                <div class="volunteering_form-group">
                    <div class="left-aligned">
                        <label for="workTime" class="volunteering_form-group-label">@lang('content.volunteering.create.workTime')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="workTime" class="custom-select volunteering_form-group-select @error('workTime') is-invalid @enderror" name="workTime" value="{{ $volunteering->work_time_type_id }}" required autofocus>
                                @foreach($work_times as $workTime)
                                    <option {{ ($workTime->id == $volunteering->work_time_type_id)? 'selected': '' }} value="{{ $workTime->id }}">{{ $workTime->name }}</option>
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


                <div class="volunteering_form-group">
                    <div class="inner-icon stretch raw-text">
                        <textarea id="description" name="description" type="text" class="volunteering_form-group-input textarea raw-text @error('description') is-invalid @enderror"  name="description" placeholder="@lang('content.volunteering.update.description')" >{{ $volunteering->description }}</textarea>

                        @error('description')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="volunteering_form-group">
                    <div class="left-aligned">
                    </div>
                    <div class="right-aligned">
                        <h3 class="volunteering_form-title">
                            <strong>@lang('content.volunteering.create.contactsTitle')</strong>
                        </h3>
                    </div>
                </div>

                <div class="volunteering_form-group">
                    <div class="left-aligned">
                        <label for="contactPerson" class="volunteering_form-group-label">@lang('content.volunteering.create.contactPerson')</label>
                    </div>
                    <div class="right-aligned">
                        <input id="contactPerson" type="text" name="contactPerson" placeholder="@lang('content.volunteering.create.contactPerson')" class="volunteering_form-group-input @error('contactPerson') is-invalid @enderror"  value="{{ $volunteering->contact }}" required autocomplete="contactPerson" autofocus>

                        @error('contactPerson')
                        <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="volunteering_form-group">
                    <div class="left-aligned">
                        <label for="email" class="volunteering_form-group-label">@lang('content.volunteering.create.email')</label>
                    </div>
                    <div class="right-aligned">
                        <input id="email" type="email" name="email" placeholder="@lang('content.volunteering.create.email')" class="volunteering_form-group-input @error('email') is-invalid @enderror" value="{{ $volunteering->email }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="volunteering_form-group">
                    <div class="left-aligned">
                        <label for="phone" class="volunteering_form-group-label">@lang('content.volunteering.create.phone')</label>
                    </div>
                    <div class="right-aligned">
                        <input id="phone" type="text" name="phone" placeholder="@lang('content.volunteering.create.phone')" class="volunteering_form-group-input @error('phone') is-invalid @enderror" value="{{ $volunteering->phone }}" required autocomplete="phone" autofocus>

                        @error('phone')
                        <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="volunteering_form-group">
                    <div class="left-aligned">
                        <label for="alt_phone" class="volunteering_form-group-label">@lang('content.volunteering.create.alt_phone')</label>
                    </div>
                    <div class="right-aligned">
                        <input id="alt_phone" type="text" name="alt_phone" placeholder="@lang('content.volunteering.create.alt_phone')" class="volunteering_form-group-input @error('alt_phone') is-invalid @enderror" value="{{ $volunteering->alt_phone }}" autocomplete="alt_phone" autofocus>

                        @error('alt_phone')
                        <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
