<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/fonts/all.min.css">


        <script defer src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script defer src="//stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
        <script
                src="https://code.jquery.com/jquery-3.4.1.min.js"
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
                crossorigin="anonymous">
        </script>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.partners-carousel').slick({
                    infinite: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    nextArrow: '<img class="carousel-arrow-right" src="images/partners/next.svg">',
                    prevArrow: '<img class="carousel-arrow-left" src="images/partners/prev.svg">'
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    </head>

    <body class="@yield('body_class')">

            @include('site.blocks.header')

            <div class="content">
                @yield('content')
            </div>

            @include('site.blocks.footer')

        @stack('scripts')
    </body>
</html>