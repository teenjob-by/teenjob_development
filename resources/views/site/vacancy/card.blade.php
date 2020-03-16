@extends('layouts.site')
@section('seo_meta')
    <meta name="description" content="{!!  $vacancy->getSeoMeta() !!}"/>
    <meta name="language" content="RU"/>

    <title>{{ $vacancy->title }}</title>
@endsection
@section('content')
    <div class="container-fluid offers-page">

        <div class="container">
            <a class="back-link" href="{{ url()->previous() }}">@lang('content.vacancy.card.back')</a>
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="offer-title">{{ $vacancy->title }}</h2>
                    <h3 class="offer-organisation"><a href="{{ $vacancy->organisation['link'] }}" target="_blank">{{$vacancy->organisation['name']}}</a></h3>
                    <p class="offer-card-info location">{{ $vacancy->city->name }}</p>
                    <p class="offer-card-info portfolio">{{ $vacancy->speciality()->name }}</p>
                    <p class="offer-card-info user">@lang('content.vacancy.card.age') {{ $vacancy->age }}</p>
                    <div class="offer-description">{!! $vacancy->description !!}</div>
                    <p class="offer-card-title">@lang('content.vacancy.card.contacts')</p>
                    <p class="offer-card-info profile">{{ $vacancy->contact }}</p>
                    <p class="offer-card-info envelope">{{ $vacancy->email }}</p>
                    <p class="offer-card-info telephone">{{ $vacancy->phone }}</p>
                    <a class="btn btn-info offer-button" href="{{ route("site.whoisvolunteer") }}">@lang('content.vacancy.card.whatIs')</a>
                    <div class="offer-card-footer">
                        <p class="offer-card-date">@lang('content.vacancy.card.published') {{ $vacancy->published_at->format('d.m.Y') }}</p>
                        <a href="/support?abuse=on" class="offer-card-abuse">@lang('content.vacancy.card.abuse')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection