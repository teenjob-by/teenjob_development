@extends('layouts.backend')

@section('content')
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

            </tbody>
        </table>
        <div>
@endsection
