@extends('layouts.site')

@section('body_class', 'page-home')

@section('content')
    <div class="container auth">

        <div class="row justify-content-center">
            <h3>{{ __('Подтверждение вашей почты') }}</h3>

            <hr align="center" width="627" color="lightgray" />

            
                <p>
                    {{ __('Ваша почта подтверждена') }}
                </p>
            

            <p>
                
                <br><a href="/organisation">{{ __('Войти в личный кабинет')}}</a><br>
            </p>
        </div>
    </div>



@endsection