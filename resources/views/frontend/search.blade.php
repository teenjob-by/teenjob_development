@extends('layouts.frontend')

@section('seo_meta')
    <meta name="description" content=""/>
    <meta name="language" content="RU"/>
    <meta name="keywords" content="">

    <title>@lang('content.'. $item_type .'.title')y</title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/main_fb.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/main_vk.png">
@endsection

@section('scripts')

    <script src="/js/swiped-events.min.js"></script>


    <script>






        /*$(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.match(/\/page\/(\d*)/);
                if (page == Number.NaN || page <= 0) {
                    return false;
                }else{
                    getData(page);
                }
            }
        });*/





        $(document).ready(function() {



            //location.hash = getPage();
            var textfield = document.getElementsByClassName('filter_form-group-input');

            if(textfield.length > 0) {
                var regExpMaskMin = IMask(
                    document.getElementsByClassName('filter_form-group-input')[0],
                    {
                        mask: /^[1-9]\d{0,9}$/
                    });
                var regExpMaskMax = IMask(
                    document.getElementsByClassName('filter_form-group-input')[1],
                    {
                        mask: /^[1-9]\d{0,9}$/
                    });
            }




            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /*$(document).on('swiped-up', '.search_filter',function(e)
            {
                $('.filter_wrapper').css('max-height', '70px');
                console.log('up');
                e.stopPropagation();
            });

            $(document).on('swiped-down', '.search_filter',function(e)
            {
                console.log('down');
                $('.filter_wrapper').css('max-height', 'unset');
                e.stopPropagation();
            });*/








            $(".filter_mobile-button").click(function(event) {
                $(this).toggleClass('open');
                $(".filter_wrapper").toggleClass('open');
                $(".search_filter").toggleClass('open');
                event.stopPropagation()
            })



            $(window).click(function() {
                if($(".filter_mobile-button").hasClass('open')) {
                    $(".filter_mobile-button").removeClass('open');
                    $(".filter_wrapper").removeClass('open');
                    $(".search_filter").removeClass('open');
                }
            });

            $('.search_filter').click(function(event){
                event.stopPropagation();
            });

            $(window).scroll(function() {
                if($(".filter_mobile-button").hasClass('open')) {
                    $(".filter_mobile-button").removeClass('open');
                    $(".filter_wrapper").removeClass('open');
                    $(".search_filter").removeClass('open');
                }
            });

            $('.search_filter').scroll(function(event){
                event.stopPropagation();
            });




            //$.get('/cities', function(data) {
            //    $('#cities').append(data).selectric();
            //});

            //$.get('/specialities', function(data) {
            //    $('#specialities').append(data).selectric();
            //});

            $(document).on('click', '.pagination a',function(event)
            {
                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var myurl = $(this).attr('href');
                var page=$(this).attr('href').split('page=')[1];


                getData(page);
            });

            $(document).on('change', '.filter_form-group-select',function(event)
            {
                event.preventDefault();
                getData();
            });

            $(document).on('change', '.filter_form-group-radio-input',function(event)
            {
                event.preventDefault();
                getData();
            });

            $(document).on('change', '.filter_form-group-checkbox-input',function(event)
            {
                event.preventDefault();
                getData();
            });

            $(document).on('change', '.filter_form-group-input',function(event)
            {
                event.preventDefault();
                getData();
            });



            window.onpopstate = function(e){
                if(e.state){

                    document.title = e.state.pageTitle;
                    $(".{{ $item_type }}_card-wrapper").empty().html(e.state.html);

                }
            };

        });

        function getPage() {
            //var page = window.location.hash.replace('#', '');
            var page = window.location.hash.match(/\/page\/(\d*)/);

            if(!parseInt(page)) {
                page = 1;
            }
            return page;
        }

        function getData(page, filter = $('.filter_form')){

            $(".content-loader").toggleClass('active');


            page = isNaN(page) ? getPage() : page;

            var url = '?page=' +  page;


            var emptyinputs = $(filter).find('input').filter(function(){
               return !$.trim(this.value).length;  // get all empty fields
            }).prop('disabled',true);
            var emptyselects = $(filter).find('select').filter(function(){
               return !$.trim(this.value).length;  // get all empty fields
            }).prop('disabled',true);




            url = url + '&' + $(filter).serialize();
            console.log(url);


            url = url.split(/[?&]/).reduce(
                function(a,b,c){
                    var p=b.split("="), k=p[0], v=decodeURIComponent(p[1]);
                    if(!p[1])return a;
                    a[k]=a[k]||[];
                    a[k].push(v);
                    return a;
                }, {});

            console.log(url);

            const entries = Object.entries(url)

            var path = "?";

            for (const [key, value] of entries) {
                path += key +  '=';

                console.log(value);

                if(value.length > 1) {
                    path += '[';
                    for (var itemvalue of value) {
                        path += itemvalue + ',';
                    }
                    path = path.slice(0, -1);
                    path += ']';
                }
                else {
                    path += value;
                }

                path += '&';
            }

            path = path.slice(0, -1);


            url = '{{ route('frontend.'. $item_type.'s.index') }}' + path;

            console.log(url);

            var emptyinputs = $(filter).find('input').prop('disabled',false);
            var emptyselects = $(filter).find('select').prop('disabled',false);

            $.ajax(
                {
                    url: url,
                    type: "get",
                    datatype: "html"
                }).
                done(
                    function(data){

                        $(".{{ $item_type }}_card-wrapper").empty();


                            //location.hash = page;
                            //location.hash =  url;
                            //location.href = location.href.replace( /#.*/, "");

                                    console.log('done');

                        console.log($(".{{ $item_type }}_card-wrapper"));

                        $(".{{ $item_type }}_card-wrapper").html(data);

                        console.log($(".{{ $item_type }}_card-wrapper"));


                            window.history.pushState({"html":data, "pageTitle":document.title},"", url);

                            $(".content-loader").toggleClass('active');
                        }).fail(function(jqXHR, ajaxOptions, thrownError) {
                            console.log('fail');
                            //location.hash =  url;
                            //location.href = location.href.replace( /#.*/, "");
                            window.history.pushState({"html":data, "pageTitle":document.title},"", url);
                            $(".content-loader").toggleClass('active');
                            $(".card-wrapper").empty().html('@include("frontend.chunks.notFoundMessage")');
                    });
        }

    </script>
@endsection

@section('content')

    <section class="search_section">
        <div class="content-wrapper">
            <div class="search_filter" data-swipe-threshold="20"
                 data-swipe-timeout="500"
                 data-swipe-ignore="false">

                @include('frontend.chunks.filter')
            </div>

            <div class="search_content-wrapper">

                <img class="content-loader" src="/images/loading.svg">

                @include('frontend.'. $item_type .'.ajax')

            </div>
        </div>
    </section>

@endsection