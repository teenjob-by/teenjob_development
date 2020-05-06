<div class="{{ $item_type }}_card-wrapper">
    @if($not_empty)

        @foreach($data as $section_name => $section_value)
            <h3 class="section-title">Мероприятия</h3>
            <div class="{{ $section_name }}_card-wrapper">
                @if((count($section_value) > 0))

                    @foreach($section_value as $item)
                        <div class="{{ $section_name }}_card">
                            <h3 class="{{ $section_name }}_card-title">
                                @if(false)
                                    <span class="{{ $section_name }}_card-approved"></span>
                                @endif
                                <a class="{{ $section_name }}_card-title-link" href="{{ route('frontend.' .$section_name. 's.show', $item->id) }}"><strong>{{$item->title}}</strong></a>

                                @if($item->salary)
                                    <span class="{{ $section_name }}_card-salary">{{ $item->salary }} {{ $item->salaryType->name}}</span>
                                @endif

                                <span class="{{ $section_name }}-icon"></span>

                            </h3>
                            <h4 class="{{ $section_name }}_card-organisation"><a href="{{ $item->organisation['link'] }}" target="_blank">{{$item->organisation['name']}}</a></h4>
                            <div class="{{ $section_name }}_card-description">{!! $item->getPreviewDesc() !!}</div>

                            <div class="{{ $section_name }}_card-footer">
                                <p class="{{ $section_name }}_card-city">{{$item->city->name}}</p>
                                <p class="{{ $section_name }}_card-date">{{$item->published_at->format('j F')}}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="pagination_wrapper">

                    </div>
                @endif
            </div>
        @endforeach

        <h3 class="section-title">Мероприятия</h3>

        @if((count($dataEvents) > 0))
                <div class="event_card-wrapper">
                    @foreach($dataEvents as $item)

                        <a class="event_card {{ ($item->status == 2)? "card-overlay":"" }}"  href="{{ route('frontend.events.show', $item->id) }}">

                            <div class="event_card-header">
                                <div class="event_card-header-time">
                                    <span class="time-wrapper">{{$item->date_start->format('d.m.Y')}}, <span>{{$item->date_start->format('H:i')}}</span></span>
                                </div>
                                <img src="{{$item->image}}" class="event_card-header-image" onError='this.onerror=null;this.src="/images/noimg.png";'>
                            </div>

                            <p class="event_card-location">{{$item->city->name}}</p>
                            <h3 class="event_card-title trimmed">{{$item->title}}</h3>
                            <div class="event_card-description trimmed">
                                {!!  $item->getPreviewDesc() !!}
                            </div>
                            <div class="event_card-more" >
                                Читать больше
                            </div>
                        </a>

                    @endforeach
                    <div class="pagination_wrapper">

                    </div>

                </div>

        @endif



    @else
        @include("frontend.chunks.notFoundMessage")
    @endif
</div>





