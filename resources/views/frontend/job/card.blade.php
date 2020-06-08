@extends('layouts.frontend')

@section('seo_meta')
    <meta name="description" content="{!!  $data->getSeoMeta() !!}"/>
    <meta name="language" content="RU"/>

    <title>{{ $data->title }}</title>
@endsection

@section('content')

    <section class="job_section">
        <div class="content-wrapper">
            <div class="job_description-wrapper">
                <a class="back-link" href="{{ url()->previous() }}">@lang('content.job.card.back')</a>
                <h3 class="job_description-title">{{ $data->title }}</h3>
                <h4 class="job_description-organisation"><a href="{{ $data->organisation['link'] }}" target="_blank">{{$data->organisation['name']}}</a></h4>
                <p class="job_description-info location">{{ $data->city->name }}</p>
                <p class="job_description-info portfolio">{{ $data->speciality()->name }}</p>
                <p class="job_description-info user">@lang('content.job.card.age') {{ $data->age }}</p>

                @if(!empty($data->salary))
                    <p class="job_description-info salary">@lang('content.job.card.salary') {{ $data->salary }} {{ $data->salaryType->name}}</p>
                @endif
                <p class="job_description-info job-time">@lang('content.job.card.job-time') {{ $data->workTimeType->name }}</p>
                <div class="job_description-text">{!! $data->description !!}</div>
                <p class="job_description-contacts-title">@lang('content.job.card.contacts')</p>
                <p class="job_description-info profile">{{ $data->contact }}</p>
                <p class="job_description-info envelope">{{ $data->email }}</p>
                <p class="job_description-info telephone">{{ $data->phone }}</p>
                @if(!empty($data->alt_phone))
                    <p class="job_description-info alt-contact">{{ $data->alt_phone }}</p>
                @endif
                <a class="button-info" href="{{ route("frontend.employmentLaw") }}"><span>@lang('content.job.card.whatIs')</span></a>
                <div class="job_description-footer">
                    <p class="job_description-date">@lang('content.job.card.published') {{ $data->published_at->format('d.m.Y') }}</p>
                    <a href="{{ route("frontend.feedback") }}?abuse=on" class="job_description-abuse">@lang('content.job.card.abuse')</a>
                </div>
            </div>
        </div>
    </section>

@endsection