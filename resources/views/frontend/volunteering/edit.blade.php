@extends('layouts.frontend')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
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

                var phoneMaskAlt = IMask(document.getElementById('alt_phone'), {
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
                        console.log(data)

                        $("#submit").toggleClass('loading');

                        data = JSON.parse(data)


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


            <form id="form" method="PATCH" class="volunteering_form">
                @csrf
                @method('PATCH')

                <h3 class="volunteering_form-title">
                    <strong>@lang('content.volunteering.update.title')</strong>
                </h3>

                <div class="volunteering_form-group">
                    <label for="title" class="volunteering_form-group-label">@lang('content.volunteering.update.title')</label>
                    <input id="title" required type="text" class="volunteering_form-group-input @error('title') is-invalid @enderror" name="title" placeholder="@lang('content.volunteering.update.title')" minlength="3" value="{{ $volunteering->title }}" autofocus>

                    @error('title')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="volunteering_form-group">
                    <label for="city" class="volunteering_form-group-label">@lang('content.volunteering.update.city')</label>
                    <select id="city" class="custom-select volunteering_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ $volunteering->title }}" required autofocus>
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

                <div class="volunteering_form-group">
                    <label for="age" class="volunteering_form-group-label">@lang('content.volunteering.update.age')</label>
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


                <div class="volunteering_form-group">
                    <label for="speciality" class="volunteering_form-group-label">@lang('content.volunteering.update.speciality')</label>
                    <select id="speciality" class="custom-select volunteering_form-group-select @error('speciality') is-invalid @enderror" name="speciality" value="{{ $volunteering->speciality }}" required autofocus>
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

                <div class="volunteering_form-group description">
                    <label for="description" class="volunteering_form-group-label">@lang('content.volunteering.update.description')</label>
                    <textarea id="description" name="description" required minlength="20" type="text" class="volunteering_form-group-input textarea @error('description') is-invalid @enderror"  name="description" placeholder="@lang('content.volunteering.update.description')" >{{ $volunteering->description }}</textarea>

                    @error('description')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <h3 class="volunteering_form-title">
                    <strong>@lang('content.volunteering.update.contactsTitle')</strong>
                </h3>


                <div class="volunteering_form-group">
                    <label for="contactPerson" class="volunteering_form-group-label">@lang('content.volunteering.update.contactPerson')</label>
                    <input id="contactPerson" type="text" name="contactPerson" placeholder="@lang('content.volunteering.update.contactPerson')" class="volunteering_form-group-input @error('contactPerson') is-invalid @enderror" value="{{ $volunteering->contact }}" required autocomplete="contactPerson" autofocus minlength="3" maxlength="255">

                    @error('contactPerson')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="volunteering_form-group">
                    <label for="phone" class="volunteering_form-group-label">@lang('content.volunteering.update.phone')</label>
                    <input id="phone" type="text" name="phone" placeholder="@lang('content.volunteering.update.phone')" class="volunteering_form-group-input @error('phone') is-invalid @enderror" value="{{ $volunteering->phone }}" required autocomplete="phone" autofocus minlength="3" maxlength="255">

                    @error('phone')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="volunteering_form-group">
                    <label for="alt_phone" class="volunteering_form-group-label">@lang('content.volunteering.update.alt_phone')</label>
                    <input id="alt_phone" type="text" name="alt_phone" placeholder="@lang('content.volunteering.update.alt_phone')" class="volunteering_form-group-input @error('alt_phone') is-invalid @enderror" value="{{ $volunteering->alt_phone }}" required autocomplete="alt_phone" autofocus minlength="3" maxlength="255">

                    @error('alt_phone')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="volunteering_form-group">
                    <label for="email" class="volunteering_form-group-label">@lang('content.volunteering.update.email')</label>
                    <input id="email" type="email" name="email" placeholder="@lang('content.volunteering.update.email')" class="volunteering_form-group-input @error('email') is-invalid @enderror" value="{{ $volunteering->email }}" required autocomplete="email" autofocus minlength="3">

                    @error('email')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="volunteering_form-group">
                    <button id="submit" class="button-secondary" role="button" type="submit">
                        <span>
                            @lang('content.volunteering.update.save')
                        </span>
                        <div class="loading-icon"></div>
                    </button>
                </div>
                <div class="content-loader"></div>
                <p class="operation-result">
                </p>

                <p class="tip">@lang('content.volunteering.update.notification')</p>

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

