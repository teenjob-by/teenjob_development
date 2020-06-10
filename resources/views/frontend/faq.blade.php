@extends('layouts.frontend')

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

@section('scripts')

    <script>

        $(document).ready(function() {

            var acc = document.getElementsByClassName("accordion_button");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function () {

                    this.classList.toggle("active");


                    var panel = this.nextElementSibling;

                    if (panel.classList.contains("active")) {
                        panel.classList.toggle("active")

                        this.getElementsByTagName('i')[0].classList.add("fa-plus");
                        this.getElementsByTagName('i')[0].classList.remove("fa-minus");
                    } else {
                        panel.classList.toggle("active")
                        this.getElementsByTagName('i')[0].classList.remove("fa-plus");
                        this.getElementsByTagName('i')[0].classList.add("fa-minus");
                    }
                });
            }
        });

    </script>
@endsection

@section('content')
    <section class="info-page_section">
        <div class="content-wrapper">
            <div class="info-page_subsection">

                <h3 class="info-page-title">@lang('content.faq.title')</h3>

                <div id="faq-accordion" class="accordion_wrapper">

                    @for ($i = 1; $i <= 8; $i++)

                        <button class="accordion_button">
                            <h4 class="accordion_button-title">@lang('content.faq.subtitles.subtitle_'. $i)</h4>
                            <i class="fa fa-plus"></i>
                        </button>
                        <div class="accordion_panel">
                            <span>@lang('content.faq.text.section_'. $i)</span>
                        </div>

                    @endfor
                </div>
            </div>

            <div class="info-page_menu-section">
                @include('frontend.chunks.infoSideMenu')
            </div>
        </div>
    </section>
@endsection