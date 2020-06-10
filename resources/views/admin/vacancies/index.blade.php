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
        <h2 class="display-5">@lang('content.organisation.jobTab')</h2>
            <div class="col-sm-8 offers-admin">
                @foreach($jobs as $job)
                    <div class="card mt-3 card-offer {{ ($job->status == 3)? 'banned':''}}" style="padding: 20px">
                        <h3 class="offer-title">
                            <a href="/jobs-for-teens/{{ $job->id }}">{{$job->title}}</a>
                            @if($job->organisation['status'] == 4)
                                <span class="approved"></span>
                            @endif
                            <table class="ml-auto">
                                <tr>
                                    <td> <a href="{{ route('admin.jobs.approve', $job->id)}}" class="{{ in_array($job->status, [1, 2]) ? 'd-none': '' }} btn btn-enable"><i class="fa fa-globe" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.jobForm', $job->id)}}" class="btn btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.jobs.ban', $job->id)}}" class="{{ in_array($job->status, [3]) ? 'd-none': '' }} btn btn-disable"><i class="fa fa-ban" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.jobs.remove', $job->id)}}" class="btn btn-remove"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                </tr>
                            </table>

                        </h3>
                        <h4 class="offer-organisation"><a href="{{ $job->organisation['link'] }}" target="_blank">{{$job->organisation['name']}}</a></h4>
                        <p class="offer-description">{!! $job->getPreviewDesc() !!}</p>

                        <div class="offer-footer">
                            <p class="offer-city">{{$job->city->name}}</p>
                            <p class="offer-date">{{$job->published_at->format('j F')}}</p>
                        </div>

                        <div class="offer-actions">

                        </div>
                    </div>
                @endforeach

                    {{ $jobs->appends($_GET)->links() }}




            </div>
        <div>
@endsection
