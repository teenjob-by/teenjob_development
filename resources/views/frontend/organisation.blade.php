@extends('layouts.frontend')

@section('scripts')
    <script src="/js/micromodal.min.js"></script>
    <script>
        function showModal(name, form) {

            var modals = {
                archive: {
                    title: "@lang('content.job.modal.archive.title')",
                    content: "@lang('content.job.modal.archive.content')",
                    buttons: {
                        confirm: "@lang('content.job.modal.archive.confirm')",
                        refuse: "@lang('content.job.modal.archive.refuse')"
                    },
                    action: function (form) {
                        callAjax(form)
                    }
                },
                unarchive: {
                    title: "@lang('content.job.modal.unarchive.title')",
                    content: "@lang('content.job.modal.unarchive.content')",
                    buttons: {
                        confirm: "@lang('content.job.modal.unarchive.confirm')",
                        refuse: "@lang('content.job.modal.unarchive.refuse')"
                    },
                    action: function (form) {
                        callAjax(form)
                    }
                },
                destroy: {
                    title: "@lang('content.job.modal.destroy.title')",
                    content: "@lang('content.job.modal.destroy.content')",
                    buttons: {
                        confirm: "@lang('content.job.modal.destroy.confirm')",
                        refuse: "@lang('content.job.modal.destroy.refuse')"
                    },
                    action: function (form) {
                        callAjax(form)
                    }
                }
            };

            $(".modal").attr("id", "modal_" + name + "_confirmation");
            $("#modal_confirmation-title").empty().append(modals[name].title);
            $("#modal_confirmation-content").empty().append("<p>" + modals[name].content + "</p>");
            $("#modal_confirmation-confirm").empty().append(modals[name].buttons.confirm);
            $("#modal_confirmation-refuse").empty().append(modals[name].buttons.refuse);
            $("#modal_confirmation-confirm").unbind('click');             $("#modal_confirmation-confirm").click({form: form}, function (e) {
                MicroModal.close("modal_" + name + "_confirmation")
                modals[name].action(e.data.form);
            });

            MicroModal.show("modal_" + name + "_confirmation")
        }
        $(document).ready(function () {





            $('.organisation_tab-link').click(function(){
                var tab_id = $(this).attr('data-tab');

                $('.organisation_tab-link').removeClass('current');
                $('.organisation_tab-content').removeClass('current');

                $(this).addClass('current');
                $("#"+tab_id + "-tab").addClass('current');

            })




            try {
                MicroModal.init();
            }catch (e) {
                console.log(e)
            }

            var anchor =  window.location.hash.substr(1);
            if( anchor)
             $('.organisation_tab-link[data-tab=' + anchor + ']').click();




            try {

                $('.form_archive').on('submit', function(ev){
                    ev.preventDefault();
                    showModal("archive", this);
                });

                $('.form_unarchive').on('submit', function(ev){
                    ev.preventDefault();
                    showModal("unarchive", this);
                });

                $('.form_edit').on('submit', function(ev){
                });

                $('.form_destroy').on('submit', function(ev){
                    ev.preventDefault();
                    showModal("destroy", this);
                });

            }catch(e) {
                console.log(e)
            }
        });

        function callAjax(form) {


            console.log($(form).attr('method'));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#submit").toggleClass('loading');

            $.ajax(
                {
                    url: $(form).attr('action'),
                    type: $(form).attr('method'),
                    data: $(form).serialize(),
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
                        location.reload()

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
            <div id="account_tabs" class="organisation_tabs">
                <ul class="organisation_tabs-list">
                    <li class="organisation_tab-link current" data-tab="account"><a href="#account">@lang('content.organisation.title')</a></li>
                    <li class="organisation_tab-link" data-tab="jobs-for-teens"><a href="#jobs-for-teens">@lang('content.organisation.jobTab')</a></li>
                    <li class="organisation_tab-link" data-tab="internships-for-teens"><a href="#internships-for-teens">@lang('content.organisation.internTab')</a></li>
                    <li class="organisation_tab-link" data-tab="volunteerings-for-teens"><a href="#volunteerings-for-teens">@lang('content.organisation.volunteerTab')</a></li>
                    <li class="organisation_tab-link" data-tab="events-for-teens"><a href="#events-for-teens">@lang('content.organisation.eventTab')</a></li>
                </ul>



                <div id="account-tab" class="organisation_tab-content current">



                    <div class="organisation_form-group">
                        <div class="left-aligned">
                        </div>
                        <div class="right-aligned">
                            <h3 class="organisation_form-title">
                                <strong>@lang('content.organisation.account.title')</strong>
                            </h3>
                        </div>
                    </div>


                    <div class="organisation_form-group">
                        <div class="left-aligned">
                            <label for="title" class="organisation_form-group-label">@lang('content.organisation.account.orgName')</label>
                        </div>

                        <div class="right-aligned">
                            <input readonly type="text" class="organisation_form-group-input" name="name" value="{{ $organisation->name }}">
                        </div>
                    </div>



                    <div class="organisation_form-group">
                        <div class="left-aligned">
                            <label for="link" class="organisation_form-group-label">@lang('content.organisation.account.orgSite')</label>
                        </div>

                        <div class="right-aligned">
                            <input readonly type="text" class="organisation_form-group-input" name="link" value="{{ $organisation->link }}">
                        </div>
                    </div>

                    <div class="organisation_form-group">
                        <div class="left-aligned">
                            <label for="type" class="organisation_form-group-label">@lang('content.organisation.account.orgType')</label>
                        </div>

                        <div class="right-aligned">
                            <input readonly type="text" class="organisation_form-group-input" name="type" value="{{ $organisation->type }}">
                        </div>
                    </div>

                    <div class="organisation_form-group">

                        <div class="left-aligned">
                            <label for="unique_identifier" class="organisation_form-group-label">@lang('content.organisation.account.orgID')</label>
                        </div>

                        <div class="right-aligned">
                            <input readonly type="text" class="organisation_form-group-input" name="unique_identifier" value="{{ $organisation->unique_identifier }}">
                        </div>
                    </div>

                    <div class="organisation_form-group">
                        <div class="left-aligned">
                        </div>
                        <div class="right-aligned">
                            <h3 class="organisation_form-title">
                                <strong>@lang('content.organisation.account.contactsTitle')</strong>
                            </h3>
                        </div>
                    </div>




                    <div class="organisation_form-group">
                        <div class="left-aligned">
                            <label for="contact" class="organisation_form-group-label">@lang('content.organisation.account.contactsPerson')</label>
                        </div>

                        <div class="right-aligned">
                            <input readonly type="text" class="organisation_form-group-input" name="contact" value="{{ $organisation->contact }}">
                        </div>
                    </div>

                    <div class="organisation_form-group">

                        <div class="left-aligned">
                            <label for="phone" class="organisation_form-group-label">@lang('content.organisation.account.contactsPhone')</label>
                        </div>

                        <div class="right-aligned">
                            <input readonly type="text" class="organisation_form-group-input" name="phone" value="{{ $organisation->phone }}">
                        </div>
                    </div>

                    <div class="organisation_form-group">
                        <div class="left-aligned">
                            <label for="alt_phone" class="organisation_form-group-label">@lang('content.organisation.account.contactsAdditionalPhone')</label>
                        </div>

                        <div class="right-aligned">
                            <input readonly type="text" class="organisation_form-group-input" name="alt_phone" value="{{ $organisation->alt_phone }}">
                        </div>
                    </div>

                    <div class="organisation_form-group">
                        <div class="left-aligned">
                            <label for="email" class="organisation_form-group-label">@lang('content.organisation.account.contactsEmail')</label>
                        </div>

                        <div class="right-aligned">
                            <input readonly type="text" class="organisation_form-group-input" name="email" value="{{ $organisation->email }}">
                        </div>
                    </div>

                    <div class="organisation_form-group">
                        <div class="left-aligned">
                            <label for="alt_email" class="organisation_form-group-label">@lang('content.organisation.account.contactsadditionalEmail')</label>
                        </div>

                        <div class="right-aligned">
                            <input readonly type="text" class="organisation_form-group-input" name="alt_email" value="{{ $organisation->alt_email }}">
                        </div>
                    </div>

                    <div class="organisation_form-group">
                        <div class="left-aligned">

                        </div>
                        <div class="right-aligned">
                            <a class="button-secondary" href="{{ route('organisation.update') }}" role="button">
                                <span>
                                    @lang('content.organisation.account.editPersonalInfo')
                                </span>
                            </a>
                        </div>
                    </div>
                </div>



                @foreach($data as $section_name => $section_data)


                    <div id="{{ $section_name }}s-for-teens-tab" class="organisation_tab-content">
                        <div class="organisation_tab-wrapper">

                            <a class="button-secondary" href="{{ route('organisation.'. $section_name .'s.create') }}" role="button">
                                <span>
                                    @lang('content.organisation.'. $section_name . '.create')
                                </span>
                            </a>

                            <div class="organisation_tab-lists">
                                @foreach($section_data as $item_group => $items)
                                <div class="organisation_list" id="{{ $section_name.'_'.$item_group }}">
                                    <h3 class="organisation_list-title">@lang('content.organisation.'.$section_name.'.'. $item_group)</h3>


                                        <div class="organisation_list-wrapper" >

                                            @if(count($items) > 0)
                                                @foreach($items as $item)
                                                    <div class="organisation_list-item" >
                                                        <h3 class="organisation_list-item-title">
                                                            <a class="organisation_list-item-title-link" href="{{ route('organisation.' .$section_name. 's.update', $item->id) }}"><strong>{{$item->title}}</strong></a>
                                                        </h3>


                                                        <div class="organisation_list-item-action-wrapper">

                                                            @if($item_group == 'archived')
                                                                <form method="post" action="{{ route('organisation.' .$section_name. 's.unarchive', $item->id) }}" id="form_unarchive_{{ $item->id }}" class="form_unarchive">
                                                                    @csrf
                                                                    @method('patch')
                                                                    <input name="id" type="hidden" value="{{ $item->id }}">
                                                                    <button type="submit" class="organisation_list-item-action">
                                                                        <i class="archive-icon"></i>
                                                                        <span>На модерацию</span>
                                                                    </button>
                                                                </form>

                                                            @else
                                                                <form method="post" action="{{ route('organisation.' .$section_name. 's.archive', $item->id) }}" id="form_archive_{{ $item->id }}" class="form_archive">
                                                                    @csrf
                                                                    @method('patch')
                                                                    <input name="id" type="hidden" value="{{ $item->id }}">
                                                                    <button type="submit" class="organisation_list-item-action-link">
                                                                        <i class="archive-icon"></i>
                                                                        <span>В архив</span>
                                                                    </button>
                                                                </form>
                                                            @endif




                                                            <a class="organisation_list-item-action-link" href="{{ route('organisation.' .$section_name. 's.edit', $item->id) }}">
                                                                <i class="edit-icon"></i>
                                                                <span>Редактировать</span>
                                                            </a>

                                                            <form method="delete" action="{{ route('organisation.' .$section_name. 's.destroy', $item->id) }}" id="form_destroy_{{ $item->id }}" class="form_destroy">
                                                                @csrf
                                                                @method('delete')
                                                                <input name="id" type="hidden" value="{{ $item->id }}">
                                                                <button class="organisation_list-item-action-link">
                                                                    <i class="remove-icon"></i>
                                                                    <span>Удалить</span>
                                                                </button>
                                                            </form>

                                                        </div>
                                                        <div class="organisation_list-item__footer">
                                                            @if($item->status == 1)
                                                                <p class="item__published-date">Опубликовано: {{ $item->published_at->format('d.m.Y') }}</p>
                                                                <p class="item__archivation-date">Действительно до: {{ $item->published_at->addMonth()->format('d.m.Y') }}</p>
                                                            @else
                                                                <p class="item__published-date">Создано: {{ $item->published_at->format('d.m.Y') }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="message">Объявлений не найдено</p>
                                            @endif
                                        </div>


                                </div>
                            @endforeach
                        </div>

                        </div>
                    </div>

                @endforeach









            </div>
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
