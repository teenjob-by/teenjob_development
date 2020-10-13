<div class="item__wrapper">
    <h2>{{ $heading }}</h2>
    <h3 class="item__title">{{ $data->name }}</h3>
    <h4 class="item__author">
        <a href="{{ $data->link ?? '' }}" target="_blank">
        </a>
    </h4>

    @isset($data->unique_identifier)
        <p class="item__date_start">
            {{ $data->unique_identifier }}
        </p>
    @endisset

    @isset($data->contact)
        <p class="item__date_start">
            {{ $data->unique_contact }}
        </p>
    @endisset

    @isset($data->email)
        <p class="item__date_start">
            {{ $data->email }}
        </p>
    @endisset

    @isset($data->email)
        <p class="item__date_start">
            {{ $data->phone }}
        </p>
    @endisset

    <a href="{{ $data->moderatorUrl() }}">
        Модерировать
    </a>

</div>
