<footer class="footer">
    <div class="footer_wrapper">


        <a class="footer_logo-mobile" href="/">
            <img class="image" src="/images/footer-logo-mobile.svg">
        </a>
        <a class="footer_logo-desktop" href="/">
            <img class="image" src="/images/footer-logo-desktop.svg">
        </a>


        <ul class="footer_nav">
            <li>
                <a class="footer_nav-link" href="{{ route('frontend.aboutUs') }}">@lang('footer.navlink_1')</a>
            </li>
            <li>
                <a class="footer_nav-link" href="{{ route('frontend.supportUs') }}">@lang('footer.navlink_2')</a>
            </li>
            <li>
                <a class="footer_nav-link" href="{{ route('frontend.feedback') }}">@lang('footer.navlink_3')</a>
            </li>
            <li>
                <a class="footer_nav-link" href="{{ route('frontend.faq') }}">@lang('footer.navlink_4')</a>
            </li>
            <li>
                <a class="footer_nav-link" href="{{ route('frontend.termsOfUse') }}">@lang('footer.navlink_5')</a>
            </li>
            <li>
                <a class="footer_nav-link" href="{{ route('frontend.conditions') }}">@lang('footer.navlink_6')</a>
            </li>
        </ul>

        <div class="footer_social">

            <p class="footer_social-title">@lang('footer.social.title')</p>

            <div class="footer_social-icons-wrapper">
                <a href="https://t.me/teenjob_by"><img class="social-icon" src="/images/telegram-icon.svg" alt="telegram icon"></a>
                <a href="https://www.instagram.com/teenjob.by/?hl=ru"><img class="social-icon" src="/images/instagram-icon.svg" alt="instagram icon"></a>
                <a href="https://vk.com/teenjob_by"><img class="social-icon" src="/images/vk-icon.svg" alt="vkontakte icon"></a>
                <a href="https://www.facebook.com/teenjob.by/"><img class="social-icon" src="/images/fb-icon.svg" alt="facebook icon"></a>
            </div>
        </div>
    </div>

</footer>