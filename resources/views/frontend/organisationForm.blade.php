@extends('layouts.frontend')

@section('scripts')
    <script src="/js/micromodal.min.js"></script>
    <script>



        function showModal(name) {

            var modals = {
                remove: {
                    title: "@lang('content.organisationForm.modal.remove.title')",
                    content: "@lang('content.organisationForm.modal.remove.content')",
                    buttons: {
                        confirm: "@lang('content.organisationForm.modal.remove.confirm')",
                        refuse: "@lang('content.organisationForm.modal.remove.refuse')"
                    },
                    action: function () {
                        window.location.replace("{{ route('organisation.destroy') }}");
                    }
                },
                send: {
                    title: "@lang('content.organisationForm.modal.send.title')",
                    content: "@lang('content.organisationForm.modal.send.content')",
                    buttons: {
                        confirm: "@lang('content.organisationForm.modal.send.confirm')",
                        refuse: "@lang('content.organisationForm.modal.send.refuse')"
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
                    url: '{{ route('organisation.update') }}',
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


    <section class="organisation_section">
        <div class="content-wrapper">
            <h3 class="organisation_form-title">
                <strong>@lang('content.organisationForm.title')</strong>
            </h3>

            <form id="form" method="POST" class="organisation_form" action="{{ route('organisation.update') }}">
                @csrf

                <div class="organisation_form-group">
                    <label for="city" class="organisation_form-group-label">@lang('auth.register.city')</label>
                    <select id="city" class="custom-select organisation_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autofocus>
                        <option selected value>@lang('auth.register.city')</option>
                        @foreach($cities as $city)
                            @isset($organisation->city)
                                <option {{ ($city->id == $organisation->city->id)? 'selected': '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                            @else
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endisset
                        @endforeach
                    </select>


                    @error('city')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>


                <div class="organisation_form-group">
                    <label for="email" class="organisation_form-group-label">@lang('content.organisationForm.email')</label>
                    <input id="email" readonly type="text" class="organisation_form-group-input" name="email" value="{{ $organisation->email }}">
                </div>

                <div class="organisation_form-group">
                    <label for="alt_email" class="organisation_form-group-label">@lang('content.organisationForm.additionalEmail')</label>
                    <input id="alt_email" type="email" class="organisation_form-group-input @error('alt_email') is-invalid @enderror" name="alt_email" value="{{ $organisation->alt_email }}">

                    @error('alt_email')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="organisation_form-group">
                    <label for="phone" class="organisation_form-group-label">@lang('content.organisationForm.phone')</label>
                    <input type="text" class="organisation_form-group-input @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ $organisation->phone }}" required>

                    @error('phone')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="organisation_form-group">
                    <label for="alt_phone" class="organisation_form-group-label">@lang('content.organisationForm.alt_phone')</label>
                    <input type="text" class="organisation_form-group-input @error('alt_phone') is-invalid @enderror" name="alt_phone" id="alt_phone" value="{{ $organisation->alt_phone }}">

                    @error('alt_phone')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="organisation_form-group">
                    <label for="request" class="organisation_form-group-label">@lang('content.organisationForm.request')</label>
                    <textarea name="request" required type="text" maxlength="250" class="organisation_form-group-input textarea @error('request') is-invalid @enderror"  name="request" placeholder="@lang('content.organisationForm.requestPlaceholder')">{{ $organisation->request }}</textarea>

                    @error('request')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <h3 class="organisation_form-title">
                    <strong>@lang('content.organisationForm.passwordTitle')</strong>
                </h3>

                <div class="organisation_form-group">
                    <label for="password" class="organisation_form-group-label">@lang('content.organisationForm.passwordNew')</label>
                    <input id="password" type="password" name="password" placeholder="@lang('auth.register.passwordPlaceholder')" class="organisation_form-group-input @error('password') is-invalid @enderror" required autofocus minlength="8">
                    <i class="show-password" onclick="showPassword('password')"></i>
                    @error('password')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="organisation_form-group">
                    <label for="password_repeat" class="organisation_form-group-label">@lang('content.organisationForm.passwordRepeat')</label>
                    <input id="password_repeat" type="password" name="password_repeat" placeholder="@lang('auth.register.passwordPlaceholder')" class="organisation_form-group-input @error('password_repeat') is-invalid @enderror" required autofocus minlength="8">
                    <i class="show-password" onclick="showPassword('password_repeat')"></i>
                    @error('password_repeat')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="organisation_form-group">
                    <label for="password_old" class="organisation_form-group-label">@lang('content.organisationForm.passwordOld')</label>
                    <input id="password_old" type="password" name="password_old" placeholder="@lang('content.organisationForm.passwordOld')" class="organisation_form-group-input @error('password_old') is-invalid @enderror" required autofocus minlength="8">
                    <i class="show-password" onclick="showPassword('password_old')"></i>
                    @error('password_old')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <p class="tip">@lang('content.organisationForm.remind')</p>


                <div class="organisation_form-group">
                    <button id="submit" class="button-secondary" role="button" type="submit">
                        <span>
                            @lang('content.organisationForm.save')
                        </span>
                        <div class="loading-icon"></div>
                    </button>
                </div>
                <div class="content-loader"></div>
                <p class="operation-result">
                </p>
                <a class="remove-account-link" onclick='showModal("remove"); return false;'>@lang('content.organisationForm.remove')</a>

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
