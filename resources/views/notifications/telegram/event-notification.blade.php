#сайт

_{{ $heading }}_
*{{ $data->title }}*

⏳ {{ $data->date_start->format('H:i') }}, {{ $data->date_start->format('d.m.Y') }}
📍 {{ $data->city->name }}, {{ $data->address }}
@if($data->type->name == "Платно")💰 {{ $data->type->name}}@else✅{{ $data->type->name}}@endif
