@extends('layouts.frontend')

@section('content')
    <section class="reset_section">
        <div class="reset-wrapper">

            <h3 class="login_title">@lang('auth.password.resetTitle')</h3>
            <p class="login_subtitle">@lang('auth.login.subtitle')</p>

            <form class="reset_form" method="POST" action="{{ route('auth.password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="reset_form-group">
                    <label for="email" class="login_form-group-label">@lang('auth.password.emailRequest')</label>
                    <input id="email" class="login_form-group-input @error('email') is-invalid @enderror" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus minlength="3">

                    @error('email')
                    <span class="login-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="button-secondary">
                    <span>
                        @lang('auth.password.resetPassword')
                    </span>
                </button>


                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">@lang('auth.password.newPassword')</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('auth.password.repeatPassword')</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>


            </form>

        </div>
    </section>

@endsection
