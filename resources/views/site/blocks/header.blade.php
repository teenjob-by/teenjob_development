<div class="header {{ request()->routeIs('home') ? 'bg-1' : 'bg-2' }} ">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" alt="{{ config('app.name', 'teenjob') }}"><img src="/images/logo.png"></a>
            <div class="collapse navbar-collapse" id="navbarsMain">
                <div class="navbar-nav ml-auto">
                    <a class="nav-link {{ (app('request')->input('internship') == 'on') ? 'active' : '' }}" href="{{ route('site.offers', ['internship' => 'on']) }}">
                        @lang('header.navlink_1')
                    </a>
                    <a class="nav-link {{ (app('request')->input('volunteering') == 'on') ? 'active' : '' }}"
                       href="{{ route('site.offers', ['volunteering' => 'on']) }}"><span>@lang('header.navlink_2')</span></a>
                    <a class="nav-link {{ request()->routeIs('site.events') ? 'active' : '' }}"
                       href="{{ route('site.events') }}">@lang('header.navlink_3')</a>
                    <a class="nav-link {{ request()->routeIs('site.howsupport') ? 'active' : '' }}"
                       href="{{ route('site.howsupport') }}">@lang('header.navlink_4')</a>

                    @guest
                        <div class="nav-item">
                            <a class="nav-link login-link" href="{{ route('login') }}"><strong>@lang('header.navlink_5')</strong><p>вход для организаций</p></a>
                        </div>
                    @else

                        @if(\Illuminate\Support\Facades\Auth::user()->role)
                            <a class="nav-link" href="{{ route('organisation') }}"><strong>Личный кабинет</strong></a>
                        @else
                            <a class="nav-link" href="{{ route('admin') }}"><strong>Панель управления</strong></a>
                        @endif

                        <a class="nav-link account-delimiter">/</a>
                        <a class="nav-link account-logout" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                 Выйти
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
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


        <form id="main-search" class="search-box desktop-search" method="get" action="{{ route('site.search') }}">
            <div class="input-group mb-3">
                <div class="dropdown">
                    <select class="dropdown-menu category-dropdown" name="category">
                        <option selected class="dropdown-item" {{((app('request')->input('volunteering') == 'on') && (app('request')->input('internship') == 'on'))? 'selected': ''}} value="offers">Категории</option>
                        <option {{((app('request')->input('internship') == 'on') && (app('request')->input('volunteering') !== 'on'))? 'selected': ''}} class="dropdown-item" value="internship">Стажировка</option>
                        <option {{((app('request')->input('volunteering') == 'on') && (app('request')->input('internship') !== 'on'))? 'selected': ''}} class="dropdown-item" value="volunteering">Волонтерство</option>
                        <option {{request()->routeIs('site.events')? 'selected': ''}} class="dropdown-item" value="events">Мероприятия</option>
                    </select>
                </div>
                <input type="text" class="form-control search-input" name="query" placeholder="{{ trans('header.search_placeholder' )}}" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
                <div class="input-group-append">
                    <button class="btn btn-success btn-search" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

        </form>
        @if(Route::getCurrentRoute()->uri() == '/')
            <a class="btn volunteers-desktop-button" href="https://docs.google.com/forms/d/e/1FAIpQLSdeE3yE-I0GkDdwDbMc0cddLWCryaoYb3iL0QJftnJ_NHdzaQ/viewform" target="_blank"><span>Пройти опрос: что с образованием?</span></a>
        @endif


            @if(!((app('request')->input('volunteering') == 'on') || (app('request')->input('internship') == 'on') || (request()->routeIs('site.events'))))
                @if(!(Str::contains(Route::getCurrentRoute()->uri(), 'organisation')))

                    <div class="mobile-categories {{ (Route::getCurrentRoute()->uri() != '/') ? "mobile-categories-string" : "" }}">
                        <a class="mobile-categories-button" href="/offers?volunteering=on">
                    <span>
                        Волонтерство
                    </span>
                        </a>
                        <a class="mobile-categories-button" href="/offers?internship=on">
                    <span>
                        Стажировки
                    </span>
                        </a>
                        <a class="mobile-categories-button" href="/events">
                    <span>
                        Мероприятия
                    </span>
                        </a>
                    </div>
                @endif
            @else
                <form id="main-mobile-search" class="search-box mobile-search" method="get" action="{{ route('site.search') }}">
                    <div class="input-group mb-3">

                        @if((app('request')->input('volunteering') == 'on') && (app('request')->input('internship') == 'on'))
                            <input type="hidden" name="category" value="offers">
                            <input type="hidden" name="volunteering" value="on">
                            <input type="hidden" name="internship" value="on">
                        @elseif(app('request')->input('volunteering') == 'on')
                            <input type="hidden" name="volunteering" value="on">
                            <input type="hidden" name="category" value="offers">
                        @elseif(app('request')->input('internship') == 'on')
                            <input type="hidden" name="internship" value="on">
                            <input type="hidden" name="category" value="offers">
                        @elseif(request()->routeIs('site.events'))
                            <input type="hidden" name="category" value="events">
                        @endif

                        @if((app('request')->input('volunteering') == 'on') && (app('request')->input('internship') == 'on'))
                            <input type="text" class="form-control search-input" name="query" placeholder="Поиск волонтерства и стажировок" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
                        @elseif(app('request')->input('volunteering') == 'on')
                            <input type="text" class="form-control search-input" name="query" placeholder="Поиск волонтерства" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
                        @elseif(app('request')->input('internship') == 'on')
                            <input type="text" class="form-control search-input" name="query" placeholder="Поиск стажировок" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
                        @elseif(request()->routeIs('site.events'))
                                <input type="text" class="form-control search-input" name="query" placeholder="Поиск мероприятий" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
                        @endif

                        <div class="input-group-append">
                            <button class="btn btn-success btn-search" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            @endif


    </div>

    @if(Route::getCurrentRoute()->uri() == '/')
        <a class="btn volunteers-mobile-button" href="https://docs.google.com/forms/d/e/1FAIpQLSdeE3yE-I0GkDdwDbMc0cddLWCryaoYb3iL0QJftnJ_NHdzaQ/viewform" target="_blank"><span>Пройти опрос: что с образованием?</span></a>
    @endif
</div>
