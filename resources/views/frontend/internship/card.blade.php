@extends('layouts.frontend')

@section('seo_meta')
    <meta name="description" content="{!!  $data->getSeoMeta() !!}"/>
    <meta name="language" content="RU"/>

    <title>{{ $data->title }}</title>
@endsection

@section('content')

    <section class="internship_section">
        <div class="content-wrapper">
            <div class="internship_description-wrapper">
                <a class="back-link" href="{{ url()->previous() }}">@lang('content.internship.card.back')</a>
                <h3 class="internship_description-title">{{ $data->title }}</h3>
                <h4 class="internship_description-organisation"><a href="{{ $data->organisation['link'] }}" target="_blank">{{$data->organisation['name']}}</a></h4>
                <p class="internship_description-info location">{{ $data->city->name }}</p>
                <p class="internship_description-info portfolio">{{ $data->speciality()->name }}</p>
                <p class="internship_description-info user">@lang('content.internship.card.age') {{ $data->age }}</p>
                <div class="internship_description-text raw-text">{!! $data->description !!}</div>
                <p class="internship_description-contacts-title">@lang('content.internship.card.contacts')</p>
                <p class="internship_description-info profile">{{ $data->contact }}</p>
                <p class="internship_description-info envelope">{{ $data->email }}</p>
                <p class="internship_description-info telephone">{{ $data->phone }}</p>
                @if(!empty($data->alt_phone))
                    <p class="internship_description-info alt-contact">{{ $data->alt_phone }}</p>
                @endif
                <a class="button-info" href="{{ route("frontend.whoIsIntern") }}"><span>@lang('content.internship.card.whatIs')</span></a>
                <div class="internship_description-footer">
                    <p class="internship_description-date">@lang('content.internship.card.published') {{ $data->published_at->format('d.m.Y') }}</p>
                    <a href="{{ route("frontend.feedback") }}?abuse=on" class="internship_description-abuse">@lang('content.internship.card.abuse')</a>
                </div>
            </div>
        </div>
    </section>

@endsection