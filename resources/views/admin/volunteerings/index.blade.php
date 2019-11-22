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
        <h2 class="display-5">Волонтерство</h2>
            <div class="col-sm-8 offers-admin">
                @foreach($volunteerings as $volunteering)
                    <div class="card mt-3 card-offer {{ ($volunteering->status == 3)? 'banned':''}}" style="padding: 20px">
                        <h3 class="offer-title">
                            <a href="/volunteering/{{ $volunteering->id }}">{{$volunteering->title}}</a>
                            @if($volunteering->organisation['status'] == 4)
                                <span class="approved"></span>
                            @endif
                            <table class="ml-auto">
                                <tr>
                                    <td> <a href="{{ route('admin.volunteerings.approve', $volunteering->id)}}" class="{{ in_array($volunteering->status, [1, 2]) ? 'd-none': '' }} btn btn-enable"><i class="fa fa-globe" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.volunteeringForm', $volunteering->id)}}" class="btn btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.volunteerings.ban', $volunteering->id)}}" class="{{ in_array($volunteering->status, [3]) ? 'd-none': '' }} btn btn-disable"><i class="fa fa-ban" aria-hidden="true"></i></a></td>

                                    <td><a href="{{ route('admin.volunteerings.remove', $volunteering->id)}}" class="btn btn-remove"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                </tr>
                            </table>

                        </h3>
                        <h4 class="offer-organisation"><a href="{{ $volunteering->organisation['link'] }}" target="_blank">{{$volunteering->organisation['name']}}</a></h4>
                        <p class="offer-description">{!! $volunteering->getPreviewDesc() !!}</p>

                        <div class="offer-footer">
                            <p class="offer-city">{{$volunteering->city->name}}</p>
                            <p class="offer-date">{{$volunteering->published_at->format('j F')}}</p>
                        </div>

                        <div class="offer-actions">

                        </div>
                    </div>
                @endforeach

                    {{ $volunteerings->appends($_GET)->links() }}




            </div>
        <div>
@endsection
