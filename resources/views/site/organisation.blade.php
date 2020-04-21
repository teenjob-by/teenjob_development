@extends('layouts.site')

@section('content')
    <div class="container-fluid organisation">
        <div class="container container-large">

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#account">@lang('content.organisation.title')</a>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#jobs-for-teens">@lang('content.organisation.vacancyTab')</a>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#internship">@lang('content.organisation.internTab')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#volunteering">@lang('content.organisation.volunteerTab')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#events">@lang('content.organisation.eventTab')</a>
                        </li>
                    </ul>
                </div>
            </div>



            <!-- Tab panes -->
            <div class="tab-content">

                <div class="tab-pane active" id="account">

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-12">
                            <div class="row">
                                <div class="offset-lg-3 col-lg-9 col-sm-12">
                                    <h2>@lang('content.organisation.account.title')</h2>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-lg-5 col-sm-12 col-form-label padding-0">@lang('content.organisation.account.orgName')</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="title" value="{{ $organisation->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="link" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisation.account.orgSite')</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="link" value="{{ $organisation->link }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisation.account.orgType')</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="type" value="{{ $organisation->type }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="unique_identifier" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisation.account.orgID')</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="unique_identifier" value="{{ $organisation->unique_identifier }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="offset-lg-3 col-lg-9 col-sm-12">
                                    <h2>@lang('content.organisation.account.contactsTitle')</h2>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisation.account.contactsPerson')</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="contact" value="{{ $organisation->contact }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisation.account.contactsPhone')</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="phone" value="{{ $organisation->phone }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alt_phone" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisation.account.contactsAdditionalPhone')</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="alt_phone" value="{{ $organisation->alt_phone }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisation.account.contactsEmail')</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="email" value="{{ $organisation->email }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alt_email" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisation.account.contactsadditionalEmail')</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="alt_email" value="{{ $organisation->alt_email }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <a class="btn btn-success btn-orange ml-auto" href="{{ '/organisation/edit' }} " role="button">@lang('content.organisation.account.editPersonalInfo')</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!--<div class="tab-pane fade" id="vacancy">


                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a class="btn btn-success btn-orange btn-create {{ (count($vacancies) > 0)?'':'disable' }}" href="{{ route('account.vacancyForm') }}" role="button">@lang('content.organisation.vacancies.create')</a>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.vacancies.published')</h3>
                                    <div class="internship-list">
                                        @if(count($vacancies))
                                            @foreach($vacancies as $vacancy)
                                                @if($vacancy->status == 1)
                                                    <div class="internship-item">
                                                        <div class="internship-title">
                                                            <a class="internship-name" href="{{ route('vacancy.edit', $vacancy->id) }}">{{ $vacancy->title }}</a>
                                                        </div>

                                                        <div class="internship-actions">
                                                            <a href="/jobs-for-teens/archive/{{ $vacancy->id }}">@lang('content.organisation.vacancies.archive') </a>
                                                            <span>@lang('content.organisation.vacancies.publishedBefore') {{ $vacancy->getTimeBeforeArchiving()->format('d.m.Y') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.vacancies.notFoundPublished')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.vacancies.moderated')</h3>
                                    <div class="internship-list">
                                        @if(count($vacancies))
                                            @foreach($vacancies as $vacancy)
                                                @if($vacancy->status == 0)
                                                    <div class="internship-item">
                                                        <div class="internship-title">
                                                            <a class="internship-name" href="{{ route('vacancy.edit', $vacancy->id) }}">{{ $vacancy->title }}</a>
                                                        </div>

                                                        <div class="internship-actions">
                                                            <a href="/jobs-for-teens/archive/{{ $vacancy->id }}">@lang('content.organisation.vacancies.archive')</a>
                                                        </div>
                                                    </div>
                                                @endif

                                            @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.vacancies.notFoundModerated')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.vacancies.archiveTitle')</h3>
                                    <div class="internship-list">
                                        @if(count($vacancies))
                                            @foreach($vacancies as $vacancy)
                                                @if($vacancy->status == 2)
                                                    <div class="internship-item">
                                                        <div class="internship-title">
                                                            <a class="internship-name" href="{{ route('vacancy.edit', $vacancy->id) }}">{{ $vacancy->title }}</a>
                                                        </div>

                                                        <div class="internship-actions">
                                                            <a href="/jobs-for-teens/unarchive/{{ $vacancy->id }}">@lang('content.organisation.vacancies.unarchive')</a>
                                                        </div>
                                                    </div>
                                                @endif

                                            @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.vacancies.notFoundArchive')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="internship">


                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a class="btn btn-success btn-orange btn-create {{ (count($internships) > 0)?'':'disable' }}" href="{{ route('account.internshipForm') }}" role="button">@lang('content.organisation.internships.create')</a>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.internships.published')</h3>
                                    <div class="internship-list">
                                        @if(count($internships))
                                            @foreach($internships as $internship)
                                                @if($internship->status == 1)
                                                    <div class="internship-item">
                                                        <div class="internship-title">
                                                            <a class="internship-name" href="{{ route('internship.edit', $internship->id) }}">{{ $internship->title }}</a>
                                                        </div>

                                                        <div class="internship-actions">
                                                            <a href="/internships-for-teens/archive/{{ $internship->id }}">@lang('content.organisation.internships.archive') </a>
                                                            <span>@lang('content.organisation.internships.publishedBefore') {{ $internship->getTimeBeforeArchiving()->format('d.m.Y') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.internships.notFoundPublished')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.internships.moderated')</h3>
                                    <div class="internship-list">
                                        @if(count($internships))
                                        @foreach($internships as $internship)
                                            @if($internship->status == 0)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('internship.edit', $internship->id) }}">{{ $internship->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/internships-for-teens/archive/{{ $internship->id }}">@lang('content.organisation.internships.archive')</a>
                                                    </div>
                                                </div>
                                            @endif

                                        @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.internships.notFoundModerated')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.internships.archiveTitle')</h3>
                                    <div class="internship-list">
                                        @if(count($internships))
                                        @foreach($internships as $internship)
                                            @if($internship->status == 2)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('internship.edit', $internship->id) }}">{{ $internship->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/internships-for-teens/unarchive/{{ $internship->id }}">@lang('content.organisation.internships.unarchive')</a>
                                                    </div>
                                                </div>
                                            @endif

                                        @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.internships.notFoundArchive')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="volunteering">


                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a class="btn btn-success btn-orange btn-create {{ (count($volunteerings) > 0)?'':'disable' }}" href=" {{ route('account.volunteeringForm') }}" role="button">@lang('content.organisation.volunteering.create')</a>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.volunteering.published')</h3>
                                    <div class="internship-list">
                                        @if(count($volunteerings))
                                        @foreach($volunteerings as $volunteering)
                                            @if($volunteering->status == 1)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('volunteering.edit', $volunteering->id) }}">{{ $volunteering->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/volunteering/archive/{{ $volunteering->id }}">@lang('content.organisation.volunteering.archive')</a>
                                                        <span>@lang('content.organisation.volunteering.archiveBefore') {{ $volunteering->getTimeBeforeArchiving()->format('d.m.Y') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        @else
                                            <span class="items-empty">@lang('content.organisation.volunteering.notFoundPublished')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.volunteering.moderationTitle')</h3>
                                    <div class="internship-list">
                                        @if(count($volunteerings))
                                        @foreach($volunteerings as $volunteering)
                                            @if($volunteering->status == 0)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('volunteering.edit', $volunteering->id) }}">{{ $volunteering->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/volunteering/archive/{{ $volunteering->id }}">@lang('content.organisation.volunteering.archive')</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.volunteering.notFoundModeration')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.volunteering.archiveTitle')</h3>
                                    <div class="internship-list">
                                        @if(count($volunteerings))
                                        @foreach($volunteerings as $volunteering)
                                            @if($volunteering->status == 2)
                                            <div class="internship-item">
                                                <div class="internship-title">
                                                    <a class="internship-name" href="{{ route('volunteering.edit', $volunteering->id) }}">{{ $volunteering->title }}</a>
                                                </div>

                                                <div class="internship-actions">
                                                    <a href="/volunteering/unarchive/{{ $volunteering->id }}">@lang('content.organisation.volunteering.unarchive')</a>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.volunteering.notFoundArchive')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="events">

                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a class="btn btn-success btn-orange btn-create {{ (count($events) > 0)?'':'disable' }}" href="{{ route('account.eventForm') }}" role="button">@lang('content.organisation.events.create')</a>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.events.published')</h3>
                                    <div class="internship-list">
                                        @if(count($events))
                                        @foreach($events as $event)
                                            @if($event->status == 1)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('events.edit', $event->id) }}">{{ $event->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/event/archive/{{ $event->id }}">@lang('content.organisation.events.archive')</a>
                                                        <span>@lang('content.organisation.events.archiveBefore') {{ $event->getTimeBeforeArchiving()->format('d.m.Y') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.events.notFoundEvents')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.events.moderationTitle')</h3>
                                    <div class="internship-list">
                                        @if(count($events))
                                        @foreach($events as $event)
                                            @if($event->status == 0)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('events.edit', $event->id) }}">{{ $event->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/event/archive/{{ $event->id }}">@lang('content.organisation.events.archive')</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.events.notFoundEvents')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">@lang('content.organisation.events.archiveTitle')</h3>
                                    <div class="internship-list">
                                        @if(count($events))
                                        @foreach($events as $event)
                                            @if($event->status == 2)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('events.edit', $event->id) }}">{{ $event->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/event/unarchive/{{ $event->id }}">@lang('content.organisation.events.unarchive')</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @else
                                            <span class="items-empty">@lang('content.organisation.events.notFoundArchive')</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
@endsection
