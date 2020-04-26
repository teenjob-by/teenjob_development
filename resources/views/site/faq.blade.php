@extends('layouts.site')

@section('seo_meta')
    <meta name="description" content="Частые вопросы"/>
    <meta name="language" content="RU"/>

    <title>Частые вопросы - teenjob.by</title>
@endsection

@section('og_meta')
    <meta property="og:image" content="{{url('/')}}/images/main_fb.png">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="vk:image" content="{{url('/')}}/images/main_vk.png">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="container info-page">
            <div class="content-section">

                <h3 class="info-page-title">@lang('content.faq.title')</h3>

                <div id="faq-accordion" class="accordion">

                    @for ($i = 1; $i <= 8; $i++)
                        <div class="card">
                            <div class="card-header" id="heading_{{ $i }}">
                                <button class="btn btn-link faq-btn" data-toggle="collapse" data-target="#collapse_{{ $i }}" aria-expanded="false" aria-controls="collapse_{{ $i }}">
                                    <h4 class="card-title">@lang('content.faq.subtitles.subtitle_'. $i)</h4>
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                            <div id="collapse_{{ $i }}" class="collapse" aria-labelledby="heading_{{ $i }}" data-parent="#faq-accordion">
                                <div class="card-body">
                                    @lang('content.faq.text.section_'. $i)
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="menu-section">
                @include('site.blocks.infoSideMenu')
            </div>
        </div>
    </div>
@endsection



@section('pagescript')

    <script>
        $(document).ready(function(){

            $(".collapse.show").each(function(){
                $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
                $(this).prev(".card-header").find(".btn").addClass("active");
            });

            $(".collapse").on('show.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
                $(this).prev(".card-header").find(".btn").addClass("active");
            }).on('hide.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
                $(this).prev(".card-header").find(".btn").removeClass("active");
            });
        });
    </script>
@stop