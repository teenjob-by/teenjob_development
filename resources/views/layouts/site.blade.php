<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @yield('seo_meta')
        @yield('og_meta')
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
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/ru.js"></script>
        <script src="/js/jquery.selectric.min.js"></script>
        <link rel="stylesheet" href="/selectric.css">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('select').selectric(
                    {
                        disableOnMobile: false,
                        nativeOnMobile: false
                    }
                );

            });

            /*$(function() {

                $('.js-select2-basic-single').select2({
                    placeholder: 'Все города',
                    language: {
                        noResults: function () {
                            return 'Ничего не найдено';
                        },
                        searching: function () {
                            return 'Поиск…';
                        }
                    }
                });


            });*/

            function closeFilter() {
                $(".filter-mobile").toggleClass("opened");
                $(".filter-mobile").toggleClass("closed");
            }

            function openFilter() {
                $(".filter-mobile").toggleClass("closed");
                $(".filter-mobile").toggleClass("opened");
            }


        </script>
        <script>
            function showModal() {
                $('.modal').css('display', 'flex');
                $('.modal').css('opacity', '1');
            }

            function closeModal() {
                $('.modal').css('opacity', '0');
                $('.modal').css('display', 'none');
            }
        </script>

        <script type="text/javascript">
            $('.city-select').select2();
            $(document).ready(function(){
                $('.partners-carousel').slick({
                    infinite: true,
                    variableWidth: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    swipe: true,
                    swipeToSlide: true,
                    nextArrow: '<img class="carousel-arrow-right" src="/images/partners/next.svg">',
                    prevArrow: '<img class="carousel-arrow-left" src="/images/partners/prev.svg">'
                });
            });

            $(document).ready(function(){
                $('.partners-carousel-two').slick({
                    infinite: true,
                    variableWidth: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    swipe: true,
                    swipeToSlide: true,
                    nextArrow: '<img class="carousel-arrow-right" src="/images/partners/next.svg">',
                    prevArrow: '<img class="carousel-arrow-left" src="/images/partners/prev.svg">'
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
        <script>

            $(document).ready(function() {

                let vh = window.innerHeight * 0.01;
// Then we set the value in the --vh custom property to the root of the document
                document.documentElement.style.setProperty('--vh', `${vh}px`);
                document.getElementById("event-image").onchange = function () {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        if (e.total > 2500000) {
                            $('#imageerror').text('@lang("content.imageTooBig")');
                            $jimage = $("#event-image");
                            $jimage.val("");
                            $jimage.wrap('<form>').closest('form').get(0).reset();
                            $jimage.unwrap();
                            $('#uploadedimage').removeAttr('src');
                            return;
                        }
                        $('#imageerror').text('');
                        document.getElementById("uploadedimage").src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                };
            });

            $('.search-box').on('submit',function(e){
                e.preventDefault();

                var formData=$(this).serialize();
                var fullUrl = window.location.href;
                var finalUrl = fullUrl+"&"+formData;
                window.location.href = finalUrl;
            })

            function validate(obj) {
                

                var emptyinputs = $(obj).find('input').filter(function(){
                    return !$.trim(this.value).length;  // get all empty fields
                }).prop('disabled',true);
                var emptyselects = $(obj).find('select').filter(function(){
                    return !$.trim(this.value).length;  // get all empty fields
                }).prop('disabled',true).selectric('refresh');

                obj.submit();



            }

            $(document).on('click',function(){
                $('.collapse').collapse('hide');
            });
            
           
            $(document).on('scroll',function(){
                $('.collapse').collapse('hide');
            });
             
            
            //window.addEventListener('resize', () => {
  // We execute the same script as before
  //let vh = window.innerHeight * 0.01;
  //document.documentElement.style.setProperty('--vh', `${vh}px`);
//});

        </script>

    </head>

    <body class="@yield('body_class')">

            @include('site.blocks.header')

            <div class="content">
                @yield('content')
            </div>

            @include('site.blocks.footer')

        @stack('scripts')
            @yield('pagescript')



            <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>

            <script>
                $('#summernote').summernote({
                    placeholder: '',
                    tabsize: 2,
                    height: 300
                });
            </script>

    </body>
</html>
