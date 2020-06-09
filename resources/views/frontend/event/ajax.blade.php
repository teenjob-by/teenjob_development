<div class="{{ $item_type }}_card-wrapper">
    @if(($data->total()) > 0)

            @foreach($data as $item)
                <a class="{{ $item_type }}_card {{ ($item->status == 2)? "card-overlay":"" }}"  href="{{ route('frontend.' .$item_type. 's.show', $item->id) }}">

                    <div class="{{ $item_type }}_card-header">
                        <div class="{{ $item_type }}_card-header-time">
                            <span class="time-wrapper">{{$item->date_start->format('d.m.Y')}}, <span>{{$item->date_start->format('H:i')}}</span></span>
                        </div>
                        <img src="{{$item->image}}" class="{{ $item_type }}_card-header-image" onError='this.onerror=null;this.src="/images/noimg.png";'>
                    </div>

                    <p class="{{ $item_type }}_card-location">{{$item->city->name}}</p>
                    <h3 class="{{ $item_type }}_card-title trimmed">{{$item->title}}</h3>
                    <div class="{{ $item_type }}_card-description trimmed raw-text">
                            {!!  $item->getPreviewDesc() !!}
                    </div>
                    <div class="{{ $item_type }}_card-more" >
                        Читать больше
                    </div>
                </a>

            @endforeach

            <div class="pagination_wrapper">
                {{ $data->appends($_GET)->links() }}
            </div>
    @else
        @include("frontend.chunks.notFoundMessage")
    @endif
</div>