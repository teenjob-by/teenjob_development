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
                @if(!empty($organisations))
                    @foreach($organisations as $organisation)
                        @if($organisation->status == 3)
                            <tr style="background:lightcoral">
                        @else
                            <tr>
                        @endif
                            <td class="id">{{$organisation->id}}</td>
                            <td class="name">{{$organisation->name}}</td>
                            <td class="type">{{$organisation->getType->name}}</td>
                            <td class="unp">{{$organisation->unique_identifier}}</td>
                            <td class="site"><a href="{{$organisation->link}}">{{$organisation->link}}</a></td>
                            <td class="email">{{$organisation->email}}</td>
                            <td class="phone">{{$organisation->phone}}</td>
                            <td class="request">{{$organisation->request}}</td>
                            <td>
                                <a href="{{ route('admin.organisations.approve', $organisation->id)}}" class=" {{ in_array($organisation->status, [1, 2]) ? 'd-none': '' }} btn btn-enable"><i class="fa fa-globe" aria-hidden="true"></i></a>
                                <a href="{{ route('admin.organisationForm', $organisation->id)}}" class="btn btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="{{ route('admin.organisations.ban', $organisation->id)}}" class="{{ in_array($organisation->status, [3]) ? 'd-none': '' }} btn btn-disable" ><i class="fa fa-ban" aria-hidden="true"></i></a>
                                <a href="{{ route('admin.organisations.remove', $organisation->id)}}" class="btn btn-remove"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            <h2>Ничего не найдено</h2>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div>
@endsection
