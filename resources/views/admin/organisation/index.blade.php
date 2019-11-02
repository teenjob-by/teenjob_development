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
        <h2 class="display-5">Список организаций</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <td class="id">ID</td>
                <td class="name">Название</td>
                <td class="type">Тип организации</td>
                <td class="unp">УНП</td>
                <td class="site">Сайт/Группа</td>
                <td class="email">Email</td>
                <td class="phone">Телефон</td>
                <td class="request">Запрос на изменение</td>
                <td colspan="4">Действия</td>
            </tr>
            </thead>
            <tbody>
                @if(!empty($organisations))
                    @foreach($organisations as $organisation)
                        @if(!($organisation->status == 1))
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
                                <a href="{{ route('admin.organisations.approve', $organisation->id)}}" class="btn btn-enable"><i class="fa fa-globe" aria-hidden="true"></i></a>
                                <a href="{{ route('admin.organisationForm', $organisation->id)}}" class="btn btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="{{ route('admin.organisations.ban', $organisation->id)}}" class="btn btn-disable"><i class="fa fa-ban" aria-hidden="true"></i></a>
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
