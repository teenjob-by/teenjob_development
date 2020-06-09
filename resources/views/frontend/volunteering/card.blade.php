@extends('layouts.frontend')

@section('seo_meta')
    <meta name="description" content="{!!  $data->getSeoMeta() !!}"/>
    <meta name="language" content="RU"/>

    <title>{{ $data->title }}</title>
@endsection

@section('content')

    <section class="volunteering_section">
        <div class="content-wrapper">
            <div class="volunteering_description-wrapper">
                <a class="back-link" href="{{ url()->previous() }}">@lang('content.volunteering.card.back')</a>
                <h3 class="volunteering_description-title">{{ $data->title }}</h3>
                <h4 class="volunteering_description-organisation"><a href="{{ $data->organisation['link'] }}" target="_blank">{{$data->organisation['name']}}</a></h4>
                <p class="volunteering_description-info location">{{ $data->city->name }}</p>
                <p class="volunteering_description-info portfolio">{{ $data->speciality()->name }}</p>
                <p class="volunteering_description-info user">@lang('content.volunteering.card.age') {{ $data->age }}</p>
                <div class="volunteering_description-text raw-text">{!! $data->description !!}</div>
                <p class="volunteering_description-contacts-title">@lang('content.volunteering.card.contacts')</p>
                <p class="volunteering_description-info profile">{{ $data->contact }}</p>
                <p class="volunteering_description-info envelope">{{ $data->email }}</p>
                <p class="volunteering_description-info telephone">{{ $data->phone }}</p>
                @if(!empty($data->alt_phone))
                    <p class="volunteering_description-info alt-contact">{{ $data->alt_phone }}</p>
                @endif
                <a class="button-info" href="{{ route("frontend.whoIsVolunteer") }}"><span>@lang('content.volunteering.card.whatIs')</span></a>
                <div class="volunteering_description-footer">
                    <p class="volunteering_description-date">@lang('content.volunteering.card.published') {{ $data->published_at->format('d.m.Y') }}</p>
                    <a href="{{ route("frontend.feedback") }}?abuse=on" class="volunteering_description-abuse">@lang('content.volunteering.card.abuse')</a>
                </div>
            </div>
        </div>
    </section>

@endsection