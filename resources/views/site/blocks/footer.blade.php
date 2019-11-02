<div class="footer">
    <div class="container wrapper">
        <div class="row">
            <div class="col-lg-1">
                <img class="logo-footer" src="/images/footer-logo.svg">
            </div>
            <div class="offset-lg-3 col-lg-5">
                <ul>
                    <li>
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('site.howsupport') }}">@lang('footer.navlink_2')</a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('site.termsofuse') }}">@lang('footer.navlink_1')</a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('site.conditions') }}">@lang('footer.navlink_3')</a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('site.contacts') }}">@lang('footer.navlink_4')</a>
                    </li>
                </ul>
            </div>
            <div class="footer-social offset-lg-1 col-lg-2">
                <div class="row">
                    <p class="footer-social-title">@lang('footer.social.title')</p>
                </div>
                <div class="row social-icons-row">
                    <a href="https://t.me/teenjob_by"><img class="social-icon-image" src="/images/telegram-icon.svg" alt="telegram icon"></a>
                    <a href="https://www.instagram.com/teenjob.by/?hl=ru"><img class="social-icon-image" src="/images/instagram-icon.svg" alt="instagram icon"></a>
                    <a href="https://vk.com/teenjob_by"><img class="social-icon-image" src="/images/vk-icon.svg" alt="vkontakte icon"></a>
                    <a href="https://www.facebook.com/teenjob.by/"><img class="social-icon-image" src="/images/fb-icon.svg" alt="facebook icon"></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Global site tag (gtag.js) - Google Analytics -->

</div>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-148157210-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-148157210-1');
</script>
<script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(55651210, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script>
