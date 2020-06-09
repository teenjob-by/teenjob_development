<div class="{{ $item_type }}_card-wrapper">
    @if(($data->total()) > 0)

            @foreach($data as $item)
                
                <div class="{{ $item->type() }}_card">
                    <h3 class="{{ $item->type() }}_card-title">
                        @if(false)
                            <span class="{{ $item->type() }}_card-approved"></span>
                        @endif
                        <a class="{{ $item->type() }}_card-title-link" href="{{ route('frontend.' .$item->type(). 's.show', $item->id) }}"><strong>{{$item->title}}</strong></a>

                        @if($item->salary)
                            <span class="{{ $item->type() }}_card-salary">{{ $item->salary }} {{ $item->salaryType->name}}</span>
                        @endif

                        <span class="{{ $item->type() }}-icon"></span>

                    </h3>
                    <h4 class="{{ $item->type() }}_card-organisation"><a href="{{ $item->organisation['link'] }}" target="_blank">{{$item->organisation['name']}}</a></h4>
                    <div class="{{ $item->type() }}_card-description">{!! $item->getPreviewDesc() !!}</div>

                    <div class="{{ $item->type() }}_card-footer">
                        <p class="{{ $item->type() }}_card-city">{{$item->city->name}}</p>
                        <p class="{{ $item->type() }}_card-date">{{$item->published_at->format('j F')}}</p>
                    </div>
                </div>

            @endforeach


            <div class="pagination_wrapper">
                {{ $data->appends($_GET)->links() }}
            </div>


    @else
        @include("frontend.chunks.notFoundMessage")
    @endif
</div>

