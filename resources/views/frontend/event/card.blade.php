@extends('layouts.frontend')

@section('seo_meta')
    <meta name="description" content="{!!  $data->getSeoMeta() !!}"/>
    <meta name="language" content="RU"/>

    <title>{{ $data->title }}</title>
@endsection

@section('scripts')

    <script>

        function initMap() {
                    @if($data->location[0])

            var lat_p = '{{ $data->location[0] }}';
            var lng_p = '{{ $data->location[1] }}';

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
@endsection

@section('content')

    <section class="event_section">
        <div class="content-wrapper">
            <div class="event_description-wrapper">
                <a class="back-link" href="{{ url()->previous() }}">@lang('content.event.card.back')</a>
                <h3 class="event_description-title">{{ $data->title }}</h3>
                <h4 class="event_description-organisation"><a href="{{ $data->organisation['link'] }}" target="_blank">{{$data->organisation['name']}}</a></h4>
                <p class="event_description-info date">{{ $data->date_start->format('H:i') }}, {{ $data->date_start->format('d.m.Y') }}</p>
                <p class="event_description-info location">{{ $data->city->name }}, {{ $data->address }}</p>
                <p class="event_description-info user">@lang('content.event.card.age') {{ $data->age }}</p>
                <p class="event_description-info type">{{ $data->type->name}}</p>
                <div class="event_description-text">{!! $data->description !!}</div>

                @if($data->location[0])
                    <div class="event_description-map" id="map">
                    </div>
                @endif


                <div class="event_description-footer">
                    <p class="event_description-date">@lang('content.event.card.published') {{ $data->published_at->format('d.m.Y') }}</p>
                    <a href="{{ route("frontend.feedback") }}?abuse=on" class="event_description-abuse">@lang('content.event.card.abuse')</a>
                </div>
            </div>
        </div>
    </section>

@endsection