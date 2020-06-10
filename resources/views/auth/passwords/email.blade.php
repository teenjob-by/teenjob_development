@extends('layouts.frontend')

@section('content')
    <section class="reset_section">
        <div class="reset-wrapper">
            <h3 class="reset_title">@lang('auth.password.reset')</h3>

            @if (session('status'))
                <p class="login_subtitle">{{ session('status') }}</p>
            @endif

            <form class="reset_form" method="POST" action="{{ route('auth.password.email') }}">
                @csrf

                <div class="reset_form-group">
                    <label for="email" class="login_form-group-label">@lang('auth.password.email')</label>
                    <input id="email" class="login_form-group-input @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus minlength="3">

                    @error('email')
                        <span class="login-invalid" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="button-secondary">
                    <span>
                        @lang('auth.password.resetSubmit')
                    </span>
                </button>
            </form>
        </div>

    </section>
@endsection
