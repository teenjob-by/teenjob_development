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
        <h2 class="display-5">@lang('content.organisation.internTab')</h2>
            <div class="col-sm-8 offers-admin">
                @foreach($internships as $internship)
                    <div class="card mt-3 card-offer {{ ($internship->status == 3)? 'banned':''}}" style="padding: 20px">
                        <h3 class="offer-title">
                            <a href="/internship/{{ $internship->id }}">{{$internship->title}}</a>
                            @if($internship->organisation['status'] == 4)
                                <span class="approved"></span>
                            @endif

                            <table class="ml-auto">
                                <tr>
                                    <td> <a href="{{ route('admin.internship.approve', $internship->id)}}" class="{{ in_array($internship->status, [1, 2]) ? 'd-none': '' }} btn btn-enable"><i class="fa fa-globe" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.internshipForm', $internship->id)}}" class="btn btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.internship.ban', $internship->id)}}" class=" {{ in_array($internship->status, [3]) ? 'd-none': '' }} btn btn-disable"><i class="fa fa-ban" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.internship.remove', $internship->id)}}" class="btn btn-remove"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                </tr>
                            </table>
                        </h3>
                        <h4 class="offer-organisation"><a href="{{ $internship->organisation['link'] }}" target="_blank">{{$internship->organisation['name']}}</a></h4>
                        <p class="offer-description">{!! $internship->getPreviewDesc() !!}</p>

                        <div class="offer-footer">
                            <p class="offer-city">{{$internship->city->name}}</p>
                            <p class="offer-date">{{$internship->published_at->format('j F')}}</p>
                        </div>


                    </div>
                @endforeach
                    {{ $internships->appends($_GET)->links() }}




            </div>
        <div>
@endsection
