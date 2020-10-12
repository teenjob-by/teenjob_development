_{{ $heading }}_
*{{ $data->title }}*

{{ $data->city->name }}
{{ $data->speciality()->name }}
@lang('content.job.card.age') {{ $data->age }}
