@extends('layouts.site')

@section('content')
    <div class="container-fluid organisation organisation-form">
        <div class="container">

            <form method="POST" action="{{ route('update') }}">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3>@lang('content.organisationForm.title')</h3>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-lg-5 col-sm-12 col-form-label padding-0">@lang('content.organisationForm.email')</label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="text" readonly style="background-color: #828282;" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $organisation->email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="link" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisationForm.additionalEmail')</label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="alt_email" value="{{ $organisation->alt_email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisationForm.phone')</label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $organisation->phone }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="request" class="col-lg-5 col-sm-12 col-form-label">@lang('content.organisationForm.request')</label>
                            <div class="col-sm-12 col-lg-7">
                                <textarea type="text" maxlength="250" class="form-control @error('request') is-invalid @enderror " name="request" placeholder="@lang('content.organisationForm.requestPlaceholder')">{{ $organisation->request }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="offset-lg-3 col-lg-9 col-sm-12">
                                <h2>@lang('content.organisationForm.passwordTitle')</h2>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-12 col-lg-5 col-form-label">@lang('content.organisationForm.passwordNew')</label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="password" class="form-control @error('password') is-invalid @enderror " name="password" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-12 col-lg-5 col-form-label">@lang('content.organisationForm.passwordRepeat')</label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror " name="password_confirmation" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="tip">@lang('content.organisationForm.remind')</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="current_password" class="col-sm-12 col-lg-5 col-form-label"><strong>@lang('content.organisationForm.confirmation')</strong></label>
                            <div class="col-sm-12 col-lg-7">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <button type="submit" class="btn btn-success mx-auto">@lang('content.organisationForm.save')</button>
                        </div>
                        <div class="form-group row">
                            <a class="mx-auto remove" onclick='showModal()'>@lang('content.organisationForm.remove')</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="alert" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('content.organisationForm.modal.title')</h4>
                    <button type="button" class="close" onclick="closeModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>@lang('content.organisationForm.modal.description')</p>
                </div>
                <div class="form-group row">
                    <a class="mx-auto remove" href="{{ '/organisation/destroy' }} ">@lang('content.organisationForm.remove')</a>
                </div>
            </div>

        </div>
    </div>
@endsection
