<div class="header {{ request()->routeIs('home') ? 'bg-1' : '' }} {{ request()->routeIs('conditions') ? 'bg-2' : '' }}">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" alt="{{ config('app.name', 'teenjob') }}"><img src="images/logo.png"></a>

            <div class="collapse navbar-collapse" id="navbarsMain">
                <div class="navbar-nav ml-auto">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        @lang('header.navlink_1')
                    </a>
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">@lang('header.navlink_2')</a>
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">@lang('header.navlink_3')</a>
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">@lang('header.navlink_4')</a>
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}"><strong>@lang('header.navlink_5')</strong></a>
                </div>
            </div>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsMain" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="search-wrapper">

        @if (request()->routeIs('home'))
            <p class="title">
                @lang('header.title')
            </p>
        @endif


        <div class="search-box">
            <div class="input-group mb-3">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle category-dropdown" type="button" id="categoryDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Категории
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Стажировка</a>
                        <a class="dropdown-item" href="#">Волонтерство</a>
                        <a class="dropdown-item" href="#">Мероприятия</a>
                    </div>
                </div>
                <input type="text" class="form-control search-input" placeholder="{{ request()->routeIs('home') ? trans('header.search_placeholder') : trans('header.search_placeholder_alter') }}">
                <div class="input-group-append">
                    <button class="btn btn-success btn-search" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>