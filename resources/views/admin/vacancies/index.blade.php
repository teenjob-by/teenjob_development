@extends('layouts.app')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="uper">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <h2 class="display-5">@lang('content.organisation.vacancyTab')</h2>
            <div class="col-sm-8 offers-admin">
                @foreach($vacancies as $vacancy)
                    <div class="card mt-3 card-offer {{ ($vacancy->status == 3)? 'banned':''}}" style="padding: 20px">
                        <h3 class="offer-title">
                            <a href="/vacancy/{{ $vacancy->id }}">{{$vacancy->title}}</a>
                            @if($vacancy->organisation['status'] == 4)
                                <span class="approved"></span>
                            @endif
                            <table class="ml-auto">
                                <tr>
                                    <td> <a href="{{ route('admin.vacancies.approve', $vacancy->id)}}" class="{{ in_array($vacancy->status, [1, 2]) ? 'd-none': '' }} btn btn-enable"><i class="fa fa-globe" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.vacancyForm', $vacancy->id)}}" class="btn btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.vacancies.ban', $vacancy->id)}}" class="{{ in_array($vacancy->status, [3]) ? 'd-none': '' }} btn btn-disable"><i class="fa fa-ban" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.vacancies.remove', $vacancy->id)}}" class="btn btn-remove"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                </tr>
                            </table>

                        </h3>
                        <h4 class="offer-organisation"><a href="{{ $vacancy->organisation['link'] }}" target="_blank">{{$vacancy->organisation['name']}}</a></h4>
                        <p class="offer-description">{!! $vacancy->getPreviewDesc() !!}</p>

                        <div class="offer-footer">
                            <p class="offer-city">{{$vacancy->city->name}}</p>
                            <p class="offer-date">{{$vacancy->published_at->format('j F')}}</p>
                        </div>

                        <div class="offer-actions">

                        </div>
                    </div>
                @endforeach

                    {{ $vacancies->appends($_GET)->links() }}




            </div>
        <div>
@endsection
