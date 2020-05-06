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
                    title: "@lang('content.internship.modal.remove.title')",
                    content: "@lang('content.internship.modal.remove.content')",
                    buttons: {
                        confirm: "@lang('content.internship.modal.remove.confirm')",
                        refuse: "@lang('content.internship.modal.remove.refuse')"
                    },
                    action: function () {
                        window.location.replace("{{ route('organisation.destroy') }}");
                    }
                },
                send: {
                    title: "@lang('content.internship.modal.send.title')",
                    content: "@lang('content.internship.modal.send.content')",
                    buttons: {
                        confirm: "@lang('content.internship.modal.send.confirm')",
                        refuse: "@lang('content.internship.modal.send.refuse')"
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
            $("#modal_confirmation-confirm").unbind('click');
            $("#modal_confirmation-confirm").unbind('click');             $("#modal_confirmation-confirm").click( function (e) {
                MicroModal.close("modal_" + name + "_confirmation")
                modals[name].action();
            });

            MicroModal.show("modal_" + name + "_confirmation")
        }




        $(document).ready(function () {

            try {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#form').on('submit', function(ev){

                    showModal("send");
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
                    url: '/organisation/internships/{{ $internship->id }}',
                    type: "PATCH",
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

                        $("#"+btn).unbind('click');
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

    <section class="internship_section">
        <div class="content-wrapper">


            <form id="form" method="PATCH" class="internship_form">
                @csrf
                @method('PATCH')

                <h3 class="internship_form-title">
                    <strong>@lang('content.internship.update.title')</strong>
                </h3>

                <div class="internship_form-group">
                    <label for="title" class="internship_form-group-label">@lang('content.internship.update.title')</label>
                    <input id="title" required type="text" class="internship_form-group-input @error('title') is-invalid @enderror" name="title" placeholder="@lang('content.internship.update.titlePlaceholder')" minlength="3" value="{{ $internship->title }}" autofocus>

                    @error('title')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="internship_form-group">
                    <label for="city" class="internship_form-group-label">@lang('content.internship.update.city')</label>
                    <select id="city" class="custom-select internship_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ $internship->title }}" required autofocus>
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

                <div class="internship_form-group">
                    <label for="age" class="internship_form-group-label">@lang('content.internship.update.age')</label>
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


                <div class="internship_form-group">
                    <label for="speciality" class="internship_form-group-label">@lang('content.internship.update.speciality')</label>
                    <select id="speciality" class="custom-select internship_form-group-select @error('speciality') is-invalid @enderror" name="speciality" value="{{ $internship->speciality }}" required autofocus>
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

                <div class="internship_form-group description">
                    <label for="description" class="internship_form-group-label">@lang('content.internship.update.description')</label>
                    <textarea id="description" name="description" required minlength="20" type="text" class="internship_form-group-input textarea @error('description') is-invalid @enderror"  name="description" placeholder="@lang('content.internship.update.descriptionPlaceholder')" >{{ $internship->description }}</textarea>

                    @error('description')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <h3 class="internship_form-title">
                    <strong>@lang('content.internship.update.create.contactsTitle')</strong>
                </h3>


                <div class="internship_form-group">
                    <label for="contactPerson" class="internship_form-group-label">@lang('content.internship.update.contactPerson')</label>
                    <input id="contactPerson" type="text" name="contactPerson" placeholder="@lang('content.internship.update.contactPersonPlaceholder')" class="internship_form-group-input @error('contactPerson') is-invalid @enderror" value="{{ $internship->contact }}" required autocomplete="contactPerson" autofocus minlength="3" maxlength="255">

                    @error('contactPerson')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="internship_form-group">
                    <label for="phone" class="internship_form-group-label">@lang('content.internship.update.phone')</label>
                    <input id="phone" type="text" name="phone" placeholder="@lang('content.internship.update.phonePlaceholder')" class="internship_form-group-input @error('phone') is-invalid @enderror" value="{{ $internship->phone }}" required autocomplete="phone" autofocus minlength="3" maxlength="255">

                    @error('phone')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="internship_form-group">
                    <label for="alt_phone" class="internship_form-group-label">@lang('content.internship.update.alt_phone')</label>
                    <input id="alt_phone" type="text" name="alt_phone" placeholder="@lang('content.internship.update.alt_phonePlaceholder')" class="internship_form-group-input @error('alt_phone') is-invalid @enderror" value="{{ $internship->alt_phone }}" required autocomplete="alt_phone" autofocus minlength="3" maxlength="255">

                    @error('alt_phone')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="internship_form-group">
                    <label for="email" class="internship_form-group-label">@lang('content.internship.update.email')</label>
                    <input id="email" type="email" name="email" placeholder="@lang('content.internship.update.emailPlaceholder')" class="internship_form-group-input @error('email') is-invalid @enderror" value="{{ $internship->email }}" required autocomplete="email" autofocus minlength="3">

                    @error('email')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="internship_form-group">
                    <button id="submit" class="button-secondary" role="button" type="submit">
                        <span>
                            @lang('content.internship.update.save')
                        </span>
                        <div class="loading-icon"></div>
                    </button>
                </div>
                <div class="content-loader"></div>
                <p class="operation-result">
                </p>

                <p class="tip">@lang('content.internship.update.notification')</p>

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
