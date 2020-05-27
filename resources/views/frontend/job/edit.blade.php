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
                    content: "@lang('content.job.update.modal.success.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.job.update.modal.success.confirm')",
                            action: function(){
                                location.href = "/organisation#jobs-for-teens";
                            }
                        },
                    },
                },

                error: {
                    content: "@lang('content.job.update.modal.error.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.job.update.modal.error.confirm')",
                            action: function () {
                                MicroModal.close("modal_error");
                            }
                        },
                    }
                },

                fail: {
                    content: "@lang('content.job.update.modal.fail.content')",
                    buttons: {
                        confirm: {
                            text: "@lang('content.job.update.modal.fail.confirm')",
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
                    url: '/organisation/jobs/{{ $job->id }}',
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

    <section class="job_section">
        <div class="content-wrapper">


            <form id="form" method="PATCH"  action="{{ route('organisation.jobs.update', $job->id) }}" class="job_form">
                @csrf
                @method('PATCH')

                <h3 class="job_form-title">
                    <strong>@lang('content.job.update.title')</strong>
                </h3>

                <div class="job_form-group">
                    <label for="title" class="job_form-group-label">@lang('content.job.update.name')</label>
                    <input id="title" required type="text" class="job_form-group-input @error('title') is-invalid @enderror" name="title" placeholder="@lang('content.job.update.name')" minlength="3" value="{{ $job->title }}" autofocus>

                    @error('title')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <label for="city" class="job_form-group-label">@lang('content.job.update.city')</label>
                    <select id="city" class="custom-select job_form-group-select @error('city') is-invalid @enderror" name="city" value="{{ $job->title }}" required autofocus>
                        @foreach($cities as $city)
                            <option {{ ($city->id == $job->city_id)? 'selected': '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>

                    @error('city')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <label for="age" class="job_form-group-label">@lang('content.job.update.age')</label>
                    <select id="age" class="custom-select job_form-group-select @error('age') is-invalid @enderror" name="age" value="{{ $job->age }}" required autofocus>
                        @foreach($ages as $age)
                            <option {{ ($age->id == $job->age)? 'selected': '' }} value="{{ $age->id }}">{{ $age->name }}</option>
                        @endforeach
                    </select>

                    @error('age')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <label for="salary" class="job_form-group-label">@lang('content.job.update.salary')</label>

                    <div class="inline-group">
                        <input id="salary" required type="text" class="job_form-group-input @error('salary') is-invalid @enderror" name="salary" placeholder="@lang('content.job.update.salary')" minlength="3" value="{{ $job->salary }}" autofocus>

                        @error('salary')
                        <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <select id="salaryType" class="custom-select job_form-group-select @error('salaryType') is-invalid @enderror" name="salaryType" value="{{$job->salary_type_id }}" required autofocus>
                            @foreach($salary_types as $salaryType)
                                <option {{ ($salaryType->id == $job->salary_type_id)? 'selected': '' }} value="{{ $salaryType->id }}">{{ $salaryType->name }}</option>
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
                    <label for="workTime" class="job_form-group-label">@lang('content.job.update.workTime')</label>
                    <select id="workTime" class="custom-select job_form-group-select @error('workTime') is-invalid @enderror" name="workTime" value="{{ $job->work_time_type_id }}" required autofocus>
                        @foreach($work_times as $workTime)
                            <option {{ ($workTime->id == $job->work_time_type_id)? 'selected': '' }} value="{{ $workTime->id }}">{{ $workTime->name }}</option>
                        @endforeach
                    </select>

                    @error('workTime')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>



                <div class="job_form-group">
                    <label for="speciality" class="job_form-group-label">@lang('content.job.update.speciality')</label>
                    <select id="speciality" class="custom-select job_form-group-select @error('speciality') is-invalid @enderror" name="speciality" value="{{ $job->speciality }}" required autofocus>
                        @foreach($specialities as $speciality)
                            <option {{ ($speciality->id == $job->speciality_id)? 'selected': '' }} value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                        @endforeach
                    </select>

                    @error('speciality')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="job_form-group description">

                    <textarea id="description" name="description" required minlength="20" type="text" class="job_form-group-input textarea @error('description') is-invalid @enderror"  name="description" placeholder="@lang('content.job.update.description')" >{{ $job->description }}</textarea>

                    @error('description')
                    <span class="message-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <h3 class="job_form-title">
                    <strong>@lang('content.job.update.contactsTitle')</strong>
                </h3>


                <div class="job_form-group">
                    <label for="contactPerson" class="job_form-group-label">@lang('content.job.update.contactPerson')</label>
                    <input id="contactPerson" type="text" name="contactPerson" placeholder="@lang('content.job.update.contactPerson')" class="job_form-group-input @error('contactPerson') is-invalid @enderror" value="{{ $job->contact }}" required autocomplete="contactPerson" autofocus minlength="3" maxlength="255">

                    @error('contactPerson')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <label for="phone" class="job_form-group-label">@lang('content.job.update.phone')</label>
                    <input id="phone" type="text" name="phone" placeholder="@lang('content.job.update.phone')" class="job_form-group-input @error('phone') is-invalid @enderror" value="{{ $job->phone }}" required autocomplete="phone" autofocus minlength="3" maxlength="255">

                    @error('phone')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <label for="alt_phone" class="job_form-group-label">@lang('content.job.update.alt_phone')</label>
                    <input id="alt_phone" type="text" name="alt_phone" placeholder="@lang('content.job.update.alt_phone')" class="job_form-group-input @error('alt_phone') is-invalid @enderror" value="{{ $job->alt_phone }}" required autocomplete="alt_phone" autofocus minlength="3" maxlength="255">

                    @error('alt_phone')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <label for="email" class="job_form-group-label">@lang('content.job.update.email')</label>
                    <input id="email" type="email" name="email" placeholder="@lang('content.job.update.email')" class="job_form-group-input @error('email') is-invalid @enderror" value="{{ $job->email }}" required autocomplete="email" autofocus minlength="3">

                    @error('email')
                    <span class="message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="job_form-group">
                    <button id="submit" class="button-secondary" role="button" type="submit">
                        <span>
                            @lang('content.job.update.save')
                        </span>
                        <div class="loading-icon"></div>
                    </button>
                </div>
                <div class="content-loader"></div>
                <p class="operation-result">
                </p>

                <p class="tip">@lang('content.job.update.notification')</p>

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

