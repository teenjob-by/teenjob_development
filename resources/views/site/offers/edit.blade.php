@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h2 class="display-5">Редактировать обьявление</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif
            <form method="post" action="{{ route('offers.update', $offer->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group col-lg-6">

                    <label for="first_name">Название:</label>
                    <input type="text" class="form-control" name="first_name" value={{ $offer->title }} />
                </div>

                @error('title')
                    <div class="alert alert-danger">error</div>
                @enderror

                <div class="form-group col-lg-6">
                    <label for="last_name">Город:</label>
                    <input type="text" class="form-control" name="city" value={{ $offer->city }} />
                </div>

                <div class="form-group col-lg-6">
                    <label for="last_name">Адрес:</label>
                    <input type="text" class="form-control" name="address" value={{ $offer->address }} />
                </div>

                <div class="form-group col-lg-6">
                    <label for="city">Описание:</label>
                    <input type="text" class="form-control" name="description" value={{ $offer->description }} />
                </div>

                <div class="form-group col-lg-6">
                    <label for="city">Дата начала:</label>
                    <input type="text" class="form-control" name="date_start" value={{ $offer->date_start }} />
                </div>

                <div class="form-group col-lg-6">
                    <label for="city">Дата окончания:</label>
                    <input type="text" class="form-control" name="date_finish" value={{ $offer->date_finish }} />
                </div>

                <button type="submit" class="ml-3 btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
@endsection