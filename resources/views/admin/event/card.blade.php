@extends('layouts.frontend')
@section('seo_meta')
    <meta name="description" content="{!!  $event->getPreviewDesc() !!}}"/>
    <meta name="language" content="RU"/>

    <title>{{ $event->title }}</title>
@endsection
@section('content')
    <div class="container-fluid events-page">

        <div class="container">
            <a class="back-link" href="{{ url()->previous() }}">@lang('content.event.card.back')</a>
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="event-title">{{ $event->title }}</h2>
                    <h3 class="event-organisation"><a href="{{ $event->organisation['link'] }}" target="_blank">{{$event->organisation['name']}}</a></h3>
                    <p class="event-card-info date">{{ $event->date_start->format('H:i') }}, {{ $event->date_start->format('d.m.Y') }}</p>
                    <p class="event-card-info location">{{ $event->city->name }}, {{ $event->address }}</p>
                    <p class="event-card-info user">@lang('content.event.card.age') {{ $event->age }}</p>
                    <p class="event-card-info type">{{ $event->type->name}}</p>
                    <div class="event-card-description">{!!  $event->description !!}</div>

                    @if($event->location[0])
                        <div class="event-card-map" id="map">
                        </div>
                    @endif

                    <div class="event-card-footer">
                        <p class="event-card-date">@lang('content.event.card.published') {{ $event->published_at->format('d.m.Y') }}</p>
                        <a href="{{ route("frontend.feedback") }}?abuse=on" class="event-card-abuse">@lang('content.event.card.abuse')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pagescript')

    <script>

        function initMap() {
                    @if($event->location[0])

            var lat_p = '{{ $event->location[0] }}';
            var lng_p = '{{ $event->location[1] }}';

            var LatLng = {lat: parseFloat(lat_p), lng: parseFloat(lng_p)};
            console.log(lat_p);
            console.log(lng_p);

            var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 15, center: LatLng});

            var marker = new google.maps.Marker({
                position: LatLng,
                map: map
            });

            @endif
        }

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk-L7v6RJ1QVUtF48zHH8_eY7VWUvtluQ&callback=initMap">
    </script>
@stop