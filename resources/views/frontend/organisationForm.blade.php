@extends('layouts.frontend')

@section('scripts')
    <script src="/js/micromodal.min.js"></script>
    <script>



        function showModal(name) {

            var modals = {
                remove: {
                    content: "@lang('content.organisationForm.remove.modal.message.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.organisationForm.remove.modal.message.confirm')",
                            action: function () {
                                window.location.replace("{{ route('organisation.destroy') }}");
                            }
                        },
                        refuse: {
                            text: "@lang('content.organisationForm.remove.modal.message.refuse')",
                            action: function () {
                                MicroModal.close("modal_remove");
                            }
                        }
                    },
                },
                success: {
                    content: "@lang('content.organisationForm.update.modal.success.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.organisationForm.update.modal.success.confirm')",
                            action: function(){
                                location.href = "/organisation#account";
                            }
                        },
                    },
                },

                error: {
                    content: "@lang('content.organisationForm.update.modal.error.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.organisationForm.update.modal.error.confirm')",
                            action: function () {
                                MicroModal.close("modal_error");
                            }
                        },
                    }
                },

                fail: {
                    content: "@lang('content.organisationForm.update.modal.fail.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.organisationForm.update.modal.fail.confirm')",
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

            $.ajax(
                {
                    url: '{{ route('organisation.update') }}',
                    type: "POST",
                    data: $('#form').serialize(),
                    dataType: 'text'
                })
                .done(
                function(data){

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


    <section class="organisation_section">
        <div class="content-wrapper">


            <form id="form" method="POST" class="organisation_form" action="{{ route('organisation.update') }}">
                @csrf
                @method('PATCH')

                <div class="organisation_form-group">
                    <div class="left-aligned">
                    </div>
                    <div class="right-aligned">
                        <h3 class="organisation_form-title">
                            <strong>@lang('content.organisationForm.title')</strong>
                        </h3>
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                        <label for="city" class="organisation_form-group-label">@lang('auth.register.city')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <select id="city" class="custom-select organisation_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autofocus>

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
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                        <label for="email" class="organisation_form-group-label">@lang('content.organisationForm.email')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <input id="email" readonly type="text" class="organisation_form-group-input" name="email" value="{{ $organisation->email }}">
                        </div>
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                        <label for="alt_email" class="organisation_form-group-label">@lang('content.organisationForm.additionalEmail')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <input id="alt_email" type="email" class="organisation_form-group-input @error('alt_email') is-invalid @enderror" name="alt_email" value="{{ $organisation->alt_email }}">

                            @error('alt_email')
                                <span class="message-invalid" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                        <label for="phone" class="organisation_form-group-label">@lang('content.organisationForm.phone')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <input type="text" class="organisation_form-group-input @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ $organisation->phone }}" required>

                            @error('phone')
                            <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                        <label for="alt_phone" class="organisation_form-group-label">@lang('content.organisationForm.alt_phone')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <input type="text" class="organisation_form-group-input @error('alt_phone') is-invalid @enderror" name="alt_phone" id="alt_phone" value="{{ $organisation->alt_phone }}">

                            @error('alt_phone')
                            <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                        <label for="request" class="organisation_form-group-label">@lang('content.organisationForm.request')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <textarea name="request" required type="text" maxlength="250" class="organisation_form-group-input textarea @error('request') is-invalid @enderror"  name="request" placeholder="@lang('content.organisationForm.requestPlaceholder')">{{ $organisation->request }}</textarea>

                            @error('request')
                            <span class="message-invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                    </div>
                    <div class="right-aligned">
                        <h3 class="organisation_form-title">
                            <strong>@lang('content.organisationForm.passwordTitle')</strong>
                        </h3>
                    </div>
                </div>


                <div class="organisation_form-group">
                    <div class="left-aligned">
                        <label for="password" class="organisation_form-group-label">@lang('content.organisationForm.passwordNew')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <input id="password" type="password" name="password" placeholder="@lang('auth.register.passwordPlaceholder')" class="organisation_form-group-input @error('password') is-invalid @enderror" required autofocus minlength="8">
                            <i class="show-password" onclick="showPassword('password')"></i>
                        </div>
                        @error('password')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                        <label for="password_repeat" class="organisation_form-group-label">@lang('content.organisationForm.passwordRepeat')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <input id="password_repeat" type="password" name="password_repeat" placeholder="@lang('auth.register.passwordPlaceholder')" class="organisation_form-group-input @error('password_repeat') is-invalid @enderror" required autofocus minlength="8">
                            <i class="show-password" onclick="showPassword('password_repeat')"></i>
                        </div>
                        @error('password_repeat')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                        <label for="password_old" class="organisation_form-group-label">@lang('content.organisationForm.passwordOld')</label>
                    </div>
                    <div class="right-aligned">
                        <div class="inner-icon">
                            <input id="password_old" type="password" name="password_old" placeholder="@lang('content.organisationForm.passwordOld')" class="organisation_form-group-input @error('password_old') is-invalid @enderror" required autofocus minlength="8">
                            <i class="show-password" onclick="showPassword('password_old')"></i>
                        </div>
                        @error('password_old')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                    </div>
                    <div class="right-aligned">
                        <p class="tip">@lang('content.organisationForm.remind')</p>
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                    </div>
                    <div class="right-aligned">
                        <button id="submit" class="button-account" role="button" type="submit">
                            <span>
                                @lang('content.organisationForm.save')
                            </span>
                            <div class="loading-icon"></div>
                        </button>
                    </div>
                </div>

                <div class="organisation_form-group">
                    <div class="left-aligned">
                    </div>
                    <div class="right-aligned">
                        <a class="remove-account-link" onclick='showModal("remove"); return false;'>@lang('content.organisationForm.remove.button')</a>
                    </div>
                </div>
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
