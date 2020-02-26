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
        <h2 class="display-5">@lang('admin.organisations_title')</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <td>@lang('admin.organisations_id')</td>
                <td>@lang('admin.organisations_name')</td>
                <td>@lang('admin.organisations_type')</td>
                <td>@lang('admin.organisations_unp')</td>
                <td>@lang('admin.organisations_site')</td>
                <td>@lang('admin.organisations_email')</td>
                <td>@lang('admin.organisations_phone')</td>
                <td>@lang('admin.organisations_request')</td>
                <td colspan="4">@lang('admin.organisations_actions')</td>
            </tr>
            </thead>
            <tbody>
            @foreach($organisations as $organisation)
                @if(!($organisation->status == 1))
                    <tr style="background:lightcoral">
                @else
                    <tr>
                        @endif
                        <td>{{$organisation->id}}</td>
                        <td>{{$organisation->name}}</td>
                        <td>{{$organisation->type}}</td>
                        <td>{{$organisation->unique_identifier}}</td>
                        <td>{{$organisation->link}}</td>
                        <td>{{$organisation->email}}</td>
                        <td>{{$organisation->phone}}</td>
                        <td>{{$organisation->request}}</td>
                        <td>
                            <a href="{{ route('admin.organisations.approve', $organisation->id)}}" class="btn btn-enable"><i class="fa fa-globe" aria-hidden="true"></i></a>
                            <a href="{{ route('admin.organisationForm', $organisation->id)}}" class="btn btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a href="{{ route('admin.organisations.ban', $organisation->id)}}" class="btn btn-disable"><i class="fa fa-ban" aria-hidden="true"></i></a>
                            <a href="{{ route('admin.organisations.remove', $organisation->id)}}" class="btn btn-remove"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        <div>
@endsection
