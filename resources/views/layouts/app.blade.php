<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app-admin">
        <nav class="navbar navbar-admin navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">@lang('content.admin.login')</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">@lang('content.admin.register')</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('organisation') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       @lang('content.admin.add')
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        @lang('content.admin.logout')
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>



        <main class="py-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="sidebar-wrapper">
                        <div class="bg-light border-right" id="sidebar-wrapper">
                            <div class="sidebar-heading">@lang('content.admin.menu')</div>
                            <div class="list-group list-group-flush">
                                <a href="/admin/volunteerings" class="list-group-item list-group-item-action bg-light {{ request()->routeIs('admin.volunteering') ? 'active' : '' }}">@lang('content.admin.volunteering')</a>
                                <a href="/admin/volunteerings/moderation" class="list-group-item list-group-item-action bg-light {{ request()->routeIs('admin.volunteering.moderation') ? 'active' : '' }}">@lang('content.admin.volunteeringModerate')</a>
                                <a href="/admin/internships-for-teens" class="list-group-item list-group-item-action bg-light {{ request()->routeIs('admin.internship') ? 'active' : '' }}">@lang('content.admin.internship')</a>
                                <a href="/admin/internships-for-teens/moderation" class="list-group-item list-group-item-action bg-light {{ request()->routeIs('admin.internship.moderation') ? 'active' : '' }}">@lang('content.admin.internshipModerate')</a>
                                <a href="/admin/jobs-for-teens" class="list-group-item list-group-item-action bg-light {{ request()->routeIs('admin.vacancy') ? 'active' : '' }}">@lang('content.admin.vacancy')</a>
                                <a href="/admin/jobs-for-teens/moderation" class="list-group-item list-group-item-action bg-light {{ request()->routeIs('admin.vacancy.moderation') ? 'active' : '' }}">@lang('content.admin.vacancyModerate')</a>
                                <a href="/admin/events" class="list-group-item list-group-item-action bg-light {{ request()->routeIs('admin.events') ? 'active' : '' }}">@lang('content.admin.event')</a>
                                <a href="/admin/events/moderation" class="list-group-item list-group-item-action bg-light {{ request()->routeIs('admin.events.moderation') ? 'active' : '' }}">@lang('content.admin.eventModerate')</a>
                                <a href="/admin/organisations" class="list-group-item list-group-item-action bg-light {{ (request()->routeIs('admin.organisation') || request()->routeIs('admin') ) ? 'active' : '' }}">@lang('content.admin.organisation')</a>
                                <a href="/admin/organisations/moderation" class="list-group-item list-group-item-action bg-light {{ request()->routeIs('admin.organisation.moderation') ? 'active' : '' }}">@lang('content.admin.organisationModerate')</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 items-wrapper">@yield('content')</div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
