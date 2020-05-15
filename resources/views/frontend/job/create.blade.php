@extends('layouts.frontend')

@section('styles')
    <link rel="stylesheet" href="/js/trumbowyg/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="/js/trumbowyg/plugins/emoji/ui/trumbowyg.emoji.min.css">
    <link rel="stylesheet" href="/js/trumbowyg/plugins/giphy/ui/trumbowyg.giphy.min.css">
@endsection

@section('scripts')
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



        $('#description').trumbowyg({
            btns: [['strong', 'em',], ['insertImage'], ['foreColor', 'backColor'], ['emoji'], ['fontfamily'], ['fontsize'],['historyUndo', 'historyRedo'],['lineheight'],['noembed'], ],
            autogrow: true,
            lang: 'ru',
        });




        function showModal(name) {

            var modals = {
                remove: {
                    title: "@lang('content.job.modal.remove.title')",
                    content: "@lang('content.job.modal.remove.content')",
                    buttons: {
                        confirm: "@lang('content.job.modal.remove.confirm')",
                        refuse: "@lang('content.job.modal.remove.refuse')"
                    },
                    action: function () {
                        window.location.replace("{{ route('organisation.destroy') }}");
                    }
                },
                send: {
                    title: "@lang('content.job.modal.send.title')",
                    content: "@lang('content.job.modal.send.content')",
                    buttons: {
                        confirm: "@lang('content.job.modal.send.confirm')",
                        refuse: "@lang('content.job.modal.send.refuse')"
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
                    url: '{{ route('organisation.jobs.store') }}',
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
    </script>
@endsection
@section('content')

    <section class="job_section">
        <div class="content-wrapper">


            <form id="form" method="POST" class="job_form" action="{{ route('organisation.jobs.store') }}">
                @csrf

                <h3 class="job_form-title">
                    <strong>@lang('content.job.create.title')</strong>
                </h3>

                <div class="job_form-group">
                    <label for="title" class="job_form-group-label">@lang('content.job.create.name')</label>
                    <input id="title" required type="text" class="job_form-group-input @error('title') is-invalid @enderror" name="title" placeholder="@lang('content.job.create.name')" minlength="3" value="{{ old('title') }}" autofocus>

                    @error('title')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <label for="city" class="job_form-group-label">@lang('content.job.create.city')</label>
                    <select id="city" class="custom-select job_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autofocus>
                        <option selected value>@lang('content.job.create.city')</option>
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

                <div class="job_form-group">
                    <label for="age" class="job_form-group-label">@lang('content.job.create.age')</label>
                    <select id="age" class="custom-select job_form-group-select @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autofocus>
                        <option selected value>@lang('content.job.create.age')</option>
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

                <div class="job_form-group">
                    <label for="salary" class="job_form-group-label">@lang('content.job.create.salary')</label>
                    <div class="inline-group">
                        <input id="salary" required type="text" class="job_form-group-input @error('salary') is-invalid @enderror" name="salary" placeholder="@lang('content.job.create.salary')" minlength="3" value="{{ old('salary') }}" autofocus>

                        @error('salary')
                        <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror



                        <select id="salaryType" class="custom-select job_form-group-select @error('salaryType') is-invalid @enderror" name="salaryType" value="{{ old('salaryType') }}" required autofocus>
                            <option selected value>@lang('content.job.create.salaryType')</option>
                            @foreach($salary_types as $salaryType)
                                <option value="{{ $salaryType->id }}">{{ $salaryType->name }}</option>
                            @endforeach
                        </select>

                        @error('salaryType')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                </div>



                <div class="job_form-group">
                    <label for="speciality" class="job_form-group-label">@lang('content.job.create.speciality')</label>
                    <select id="speciality" class="custom-select job_form-group-select @error('speciality') is-invalid @enderror" name="speciality" value="{{ old('speciality') }}" required autofocus>
                        <option selected value>@lang('content.job.create.speciality')</option>
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

                <div class="job_form-group">
                    <label for="workTime" class="job_form-group-label">@lang('content.job.create.workTime')</label>
                    <select id="workTime" class="custom-select job_form-group-select @error('workTime') is-invalid @enderror" name="workTime" value="{{ old('workTime') }}" required autofocus>
                        <option selected value>@lang('content.job.create.workTime')</option>
                        @foreach($work_times as $workTime)
                            <option value="{{ $workTime->id }}">{{ $workTime->name }}</option>
                        @endforeach
                    </select>

                    @error('orkTime')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="job_form-group description">
                    <label for="description" class="job_form-group-label">@lang('content.job.create.description')</label>
                    <textarea id="description" name="description" required minlength="20" type="text" class="job_form-group-input textarea @error('description') is-invalid @enderror"  name="description" placeholder="@lang('content.job.create.description')" value="{{ old('description') }}"></textarea>

                    @error('description')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <h3 class="job_form-title">
                    <strong>@lang('content.job.create.contactsTitle')</strong>
                </h3>


                <div class="job_form-group">
                    <label for="contactPerson" class="job_form-group-label">@lang('content.job.create.contactPerson')</label>
                    <input id="contactPerson" type="text" name="contactPerson" placeholder="@lang('content.job.create.contactPerson')" class="job_form-group-input @error('contactPerson') is-invalid @enderror" value="{{ old('contactPerson') }}" required autocomplete="contactPerson" autofocus minlength="3" maxlength="255">

                    @error('contactPerson')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <label for="phone" class="job_form-group-label">@lang('content.job.create.phone')</label>
                    <input id="phone" type="text" name="phone" placeholder="@lang('content.job.create.phone')" class="job_form-group-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required autocomplete="phone" autofocus minlength="3" maxlength="255">

                    @error('phone')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <label for="alt_phone" class="job_form-group-label">@lang('content.job.create.alt_phone')</label>
                    <input id="alt_phone" type="text" name="alt_phone" placeholder="@lang('content.job.create.alt_phone')" class="job_form-group-input @error('alt_phone') is-invalid @enderror" value="{{ old('alt_phone') }}" required autocomplete="alt_phone" autofocus minlength="3" maxlength="255">

                    @error('alt_phone')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <label for="email" class="job_form-group-label">@lang('content.job.create.email')</label>
                    <input id="email" type="email" name="email" placeholder="@lang('content.job.create.email')" class="job_form-group-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus minlength="3">

                    @error('email')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <button id="submit" class="button-secondary" role="button" type="submit">
                        <span>
                            @lang('content.job.create.save')
                        </span>
                        <div class="loading-icon"></div>
                    </button>
                </div>
                <div class="content-loader"></div>
                <p class="operation-result">
                </p>

                <p class="tip">@lang('content.job.create.notification')</p>

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

