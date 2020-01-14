@extends('layouts.site')
@section('seo_meta')
    <meta name="description" content="{!!  $volunteering->getSeoMeta() !!}"/>
    <meta name="language" content="RU"/>

    <title>{{ $volunteering->title }}</title>
@endsection
@section('content')
    <div class="container-fluid offers-page">

        <div class="container">
            <a class="back-link" href="{{ url()->previous() }}">Назад</a>
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="offer-title">{{ $volunteering->title }}</h2>
                    <h3 class="offer-organisation"><a href="{{ $volunteering->organisation['link'] }}" target="_blank">{{$volunteering->organisation['name']}}</a></h3>
                    <p class="offer-card-info location">{{ $volunteering->city->name }}</p>
                    <p class="offer-card-info portfolio">{{ $volunteering->speciality()->name }}</p>
                    <p class="offer-card-info user">Возраст: {{ $volunteering->age }}+</p>
                    <div class="offer-description">{!! $volunteering->description !!}</div>
                    <p class="offer-card-title">Контакты</p>
                    <p class="offer-card-info profile">{{ $volunteering->contact }}</p>
                    <p class="offer-card-info envelope">{{ $volunteering->email }}</p>
                    <p class="offer-card-info telephone">{{ $volunteering->phone }}</p>
                    <a class="btn btn-info offer-button" href="{{ route("site.whoisvolunteer") }}">Кто такой волонтер?</a>
                    <div class="offer-card-footer">
                        <p class="offer-card-date">Опубликовано {{ $volunteering->published_at->format('d.m.Y') }}</p>
                        <a href="/support?abuse=on" class="offer-card-abuse">Пожаловаться на объявление</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection