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
                        refuse: "@lang('content.ojob.modal.destroy.refuse')"
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
                $("#"+tab_id).addClass('current');

                $("#"+tab_id).find('.organisation_tab-lists').children(':first-child').addClass('active');
            })

            $('.organisation_list-menu-link').click(function(){
                var tab_id = $(this).attr('data-id');

                $(this).parent().parent().children().children().removeClass('active');
                $('.organisation_list').removeClass('active');

                $(this).addClass('active');
                $("#"+tab_id).addClass('active');
            })




            try {
                MicroModal.init();
            }catch (e) {
                console.log(e)
            }


             $('.organisation_tab-link[data-tab=' + window.location.hash.substr(1) + ']').click();




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
                <ul>
                    <li class="organisation_tab-link current" data-tab="account"><a href="#account">@lang('content.organisation.title')</a></li>
                    <li class="organisation_tab-link" data-tab="jobs-for-teens"><a href="#jobs-for-teens">@lang('content.organisation.jobTab')</a></li>
                    <li class="organisation_tab-link" data-tab="internships-for-teens"><a href="#internships-for-teens">@lang('content.organisation.internTab')</a></li>
                    <li class="organisation_tab-link" data-tab="volunteerings-for-teens"><a href="#volunteerings-for-teens">@lang('content.organisation.volunteerTab')</a></li>
                    <li class="organisation_tab-link" data-tab="events-for-teens"><a href="#events-for-teens">@lang('content.organisation.eventTab')</a></li>
                </ul>



                <div id="account" class="organisation_tab-content current">
                    <hr class="divider"/>
                    <h3 class="organisation_form-title">
                        <strong>@lang('content.organisation.account.title')</strong>
                    </h3>

                    <div class="organisation_form-group">
                        <label for="title" class="organisation_form-group-label">@lang('content.organisation.account.orgName')</label>
                        <input readonly type="text" class="organisation_form-group-input" name="name" value="{{ $organisation->name }}">
                    </div>

                    <div class="organisation_form-group">
                        <label for="link" class="organisation_form-group-label">@lang('content.organisation.account.orgSite')</label>
                        <input readonly type="text" class="organisation_form-group-input" name="link" value="{{ $organisation->link }}">
                    </div>

                    <div class="organisation_form-group">
                        <label for="type" class="organisation_form-group-label">@lang('content.organisation.account.orgType')</label>
                        <input readonly type="text" class="organisation_form-group-input" name="type" value="{{ $organisation->type }}">
                    </div>

                    <div class="organisation_form-group">
                        <label for="unique_identifier" class="organisation_form-group-label">@lang('content.organisation.account.orgID')</label>
                        <input readonly type="text" class="organisation_form-group-input" name="unique_identifier" value="{{ $organisation->unique_identifier }}">
                    </div>


                    <h3 class="organisation_form-title">
                        <strong>@lang('content.organisation.account.contactsTitle')</strong>
                    </h3>

                    <div class="organisation_form-group">
                        <label for="contact" class="organisation_form-group-label">@lang('content.organisation.account.contactsPerson')</label>
                        <input readonly type="text" class="organisation_form-group-input" name="contact" value="{{ $organisation->contact }}">
                    </div>

                    <div class="organisation_form-group">
                        <label for="phone" class="organisation_form-group-label">@lang('content.organisation.account.contactsPhone')</label>
                        <input readonly type="text" class="organisation_form-group-input" name="phone" value="{{ $organisation->phone }}">
                    </div>

                    <div class="organisation_form-group">
                        <label for="alt_phone" class="organisation_form-group-label">@lang('content.organisation.account.contactsAdditionalPhone')</label>
                        <input readonly type="text" class="organisation_form-group-input" name="alt_phone" value="{{ $organisation->alt_phone }}">
                    </div>

                    <div class="organisation_form-group">
                        <label for="email" class="organisation_form-group-label">@lang('content.organisation.account.contactsEmail')</label>
                        <input readonly type="text" class="organisation_form-group-input" name="email" value="{{ $organisation->email }}">
                    </div>

                    <div class="organisation_form-group">
                        <label for="alt_email" class="organisation_form-group-label">@lang('content.organisation.account.contactsadditionalEmail')</label>
                        <input readonly type="text" class="organisation_form-group-input" name="alt_email" value="{{ $organisation->alt_email }}">
                    </div>

                    <div class="organisation_form-group">
                        <a class="button-secondary" href="{{ route('organisation.update') }}" role="button">
                            <span>
                                @lang('content.organisation.account.editPersonalInfo')
                            </span>
                        </a>
                    </div>
                </div>



                @foreach($data as $section_name => $section_data)



                        <div id="{{ $section_name }}s-for-teens" class="organisation_tab-content">
                        <hr class="divider"/>

                        <div class="organisation_tab-wrapper">

                            <div class="organisation_tab-lists">
                                @foreach($section_data as $item_group => $items)
                                    <div class="organisation_list" id="{{ $section_name.'_'.$item_group }}">
                                        <h3 class="organisation_list-title">@lang('content.organisation.'. $item_group . '.create')</h3>

                                        @if($section_name !== "event")
                                            <div class="organisation_list-wrapper" >
                                                @foreach($items as $item)
                                                    <div class="organisation_list-item " >
                                                        <h3 class="organisation_list-item-title">
                                                            @if(false)
                                                                <span class="organisation_list-item-approved"></span>
                                                            @endif
                                                            <a class="organisation_list-item-title-link" href="{{ route('organisation.' .$section_name. 's.update', $item->id) }}"><strong>{{$item->title}}</strong></a>

                                                            @if($item->salary)
                                                                <span class="organisation_list-item-salary">{{ $item->salary }} {{ $item->salaryType->name}}</span>
                                                            @endif

                                                            <span class="{{ $section_name  }}-icon"></span>

                                                        </h3>
                                                        <h4 class="organisation_list-item-organisation"><a href="{{ $item->organisation['link'] }}" target="_blank">{{$item->organisation['name']}}</a></h4>
                                                        <div class="organisation_list-item-description">{!! $item->getPreviewDesc() !!}</div>

                                                        <div class="organisation_list-item-footer">
                                                            <p class="organisation_list-item-city">{{$item->city->name}}</p>
                                                            <p class="organisation_list-item-date">{{$item->published_at->format('j F')}}</p>
                                                        </div>

                                                        <div class="organisation_list-item-action-wrapper">

                                                            @if($item_group == 'archived')
                                                                <form method="patch" action="{{ route('organisation.' .$section_name. 's.unarchive', $item->id) }}" id="form_unarchive_{{ $item->id }}" class="form_unarchive">
                                                                    @csrf
                                                                    @method('patch')
                                                                    <input name="id" type="hidden" value="{{ $item->id }}">
                                                                    <button type="submit" class="organisation_list-item-action">
                                                                        <i class="archive-icon"></i>
                                                                        <span>На модерацию</span>
                                                                    </button>
                                                                </form>

                                                            @else
                                                                <form method="patch" action="{{ route('organisation.' .$section_name. 's.archive', $item->id) }}" id="form_archive_{{ $item->id }}" class="form_archive">
                                                                    @csrf
                                                                    @method('patch')
                                                                    <input name="id" type="hidden" value="{{ $item->id }}">
                                                                    <button type="submit" class="organisation_list-item-action">
                                                                        <i class="archive-icon"></i>
                                                                        <span>В архив</span>
                                                                    </button>
                                                                </form>
                                                            @endif




                                                            <a class="organisation_list-item-action" href="{{ route('organisation.' .$section_name. 's.edit', $item->id) }}">
                                                                <i class="edit-icon"></i>
                                                                <span>Редактировать</span>
                                                            </a>

                                                            <form method="delete" action="{{ route('organisation.' .$section_name. 's.destroy', $item->id) }}" id="form_destroy_{{ $item->id }}" class="form_destroy">
                                                                @csrf
                                                                @method('delete')
                                                                <input name="id" type="hidden" value="{{ $item->id }}">
                                                                <button class="organisation_list-item-action">
                                                                    <i class="remove-icon"></i>
                                                                    <span>Удалить</span>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else

                                            <div class="organisation_list-{{ $section_name }}-wrapper" >
                                                @foreach($items as $item)
                                                    <div class="{{ $section_name }}_card {{ ($item->status == 2)? "card-overlay":"" }}">

                                                        <div class="{{ $section_name }}_card-header">
                                                            <div class="{{ $section_name }}_card-header-time">
                                                                <span class="time-wrapper">{{$item->date_start->format('d.m.Y')}}, <span>{{$item->date_start->format('H:i')}}</span></span>
                                                            </div>
                                                            <img src="{{$item->image}}" class="{{ $section_name }}_card-header-image" onError='this.onerror=null;this.src="/images/noimg.png";'>
                                                        </div>

                                                        <p class="{{ $section_name }}_card-location">{{$item->city->name}}</p>
                                                        <h3 class="{{ $section_name }}_card-title trimmed">{{$item->title}}</h3>
                                                        <div class="{{ $section_name }}_card-description trimmed">
                                                            {!!  $item->getPreviewDesc() !!}
                                                        </div>
                                                        <div class="{{ $section_name }}_card-more" href="{{ route('frontend.' . $section_name . 's.show', $item->id) }}">
                                                            Читать больше
                                                        </div>

                                                        <div class="card-action-wrapper">

                                                            @if($item_group == 'archived')
                                                                <form method="patch" action="{{ route('organisation.' .$section_name. 's.unarchive', $item->id) }}" id="form_unarchive_{{ $item->id }}" class="form_unarchive">
                                                                    @csrf
                                                                    @method('patch')
                                                                    <input name="id" type="hidden" value="{{ $item->id }}">
                                                                    <button type="submit" class="organisation_list-item-action">
                                                                        <i class="archive-icon"></i>
                                                                        <span>На модерацию</span>
                                                                    </button>
                                                                </form>

                                                            @else
                                                                <form method="patch" action="{{ route('organisation.' .$section_name. 's.archive', $item->id) }}" id="form_archive_{{ $item->id }}" class="form_archive">
                                                                    @csrf
                                                                    @method('patch')
                                                                    <input name="id" type="hidden" value="{{ $item->id }}">
                                                                    <button type="submit" class="organisation_list-item-action">
                                                                        <i class="archive-icon"></i>
                                                                        <span>В архив</span>
                                                                    </button>
                                                                </form>
                                                            @endif


                                                            <a class="organisation_list-item-action" href="{{ route('organisation.' .$section_name. 's.edit', $item->id) }}">
                                                                <i class="edit-icon"></i>
                                                                <span>Редактировать</span>
                                                            </a>

                                                            <form method="delete" action="{{ route('organisation.' .$section_name. 's.destroy', $item->id) }}" id="form_destroy_{{ $item->id }}" class="form_destroy">
                                                                @csrf
                                                                @method('delete')
                                                                <input name="id" type="hidden" value="{{ $item->id }}">
                                                                <button class="organisation_list-item-action">
                                                                    <i class="remove-icon"></i>
                                                                    <span>Удалить</span>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif


                                    </div>
                                @endforeach
                            </div>

                            <div class="organisation_list-menu">

                                    <ul class="organisation_list-menu-list">
                                        <li class="organisation_list-menu-item">
                                            <a class="button-secondary" href="{{ route('organisation.'. $section_name .'s.create') }}" role="button">
                                                <span>
                                                    @lang('content.organisation.'. $section_name . '.create')
                                                </span>
                                            </a>
                                        </li>

                                        <li class="organisation_list-menu-item" >
                                            <a class="organisation_list-menu-link active" data-id="{{$section_name}}_published" href="#">
                                                Опубликовано
                                            </a>
                                        </li>

                                        <li class="organisation_list-menu-item">
                                            <a class="organisation_list-menu-link" data-id="{{$section_name}}_pending" href="#">
                                                На модерации
                                            </a>
                                        </li>

                                        <li class="organisation_list-menu-item">
                                            <a class="organisation_list-menu-link" data-id="{{$section_name}}_archived" href="#">
                                                Архив
                                            </a>
                                        </li>
                                    </ul>
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
