
    @if(($data->total()) > 0)
        @foreach ($data as $event)
            <a class="card event-card {{ ($event->status == 2)? "card-overlay":"" }}" href="/events/{{$event->id}}">
                <div class="event-header">
                    <div class="event-time">
                        <p>{{$event->date_start->format('d.m.Y')}}, <span>{{$event->date_start->format('H:i')}}</span></p>
                    </div>
                    <img src="{{$event->image}}" class="event-card-img" onError='this.onerror=null;this.src="/images/noimg.png";'>
                </div>
                <p class="event-location">{{$event->city->name}}</p>
                <h3 class="event-title">{{$event->title}}</h3>
                <div class="event-description">
                        {!!  $event->getPreviewDesc() !!}
                </div>
            </a>
        @endforeach

        <div class="row justify-content-center paginator">
            {{ $data->appends($_GET)->links() }}
        </div>
    @else
        <p>Ничего не найдено(</p>
    @endif


