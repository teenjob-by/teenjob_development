<div class="item__wrapper">
    <h2>Новое мероприятие ожидает модерации</h2>
    <h3 class="item__title">{{ $data->title }}</h3>
    <h4 class="item__author">
        <a href="{{ $data->organisation['link'] }}" target="_blank">
            {{ $data->organisation['name'] }}
        </a>
    </h4>

    @isset($data->date_start)
        <p class="item__date_start">
            {{ $data->date_start->format('H:i') }}, {{ $data->date_start->format('d.m.Y') }}
        </p>
    @endisset

    <p class="item__location">

        {{ $data->city->name }}

        @isset($data->address)
            , {{ $data->address }}
        @endisset
    </p>

    <p class="item__age">
        @lang('content.event.card.age') {{ $data->age }}
    </p>

    @isset($data->type)
        <p class="item__type">
            {{ $data->type->name}}
        </p>
    @endisset

    <div class="item__description">
        {!! $data->description !!}
    </div>

    @isset($data->location[0])
        <div class="item__map" id="map">
        </div>
    @endisset

</div>

