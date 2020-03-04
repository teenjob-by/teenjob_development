
    @if(($data->total()) > 0)
        @foreach($data as $offer)
            <div class="card mt-3 card-offer">
                <h3 class="offer-title">
                    @if(false)
                        <span class="approved"></span>
                    @endif
                    @if($offer->offer_type == 0)
                        <a href="{{ '/'.'volunteering'.'/'.$offer->id }}">{{$offer->title}}</a>
                        <span class="volunteer-icon"></span>
                    @elseif($offer->offer_type == 1)
                        <a href="{{ '/'.'internship'.'/'.$offer->id }}">{{$offer->title}}</a>
                        <span class="intern-icon"></span>
                    @elseif($offer->offer_type == 2)
                        <a href="{{ '/'.'vacancy'.'/'.$offer->id }}">{{$offer->title}}</a>
                        <span class="vacancy-icon"></span>
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
    @else
        <p>@lang('content.notFound')</p>
    @endif

