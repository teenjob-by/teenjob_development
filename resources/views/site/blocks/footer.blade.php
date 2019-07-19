<div class="footer">
    <div class="container wrapper">
        <div class="row">
            <div class="col-lg-1">
                <img class="logo-footer" src="images/footer-logo.svg">
            </div>
            <div class="offset-lg-3 col-lg-5">
                <ul>
                    <li>
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">@lang('footer.navlink_1')</a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">@lang('footer.navlink_2')</a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('conditions') }}">@lang('footer.navlink_3')</a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">@lang('footer.navlink_4')</a>
                    </li>
                </ul>
            </div>
            <div class="offset-lg-1 col-lg-2">
                <div class="row">
                    <p class="footer-social-title">@lang('footer.social.title')</p>
                </div>
                <div class="row">
                    <i class="fab fa-telegram-plane"></i>
                </div>
            </div>
        </div>
    </div>
</div>