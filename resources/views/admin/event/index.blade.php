@extends('layouts.app')

@section('content')
    <div class="container-fluid events">

        <div class="container">

            <div class="row mx-0">

                <div class="col-sm-8 card-wrapper">
                    @foreach($events as $event)
                        <a class="card event-card event-card-admin {{ ($event->status == 3)? 'banned':''}}"   href="/events/{{$event->id}}">
                            <div class="event-header">
                                <div class="event-time">
                                    <p>{{$event->date_start->format('d.m.Y')}}, <span>{{$event->date_start->format('H:i')}}</span></p>
                                </div>
                                <img src="{{$event->image}}" class="event-card-img">
                            </div>
                            <p class="event-location">{{$event->city->name}}</p>
                            <h3 class="event-title">{{$event->title}}</h3>
                            <div class="event-description">
                                <p class="desc-wrapper"> {!! $event->getPreviewDesc() !!} </p>
                            </div>

                            <table>
                                <tr>
                                    <td> <a href="{{ route('admin.events.approve', $event->id)}}" class="{{ in_array($event->status, [1, 2]) ? 'd-none': '' }} btn btn-enable"><i class="fa fa-globe" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.eventsForm', $event->id)}}" class="btn btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.events.ban', $event->id)}}" class="{{ in_array($event->status, [3]) ? 'd-none': '' }} btn btn-disable"><i class="fa fa-ban" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.events.remove', $event->id)}}" class="btn btn-remove"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                </tr>
                            </table>





                        </a>
                    @endforeach
                        <div class="row justify-content-center paginator">
                            {{ $events->appends($_GET)->links() }}
                        </div>
                </div>
            </div>
        </div>

    </div>


@endsection