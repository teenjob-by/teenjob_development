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

        <div id="modal_container"></div>

        <div id="overlay"></div>



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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

        <script>

            var modalCtn = $('#modal_container'),
                overlay = $('#overlay');

            $('document').ready(function() {

                if ( !($.cookie('visited'))) {
                    setTimeout(() => {

                        var btnModalVal = $(this).attr('modal-value');

                        buildModalNotification();

                        $('.close_button').addClass('modal_open');
                        $(overlay).addClass('modal_open');

                        dismissModal();

                    }, 30000)
                }


            });

            function buildModalNotification() {
                var html = '<div id="modal_a" class="modal_dialog">' +
                    '<div class="modal_header">' +
                    '<div class="close_button">&times;</div>' +
                    '</div>' +
                    '<div class="modal_body">' +
                    '<p class="title">С 4 июля по 30 сентября проводился Мониторинг и оценка школьного образования Беларуси <a target="_blank" href="http://eduforum.teenjob.by">http://eduforum.teenjob.by</a> Мы изучали мнение учеников и учителей со всей Беларуси. Оставьте почту, чтобы получить на нее результаты.</p>' +
                    '<form class="modal_form" id="form_a" action="" method="">' +
                    '<div class="input_labl">Email*</div>' +
                    '<div class="modal_inpt_wrapper">' +
                    '<input type="email" required="required" class="modal_inpt" placeholder="" name="email" title="Введите свой email адрес">' +
                    '<input type="submit" class="modal_button btn_dark btn-full" id="" value="Отправить">' +
                    '</div>' +
                    '</form>' +
                    '</div>' +
                    '</div>';

                showModal(html);
            }

            function buildModalThanks() {
                var html = '<div id="modal_a" class="modal_dialog">' +
                    '<div class="modal_header">' +
                    '<div class="close_button">&times;</div>' +
                    '</div>' +
                    '<div class="modal_body">' +
                    '<p class="title">Спасибо, email получен, мы пришлем вам результаты!</p>' +
                    '</div>' +
                    '</div>';

                showModal(html);
            }




            function sendData() {
                try {
                    $.ajax({
                        type: "POST",
                        data: $('#form_a').serialize(),
                        url: "https://dev.teenjob.by/download",
                        success: function (json) {

                            $('.modal_open').click();
                            buildModalThanks()

                            $('.close_button').addClass('modal_open');
                            $(overlay).addClass('modal_open');

                            dismissModal();
                            $.cookie('visited', true, { expires: 100 });

                        },
                        error: function (data) {
                            $('.modal_open').click();
                            $.cookie('visited', true, { expires: 100 });

                        }
                    });
                }
                catch (e) {
                    alert('error')
                }
            }


            function showModal(html) {
                modalCtn.append(html);

                $(".modal_button").click(function(e){

                    sendData();

                    e.preventDefault();
                    return false;
                });
                overlay.fadeIn();
                modalCtn.fadeIn();
            }

            function dismissModal() {
                $('.modal_open').click(function() {
                    $.cookie('visited', true, { expires: 100 });
                    modalCtn.hide();
                    overlay.hide();
                    modalCtn.html('');
                });
            }


            $(document).ready(function() {
                $('.custom-select').select2( {
                    language: "ru",
                    minimumResultsForSearch: -1
                });

                var timeout;
                $(".justselect-wrapper").mouseout(function(){
                    clearTimeout(timeout)
                    timeout = setTimeout(function(){
                        $(".justselect-list").fadeOut()
                    },500);
                }).mouseover(function(){
                    clearTimeout(timeout)
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
