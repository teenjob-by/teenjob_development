@extends('layouts.site')

@section('content')
    <div class="container-fluid organisation">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#account">Данные об организации</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#internship">Стажировки</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#volunteering">Волонтерство</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#events">Мероприятия</a>
                        </li>
                    </ul>
                </div>
            </div>



            <!-- Tab panes -->
            <div class="tab-content">

                <div class="tab-pane active" id="account">
                    <h3  class="section-title">Личный кабинет</h3>
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-12">
                            <div class="row">
                                <div class="offset-lg-3 col-lg-9 col-sm-12">
                                    <h2>Данные об организации</h2>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-lg-5 col-sm-12 col-form-label padding-0">Название (офиц.)*</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="title" value="{{ $organisation->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="link" class="col-lg-5 col-sm-12 col-form-label">Сайт/группа в соц. сети*</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="link" value="{{ $organisation->link }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-lg-5 col-sm-12 col-form-label">Тип*</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="type" value="{{ $organisation->type }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="unique_identifier" class="col-lg-5 col-sm-12 col-form-label">УНП</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="unique_identifier" value="{{ $organisation->unique_identifier }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="offset-lg-3 col-lg-9 col-sm-12">
                                    <h2>Контактные данные</h2>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact" class="col-lg-5 col-sm-12 col-form-label">Контактное лицо</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="contact" value="{{ $organisation->contact }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-lg-5 col-sm-12 col-form-label">Телефон</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="phone" value="{{ $organisation->phone }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alt_phone" class="col-lg-5 col-sm-12 col-form-label">Доп. тел.</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="alt_phone" value="{{ $organisation->alt_phone }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-lg-5 col-sm-12 col-form-label">Email</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="email" value="{{ $organisation->email }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alt_email" class="col-lg-5 col-sm-12 col-form-label">Дополнительный email</label>
                                <div class="col-lg-7 col-sm-12">
                                    <input type="text" readonly class="form-control" name="alt_email" value="{{ $organisation->alt_email }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <a class="btn btn-success ml-auto" href="{{ '/organisation/edit' }} " role="button">Править персональную информацию</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="internship">
                    <h3 class="section-title">Стажировки</h3>

                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a class="btn btn-success btn-create {{ (count($internships) > 0)?'':'disable' }}" href="{{ route('account.internshipForm') }}" role="button">Создать объявление</a>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">Опубликовано</h3>
                                    <div class="internship-list">
                                        @if(count($internships))
                                            @foreach($internships as $internship)
                                                @if($internship->status == 1)
                                                    <div class="internship-item">
                                                        <div class="internship-title">
                                                            <a class="internship-name" href="{{ route('internship.edit', $internship->id) }}">{{ $internship->title }}</a>
                                                        </div>

                                                        <div class="internship-actions">
                                                            <a href="/internship/archive/{{ $internship->id }}">Заархивировать</a>
                                                            <span>до {{ $internship->getTimeBeforeArchiving()->format('d.m.Y') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="items-empty">Нет опубликованных стажировок</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">На модерации</h3>
                                    <div class="internship-list">
                                        @if(count($internships))
                                        @foreach($internships as $internship)
                                            @if($internship->status == 0)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('internship.edit', $internship->id) }}">{{ $internship->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/internship/archive/{{ $internship->id }}">Заархивировать</a>

                                                    </div>
                                                </div>
                                            @endif

                                        @endforeach
                                        @else
                                            <span class="items-empty">Нет стажировок на модерации</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">В архиве</h3>
                                    <div class="internship-list">
                                        @if(count($internships))
                                        @foreach($internships as $internship)
                                            @if($internship->status == 2)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('internship.edit', $internship->id) }}">{{ $internship->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/internship/unarchive/{{ $internship->id }}">Разархивировать</a>

                                                    </div>
                                                </div>
                                            @endif

                                        @endforeach
                                        @else
                                            <span class="items-empty">Архив стажировок пуст</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="volunteering">
                    <h3  class="section-title" >Волонтерство</h3>

                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a class="btn btn-success btn-create {{ (count($volunteerings) > 0)?'':'disable' }}" href=" {{ route('account.volunteeringForm') }}" role="button">Создать объявление</a>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">Опубликовано</h3>
                                    <div class="internship-list">
                                        @if(count($volunteerings))
                                        @foreach($volunteerings as $volunteering)
                                            @if($volunteering->status == 1)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('volunteering.edit', $volunteering->id) }}">{{ $volunteering->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/volunteering/archive/{{ $volunteering->id }}">Заархивировать</a>
                                                        <span>до {{ $volunteering->getTimeBeforeArchiving()->format('d.m.Y') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        @else
                                            <span class="items-empty">Нет опубликованных объявлений</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">На модерации</h3>
                                    <div class="internship-list">
                                        @if(count($volunteerings))
                                        @foreach($volunteerings as $volunteering)
                                            @if($volunteering->status == 0)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('volunteering.edit', $volunteering->id) }}">{{ $volunteering->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/volunteering/archive/{{ $volunteering->id }}">Заархивировать</a>

                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @else
                                            <span class="items-empty">Нет объявлений на модерации</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">В архиве</h3>
                                    <div class="internship-list">
                                        @if(count($volunteerings))
                                        @foreach($volunteerings as $volunteering)
                                            @if($volunteering->status == 2)
                                            <div class="internship-item">
                                                <div class="internship-title">
                                                    <a class="internship-name" href="{{ route('volunteering.edit', $volunteering->id) }}">{{ $volunteering->title }}</a>
                                                </div>

                                                <div class="internship-actions">
                                                    <a href="/volunteering/unarchive/{{ $volunteering->id }}">Разархивировать</a>

                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                        @else
                                            <span class="items-empty">Архив объявлений пуст</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="events">
                    <h3  class="section-title" >Мероприятия</h3>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a class="btn btn-success btn-create {{ (count($events) > 0)?'':'disable' }}" href="{{ route('account.eventForm') }}" role="button">Создать объявление</a>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">Опубликовано</h3>
                                    <div class="internship-list">
                                        @if(count($events))
                                        @foreach($events as $event)
                                            @if($event->status == 1)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('events.edit', $event->id) }}">{{ $event->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/event/archive/{{ $event->id }}">Заархивировать</a>
                                                        <span>до {{ $event->getTimeBeforeArchiving()->format('d.m.Y') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @else
                                            <span class="items-empty">Нет опубликованных событий</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">На модерации</h3>
                                    <div class="internship-list">
                                        @if(count($events))
                                        @foreach($events as $event)
                                            @if($event->status == 0)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('events.edit', $event->id) }}">{{ $event->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/event/archive/{{ $event->id }}">Заархивировать</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @else
                                            <span class="items-empty">Нет событий на модерации</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start">
                                <div class="col-md-12">
                                    <h3 class="title">В архиве</h3>
                                    <div class="internship-list">
                                        @if(count($events))
                                        @foreach($events as $event)
                                            @if($event->status == 2)
                                                <div class="internship-item">
                                                    <div class="internship-title">
                                                        <a class="internship-name" href="{{ route('events.edit', $event->id) }}">{{ $event->title }}</a>
                                                    </div>

                                                    <div class="internship-actions">
                                                        <a href="/event/unarchive/{{ $event->id }}">Разархивировать</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @else
                                            <span class="items-empty">Архив событий пуст</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
