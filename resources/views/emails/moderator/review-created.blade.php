<div class="item__wrapper">
    <h2>{{ $heading }}</h2>
    <h3 class="item__title">{{ $data->name }} {{ $data->last_name ?? '' }}</h3>

    @isset($data->type)
        <p class="item__date_start">
            {{ $data->type }}
        </p>
    @endisset

    @isset($data->organisation_name)
        <p class="item__date_start">
            {{ $data->organisation_name }}
        </p>
    @endisset

    @isset($data->grade)
        <p class="item__date_start">
            {{ $data->grade }}
        </p>
    @endisset

    @isset($data->text)
        <p class="item__date_start">
            {{ $data->text }}
        </p>
    @endisset

    <a href="{{ $data->moderatorUrl() }}">
        Модерировать
    </a>

</div>

