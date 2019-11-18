

    @foreach($data as $offer)
        <div class="card mt-3 card-offer">
            <h3 class="offer-title">
                <a href="{{ '/'.($offer->offer_type?'internship':'volunteering').'/'.$offer->id }}">{{$offer->title}}</a>
                @if(false)
                    <span class="approved"></span>
                @endif
                @if($offer->offer_type == 0)
                    <span class="volunteer-icon"></span>
                @elseif($offer->offer_type == 1)
                    <span class="intern-icon"></span>
                @endif
            </h3>
            <h4 class="offer-organisation"><a href="{{ $offer->organisation['link'] }}" target="_blank">{{$offer->organisation['name']}}</a></h4>
            <div class="offer-description">{!! $offer->getPreviewDesc() !!}</div>

            <div class="offer-footer">
                <p class="offer-city">{{$offer->city->name}}</p>
                <p class="offer-date">{{$offer->published_at->format('j F')}}</p>
            </div>
        </div>
    @endforeach

    <div class="row justify-content-center paginator">
        {{ $data->appends($_GET)->links() }}
    </div>