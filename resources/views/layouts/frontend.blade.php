<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="language" content="{{ app()->getLocale() }}"/>
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <link href="/css/justselect.min.css" rel="stylesheet" />
        @yield('styles')

        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/fonts/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />



        @yield('seo_meta')
        @yield('og_meta')

    </head>

    <body>

        @include('frontend.chunks.header')

        <div class="content">
            @yield('content')
        </div>

        @include('frontend.chunks.footer')

        <!--styles and scripts section -->



        <script
          src="https://code.jquery.com/jquery-3.5.0.min.js"
              integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
              crossorigin="anonymous"></script>

        <script src="/js/swiped-events.min.js"></script>
        <script src="{{url('/')}}/js/justselect.min.js"></script>
        <script>
            function showPassword(element) {

                var elem = $('#'+ element)

                if (elem.get(0).type === "password") {
                    elem.get(0).type = "text";
                } else {
                    elem.get(0).type = "password";
                }
            }

        </script>
        <script src="https://unpkg.com/imask"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/i18n/ru.js"></script>
        <script>
            $(document).ready(function() {
                $('.custom-select').select2( {
                    language: "ru",
                    minimumResultsForSearch: -1
                });

                $('.custom-select-search').select2( {
                    language: "ru",
                });

                $('.custom-select-search').on('select2:open', function () {

                    if ( $('.select2-search input').is(':focus') ) {

                        $('.select2-search input').prop('focus', false);

                    } else {

                        $('.select2-search input').prop('focus', true);

                    }

                })


                let vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
            });

            $(document).on('click',function(event){
                if($(".burger").hasClass('open')) {
                    $(".burger").removeClass('open');
                    $(".header_menu").slideUp('fast');
                    event.stopPropagation()
                }

            });

            $('#desktop-search').on('submit',function(event){
                console.log( $('#search-select option:selected').val());
                $('#desktop-search').attr('action',  $('#search-select option:selected').val());
            });

            $(window).scroll(function() {
                if($(".burger").hasClass('open')) {
                    $(".burger").removeClass('open');
                    $(".header_menu").slideUp('fast');
                }
                $(".justselect-list").fadeOut();
            });

            $('.header_menu').scroll(function(event){
                event.stopPropagation();
            });




            $(".burger").click(function(event) {
                $(this).toggleClass('open');
                $(".header_menu").slideToggle('fast');

                event.stopPropagation()
            })

            $(window).resize(function(event) {
                if ($(window).width() >= 1024) {
                    $('.header_menu').removeAttr('style');
                }

                if($(".burger").hasClass('open')) {
                    $(".burger").removeClass('open');
                    $(".header_menu").slideUp('fast');
                }

                let vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
                event.stopPropagation()
            })


        </script>

        @yield('scripts')

        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-148157210-1');
        </script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-148157210-1"></script>
        <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(55651210, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script>



    </body>
</html>
