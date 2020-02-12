@extends('layouts.site')
@section('seo_meta')
    <meta name="description" content="{!!  $internship->getPreviewDesc() !!}"/>
    <meta name="language" content="RU"/>

    <title>{{ $internship->title }}</title>
@endsection
@section('content')
    <div class="container-fluid offers-page">

        <div class="container">
            <a class="back-link" href="{{ url()->previous() }}">Назад</a>
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="offer-title">{{ $internship->title }}</h2>
                    <h3 class="offer-organisation"><a href="{{ $internship->organisation['link'] }}" target="_blank">{{$internship->organisation['name']}}</a></h3>
                    <p class="offer-card-info location">{{ $internship->city->name }}</p>
                    <p class="offer-card-info portfolio">{{ $internship->speciality()->name }}</p>
                    <p class="offer-card-info user">Возраст: {{ $internship->age }}+</p>
                    <div class="offer-description">{!! $internship->description !!}</div>
                    <p class="offer-card-title">Контакты</p>
                    <p class="offer-card-info profile">{{ $internship->contact }}</p>
                    <p class="offer-card-info envelope">{{ $internship->email }}</p>
                    <p class="offer-card-info telephone">{{ $internship->phone }}</p>
                    <a class="btn btn-info offer-button" href="{{ route("site.whoisintern") }}">Что такое стажировка?</a>
                    <div class="offer-card-footer">
                        <p class="offer-card-date">Опубликовано {{ $internship->published_at->format('d.m.Y') }}</p>
                        <a href="/support?abuse=on" class="offer-card-abuse">Пожаловаться на объявление</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection