<div class="header {{ request()->routeIs('home') ? 'bg-3' : 'bg-inner' }} ">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" alt="{{ config('app.name', 'teenjob') }}"><img src="/images/logo.png"></a>
            <div class="collapse menu-collapse navbar-collapse" id="navbarsMain">
                <div class="navbar-nav ml-auto">
                    <a class="nav-link {{ ((app('request')->input('vacancy') == 'on') || (app('request')->input('internship') == 'on') || (app('request')->input('volunteering') == 'on')) ? 'active' : '' }}" href="{{ route('site.offers') }}">
                        @lang('header.navlink_7')
                    </a>
                    <a class="nav-link {{ request()->routeIs('site.events') ? 'active' : '' }}"
                       href="{{ route('site.events') }}">@lang('header.navlink_3')</a>
                    <a class="nav-link {{ request()->routeIs('site.howsupport') ? 'active' : '' }}"
                       href="{{ route('site.howsupport') }}">@lang('header.navlink_4')</a>
                    <a class="nav-link {{ request()->routeIs('site.support') ? 'active' : '' }}"
                       href="{{ route('site.feedback') }}">@lang('header.navlink_8')</a>

                    @guest
                        <div class="nav-item">
                            <a class="nav-link login-link" href="{{ route('login') }}"><strong>@lang('header.navlink_10')</strong></a>
                        </div>
                    @else

                        @if(\Illuminate\Support\Facades\Auth::user()->role)
                            <a class="nav-link" href="{{ route('organisation') }}"><strong>@lang('header.cabinet')</strong></a>
                        @else
                            <a class="nav-link" href="{{ route('admin') }}"><strong>@lang('header.panel')</strong></a>
                        @endif

                        <a class="nav-link account-delimiter">/</a>
                        <a class="nav-link account-logout" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                 @lang('header.quit')
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest

                    <div class="language-panel">
                        @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                                <div>
                                    <a class="language-panel_link" href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                                </div>
                            @else
                                <div>
                                    <a class="language-panel_link-selected" href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
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
                        <option selected class="dropdown-item" {{((app('request')->input('volunteering') == 'on') && (app('request')->input('internship') == 'on') && (app('request')->input('vacancy') == 'on'))? 'selected': ''}} value="offers">@lang('header.categories')</option>
                        <option {{((app('request')->input('vacancy') == 'on') && (app('request')->input('internship') !== 'on') && (app('request')->input('volunteering') !== 'on'))? 'selected': ''}} class="dropdown-item" value="vacancy">@lang('header.navlink_6')</option>
                        <option {{((app('request')->input('internship') == 'on') && (app('request')->input('volunteering') !== 'on') && (app('request')->input('vacancy') !== 'on'))? 'selected': ''}} class="dropdown-item" value="internship">@lang('header.navlink_1')</option>
                        <option {{((app('request')->input('volunteering') == 'on') && (app('request')->input('internship') !== 'on') && (app('request')->input('vacancy') !== 'on'))? 'selected': ''}} class="dropdown-item" value="volunteering">@lang('header.navlink_2')</option>
                        <option {{request()->routeIs('site.events')? 'selected': ''}} class="dropdown-item" value="events">@lang('header.navlink_3')</option>
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
        <div class='buttons-wrapper'>
            <a class="btn volunteers-desktop-button" href="https://teenjob.by/login"><span>@lang('header.navlink_5')</span></a>
            <a class="btn volunteers-desktop-button" href="https://teenjob.by/login"><span>@lang('header.navlink_9')</span></a>
        </div>
        @endif


            @if(!((app('request')->input('volunteering') == 'on') || (app('request')->input('internship') == 'on') || (request()->routeIs('site.events')) || (app('request')->input('vacancy') == 'on')))
                @if(Route::getCurrentRoute()->uri() == '/')

                    <div class="mobile-categories">

                        <a class="mobile-categories-button" href="/volunteering">
                            <span>
                                @lang('header.navlink_7')
                            </span>
                        </a>

                        <a class="mobile-categories-button" href="/events">
                            <span>
                                @lang('header.navlink_3')
                            </span>
                        </a>

                    </div>
                @endif
            @else
                <form id="main-mobile-search" class="search-box mobile-search" method="get" action="{{ route('site.search') }}">
                    <div class="input-group mb-3">

                        @if((app('request')->input('volunteering') == 'on') && (app('request')->input('internship') == 'on') && (app('request')->input('vacancy') == 'on'))
                            <input type="hidden" name="category" value="offers">
                            <input type="hidden" name="volunteering" value="on">
                            <input type="hidden" name="internship" value="on">
                            <input type="hidden" name="vacancy" value="on">
                        @elseif(app('request')->input('volunteering') == 'on')
                            <input type="hidden" name="volunteering" value="on">
                            <input type="hidden" name="category" value="offers">
                        @elseif(app('request')->input('internship') == 'on')
                            <input type="hidden" name="internship" value="on">
                            <input type="hidden" name="category" value="offers">
                        @elseif(app('request')->input('vacancy') == 'on')
                            <input type="hidden" name="vacancy" value="on">
                            <input type="hidden" name="category" value="offers">
                        @elseif(request()->routeIs('site.events'))
                            <input type="hidden" name="category" value="events">
                        @endif

                        @if((app('request')->input('volunteering') == 'on') && (app('request')->input('internship') == 'on') && (app('request')->input('vacancy') == 'on'))
                            <input type="text" class="form-control search-input" name="query" placeholder="@lang('header.placeholder_0')" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
                        @elseif(app('request')->input('volunteering') == 'on')
                            <input type="text" class="form-control search-input" name="query" placeholder="@lang('header.placeholder_1')" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
                        @elseif(app('request')->input('internship') == 'on')
                            <input type="text" class="form-control search-input" name="query" placeholder="@lang('header.placeholder_2')" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
                        @elseif(request()->routeIs('site.events'))
                            <input type="text" class="form-control search-input" name="query" placeholder="@lang('header.placeholder_3')" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
                        @elseif(request()->routeIs('site.vacancy'))
                            <input type="text" class="form-control search-input" name="query" placeholder="@lang('header.placeholder_4')" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
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
        <a class="btn volunteers-mobile-button" href="https://teenjob.by/login" >
            <span>@lang('header.navlink_9')</span>
        </a>
        <a class="btn volunteers-mobile-button volunteers-mobile-button--2" href="https://teenjob.by/login" >
            <span>@lang('header.navlink_9')</span>
        </a>
    @endif
</div>
