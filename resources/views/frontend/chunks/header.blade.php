<header id="header" class="header {{ (request()->routeIs('frontend.home')) ? 'header_bg-desktop' : '' }} {{ (request()->routeIs('auth.login') || request()->routeIs('auth.register')) ? 'header-compact': '' }}">
    <section class="header_menu-wrapper">
        <div class="header_wrapper">
            <h1 class="header_logo">
                <a href="{{ route('frontend.home') }}">
                    <img class="header_logo-image" src="/images/logo.svg" alt="{{ config('app.name', 'teenjob') }}">
                </a>
            </h1>

            <nav>
                <a class="burger">
                    <i class="burger-icon"></i>
                </a>
                <ul class="header_menu">

                    @for($i = 1; $i <= 4; $i++)
                        <li class="header_menu-item">
                            <a class="header_menu-link" href="@lang('header.link_'.$i)">@lang('header.navlink_'.$i)</a>
                        </li>
                    @endfor

                    @guest
                        <li class="header_menu-item">
                            <a class="header_menu-link" href="{{ route('auth.login') }}">
                                <strong>@lang('header.navlink_11')</strong>
                            </a>
                        </li>
                    @else

                        <li class="header_menu-item">

                        @if(\Illuminate\Support\Facades\Auth::user()->role)
                            <a class="header_menu-link" href="{{ route('organisation.index') }}">
                                <strong> @lang('header.cabinet')</strong>
                            </a>
                        @else
                            <div class="header_menu-item-admin">
                                <a class="header_menu-link" href="{{ route('organisation.index') }}">
                                    <strong> @lang('header.cabinet')</strong>
                                </a>
                                <a class="header_menu-link" href="{{ route('admin.index') }}">
                                    <strong> @lang('header.panel')</strong>
                                </a>
                            </div>
                        @endif

                        <a class="header_menu-link account-delimiter">|</a>
                        <a class="header_menu-link account-logout" href="{{ route('auth.logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                             @lang('header.quit')
                        </a>
                        </li>
                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest



                    <div class="language-panel">
                        @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                                <div>
                                    <a class="language-panel_link" href="{{ route('lang.switch', $lang) }}">
                                        <strong>{{ $language }}</strong>
                                    </a>
                                </div>
                            @else
                                <div>
                                    <a class="language-panel_link-selected" href="{{ route('lang.switch', $lang) }}">
                                        <strong>{{ $language }}</strong>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>

                </ul>
            </nav>
        </div>
    </section>

    @if (request()->routeIs('frontend.home') || request()->routeIs('auth.login') || request()->routeIs('auth.register'))
        <section class="header_search-wrapper">

            @if (request()->routeIs('frontend.home'))
                <h2 class="header_slogan">
                    @lang('header.title')
                </h2>
                <h2 class="header_subtitle">
                    @lang('header.subtitle')
                </h2>
            @endif
            <div class="search-form-wrapper">
                <select id="search-select" class="justselect search-form-wrapper_select" name="category">
                    <option {{ (request()->routeIs('frontend.home') || request()->routeIs('auth.login') || request()->routeIs('auth.register') || request()->routeIs('frontend.jobs-for-teens'))? 'selected': ''}} class="dropdown-item" value="/jobs-for-teens">@lang('header.search.navlink_1')</option>
                    <option {{ (request()->get('section') == 'volunteering')? 'selected': ''}} class="dropdown-item" value="/volunteerings-for-teens?section=voluneering">@lang('header.search.navlink_2')</option>
                    <option {{ (request()->get('section') == 'internship')? 'selected': ''}} class="dropdown-item" value="/volunteerings-for-teens?section=internship">@lang('header.search.navlink_3')</option>
                    <option {{ request()->routeIs('frontend.events')? 'selected': ''}} class="dropdown-item" value="/events">@lang('header.search.navlink_4')</option>
                </select>

                <form id="desktop-search" class="header_search-form desktop-search" method="get">

                    <input type="text" minlength="3" class="textfield-search search-form-wrapper_input" name="query" placeholder="{{ trans('header.search_placeholder' )}}" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">

                    <button class="button-secondary search-form-wrapper_button" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>



            @if(Route::getCurrentRoute()->uri() == '/')
                <div class='buttons-wrapper'>
                    <a class="button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLScxqBqJT8hcfKPa0jzAb_XYKP8XR7HEFJe2tQFKMh3KZL2h7Q/viewform"><span class="button-title">@lang('header.button_1.title')</span><span class="button-text">@lang('header.button_1.text')</span></a>
                    <a class="button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSdAYxXLNuyauPn7Bi-rhhnF9T7hnAnfCgzp7sgPW0wKRQtGmg/viewform"><span class="button-title">@lang('header.button_2.title')</span><span class="button-text">@lang('header.button_2.text')</span></a>
                </div>
            @endif
        </section>

        @if(Route::getCurrentRoute()->uri() == '/')
            <a class="button-primary button-mobile-second" href="https://docs.google.com/forms/d/e/1FAIpQLSdAYxXLNuyauPn7Bi-rhhnF9T7hnAnfCgzp7sgPW0wKRQtGmg/viewform" >
                <span>@lang('header.navlink_9')</span>
            </a>
            <a class="button-primary button-mobile-first" href="https://docs.google.com/forms/d/e/1FAIpQLScxqBqJT8hcfKPa0jzAb_XYKP8XR7HEFJe2tQFKMh3KZL2h7Q/viewform " >
                <span>@lang('header.navlink_4')</span>
            </a>
        @endif
    @endif

</header>