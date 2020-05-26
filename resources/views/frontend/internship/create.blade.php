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
                    title: "@lang('content.internship.update.modal.success.title')",
                    content: "@lang('content.internship.update.modal.success.content')",
                    buttons: {
                        confirm: "@lang('content.internship.update.modal.success.confirm')",
                    },
                    action: function () {
                        location.href = "/organisation#internships-for-teens";
                    }
                },

                error: {
                    title: "@lang('content.internship.update.modal.error.title')",
                    content: "@lang('content.internship.update.modal.error.content')",
                    buttons: {
                        confirm: "@lang('content.internship.update.modal.error.confirm')",
                    }
                },

                fail: {
                    title: "@lang('content.internship.update.modal.fail.title')",
                    content: "@lang('content.internship.update.modal.fail.content')",
                    buttons: {
                        confirm: "@lang('content.internship.update.modal.fail.confirm')",
                    }
                }
            };

            $(".modal").attr("id", "modal_" + name);
            $("#modal-title").empty().append(modals[name].title);
            $("#modal-content").empty().append("<p>" + modals[name].content + "</p>");
            $("#modal-confirm").empty().append(modals[name].buttons.confirm);
            $("#modal-confirm").unbind('click');

            $("#modal-confirm").click( function (e) {
                MicroModal.close("modal_" + name)
                modals[name].action();
            });

            MicroModal.show("modal_" + name)
        }
        $(document).ready(function () {



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
                    url: '{{ route('organisation.internships.store') }}',
                    type: "POST",
                    data: $('#form').serialize(),
                    dataType: 'text'
                })
                .done(
                    function(data){
                        console.log(data)

                        $("#submit").toggleClass('loading');

                        for (var prop in data) {
                            $(".operation-result").append(prop.va);
                        }

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


            <form id="form" method="POST" class="internship_form" action="{{ route('organisation.internships.store') }}">
                @csrf

                <h3 class="internship_form-title">
                    <strong>@lang('content.internship.create.title')</strong>
                </h3>

                <div class="internship_form-group">
                    <label for="title" class="internship_form-group-label">@lang('content.internship.create.name')</label>
                    <input id="title" required type="text" class="internship_form-group-input @error('title') is-invalid @enderror" name="title" placeholder="@lang('content.internship.create.name')" minlength="3" value="{{ old('title') }}" autofocus>

                    @error('title')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="internship_form-group">
                    <label for="city" class="internship_form-group-label">@lang('content.internship.create.city')</label>
                    <select id="city" class="custom-select internship_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autofocus>
                        <option selected value>@lang('content.internship.create.city')</option>
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

                <div class="internship_form-group">
                    <label for="age" class="internship_form-group-label">@lang('content.internship.create.age')</label>
                    <select id="age" class="custom-select internship_form-group-select @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autofocus>
                        <option selected value>@lang('content.internship.create.age')</option>
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



                <div class="internship_form-group">
                    <label for="speciality" class="internship_form-group-label">@lang('content.internship.create.speciality')</label>
                    <select id="speciality" class="custom-select internship_form-group-select @error('speciality') is-invalid @enderror" name="speciality" value="{{ old('speciality') }}" required autofocus>
                        <option selected value>@lang('content.internship.create.speciality')</option>
                        @foreach($specialities as $speciality)
                            <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                        @endforeach
                    </select>

                    @error('speciality')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="internship_form-group description">
                    <textarea id="description" name="description" required minlength="20" type="text" class="internship_form-group-input textarea @error('description') is-invalid @enderror"  name="description" placeholder="@lang('content.internship.create.description')" value="{{ old('description') }}"></textarea>

                    @error('description')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <h3 class="internship_form-title">
                    <strong>@lang('content.internship.create.contactsTitle')</strong>
                </h3>


                <div class="internship_form-group">
                    <label for="contactPerson" class="internship_form-group-label">@lang('content.internship.create.contactPerson')</label>
                    <input id="contactPerson" type="text" name="contactPerson" placeholder="@lang('content.internship.create.contactPerson')" class="internship_form-group-input @error('contactPerson') is-invalid @enderror" value="{{ old('contactPerson') }}" required autocomplete="contactPerson" autofocus minlength="3" maxlength="255">

                    @error('contactPerson')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="internship_form-group">
                    <label for="phone" class="internship_form-group-label">@lang('content.internship.create.phone')</label>
                    <input id="phone" type="text" name="phone" placeholder="@lang('content.internship.create.phone')" class="internship_form-group-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required autocomplete="phone" autofocus minlength="3" maxlength="255">

                    @error('phone')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="internship_form-group">
                    <label for="alt_phone" class="internship_form-group-label">@lang('content.internship.create.alt_phone')</label>
                    <input id="alt_phone" type="text" name="alt_phone" placeholder="@lang('content.internship.create.alt_phone')" class="internship_form-group-input @error('alt_phone') is-invalid @enderror" value="{{ old('alt_phone') }}" required autocomplete="alt_phone" autofocus minlength="3" maxlength="255">

                    @error('alt_phone')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="internship_form-group">
                    <label for="email" class="internship_form-group-label">@lang('content.internship.create.email')</label>
                    <input id="email" type="email" name="email" placeholder="@lang('content.internship.create.email')" class="internship_form-group-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus minlength="3">

                    @error('email')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="internship_form-group">
                    <button id="submit" class="button-secondary" role="button" type="submit">
                        <span>
                            @lang('content.internship.create.save')
                        </span>
                        <div class="loading-icon"></div>
                    </button>
                </div>
                <div class="content-loader"></div>
                <p class="operation-result">
                </p>

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
                    <button class="modal__btn modal__btn-primary" id="modal-confirm" data-micromodal-close aria-label="Close this dialog window"></button>
                </footer>
            </div>
        </div>
    </div>




@endsection

