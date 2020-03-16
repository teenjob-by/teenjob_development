@extends('layouts.site')
@section('seo_meta')
    <meta name="description" content="Стажировка - это отличная возможность получить навыки в определенной сфере деятельности, попробовать и развить свои способности."/>
    <meta name="language" content="RU"/>

    <title>Что такое стажировка - teenjob.by</title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/main_fb.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/main_vk.png">
@endsection
@section('body_class', 'page-home')

@section('content')
    <div class="container-fluid background">
        <div class="container conditions">
            <div class="row justify-content-center">
                <h3>@lang('content.faq.title')</h3>
                <hr/>
            </div>

            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="heading_1">
                        <h5 class="mb-0">
                            <button class="btn btn-link faq-btn" data-toggle="collapse" data-target="#collapse_1" aria-expanded="false" aria-controls="collapse_1">
                                @lang('content.faq.subtitles.subtitle_1')
                            </button>
                            <i class="fa fa-plus"></i>
                        </h5>
                    </div>

                    <div id="collapse_1" class="collapse" aria-labelledby="heading_1" data-parent="#accordion">
                        <div class="card-body">
                            @lang('content.faq.text.section_1')
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="heading_2">
                        <h5 class="mb-0">
                            <button class="btn btn-link faq-btn" data-toggle="collapse" data-target="#collapse_2" aria-expanded="false" aria-controls="collapse_2">
                                @lang('content.faq.subtitles.subtitle_2')
                            </button>
                            <i class="fa fa-plus"></i>
                        </h5>
                    </div>

                    <div id="collapse_2" class="collapse" aria-labelledby="heading_2" data-parent="#accordion">
                        <div class="card-body">
                            @lang('content.faq.text.section_2')
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="heading_3">
                        <h5 class="mb-0">
                            <button class="btn btn-link faq-btn" data-toggle="collapse" data-target="#collapse_3" aria-expanded="false" aria-controls="collapse_3">
                                @lang('content.faq.subtitles.subtitle_3')
                            </button>
                            <i class="fa fa-plus"></i>
                        </h5>
                    </div>

                    <div id="collapse_3" class="collapse" aria-labelledby="heading_3" data-parent="#accordion">
                        <div class="card-body">
                            @lang('content.faq.text.section_3')
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="heading_4">
                        <h5 class="mb-0">
                            <button class="btn btn-link faq-btn" data-toggle="collapse" data-target="#collapse_4" aria-expanded="false" aria-controls="collapse_4">
                                @lang('content.faq.subtitles.subtitle_4')
                            </button>
                            <i class="fa fa-plus"></i>
                        </h5>
                    </div>

                    <div id="collapse_4" class="collapse" aria-labelledby="heading_4" data-parent="#accordion">
                        <div class="card-body">
                            @lang('content.faq.text.section_4')
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="heading_5">
                        <h5 class="mb-0">
                            <button class="btn btn-link faq-btn" data-toggle="collapse" data-target="#collapse_5" aria-expanded="false" aria-controls="collapse_5">
                                @lang('content.faq.subtitles.subtitle_5')
                            </button>
                            <i class="fa fa-plus"></i>
                        </h5>
                    </div>

                    <div id="collapse_5" class="collapse" aria-labelledby="heading_5" data-parent="#accordion">
                        <div class="card-body">
                            @lang('content.faq.text.section_5')
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="heading_6">
                        <h5 class="mb-0">
                            <button class="btn btn-link faq-btn" data-toggle="collapse" data-target="#collapse_6" aria-expanded="false" aria-controls="collapse_6">
                                @lang('content.faq.subtitles.subtitle_6')
                            </button>
                            <i class="fa fa-plus"></i>
                        </h5>
                    </div>

                    <div id="collapse_6" class="collapse" aria-labelledby="heading_6" data-parent="#accordion">
                        <div class="card-body">
                            @lang('content.faq.text.section_6')
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="heading_7">
                        <h5 class="mb-0">
                            <button class="btn btn-link faq-btn" data-toggle="collapse" data-target="#collapse_7" aria-expanded="false" aria-controls="collapse_7">
                                @lang('content.faq.subtitles.subtitle_7')
                            </button>
                            <i class="fa fa-plus"></i>
                        </h5>
                    </div>

                    <div id="collapse_7" class="collapse" aria-labelledby="heading_7" data-parent="#accordion">
                        <div class="card-body">
                            @lang('content.faq.text.section_7')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection



@section('pagescript')

    <script>
        $(document).ready(function(){

            $(".collapse.show").each(function(){
                $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
                $(this).prev(".card-header").find(".btn").addClass("blue");
            });

            $(".collapse").on('show.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
                $(this).prev(".card-header").find(".btn").addClass("blue");
            }).on('hide.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
                $(this).prev(".card-header").find(".btn").removeClass("blue");
            });
        });
    </script>
@stop