<div class="item__wrapper">
    <div class="item__wrapper">
        <h2>{{ $heading }}</h2>
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

        @isset($data->salary)
            <p class="item__salary"> {{ $data->salary }} {{ $data->salaryType->name}}</p>
        @endif
        @isset($data->workTimeType)
            <p class="item__workTime"> {{ $data->workTimeType->name }}</p>
        @endif

        @isset($data->type)
            <p class="item__type">
                {{ $data->type->name}}
            </p>
        @endisset

        @isset($data->contact)
            <p class="item__contactPerson">{{ $data->contact }}</p>
        @endisset

        @isset($data->email)
            <p class="item__email">{{ $data->email }}</p>
        @endisset

        @isset($data->phone)
            <p class="item__phone">{{ $data->phone }}</p>
        @endisset

        @isset($data->altPhone)
            <p class="item__phone">{{ $data->alt_phone }}</p>
        @endisset

        <a href="{{ $data->moderatorUrl() }}">
            Модерировать
        </a>
    </div>
</div>
