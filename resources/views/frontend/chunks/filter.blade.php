<section class="filter_wrapper">

    <form method="get" action="" class="filter_form">

        @if(!empty($_GET['query']))
            <input type="hidden" name="query" value="{{ $_GET['query'] }}">
        @endif

        <div class="filter_mobile-button"></div>

        @foreach ($filters as $filter)

            <div class="filter_form-group">

                @if($filter['type'] == 'select')


                    <label class="filter_form-group-label" for="filter-{{ $filter['name'] }}">@lang('filter.'.$filter['name'])</label>
                    <select class="filter_form-group-select custom-select" id="filter-{{ $filter['name'] }}" name="{{ $filter['name'] }}">
                        <option selected value>@lang('filter.'. $filter['name'] .'Placeholder')</option>

                        @foreach($filter['data'] as $item)
                            @isset($_GET[$filter['name']])
                                <option {{ ($item->id == $_GET[$filter['name']])? 'selected': '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endisset
                        @endforeach

                    </select>
                @elseif($filter['type'] == 'interval')
                    <label class="filter_form-group-label" for="filter-{{ $filter['name'] }}">@lang('filter.'.$filter['name'])</label>
                    <div class="filter_form-group-inline">
                        <p class="filter_form-group-delimeter">@lang('filter.'.$filter['name'].'Min')</p>
                        <input  {{ (!empty($_GET[$filter['name']]))? 'value="'.$_GET[$filter['name']].'"': '' }} class="filter_form-group-input" type="text" name="{{ $filter['name'] }}-min" id="{{ $filter['name'] }}-min" placeholder="@lang('filter.'.$filter['name'].'MinPlaceholder')">
                        <p class="filter_form-group-delimeter">@lang('filter.'.$filter['name'].'Max')</p>
                        <input {{ (!empty($_GET[$filter['name']]))? 'value="'.$_GET[$filter['name']].'"': '' }} class="filter_form-group-input" type="text" name="{{ $filter['name'] }}-max" id="{{ $filter['name'] }}-max" placeholder="@lang('filter.'.$filter['name'].'MaxPlaceholder')">
                    </div>

                @elseif($filter['type'] == 'radio')
                    <label class="filter_form-group-label" for="filter-{{ $filter['name'] }}">@lang('filter.'.$filter['name'].'.label')</label>
                    <div class="filter_form-group-radio-inline">
                        @foreach($filter['data'] as $item)
                            <div class="filter_form-group-radio">
                                <input type="radio" {{ ((!empty($_GET[$filter['name']])) && ($_GET[$filter['name']] == $item['value'])) ? 'checked="checked"': '' }} class="filter_form-group-radio-input" id="{{ $item['name'] }}" name="{{ $filter['name'] }}" value="{{ $item['value'] }}">
                                <label class="filter_form-group-radio-label" for="{{ $item['name'] }}">@lang('filter.'.$filter['name'].'.'.$item['name'])</label>
                            </div>
                        @endforeach
                    </div>

                @elseif($filter['type'] == 'checkbox')
                    @if(__('filter.'.$filter['name'].'.label'))
                        <label class="filter_form-group-label" for="filter-{{ $filter['name'] }}">@lang('filter.'.$filter['name'].'.label')</label>
                    @endif

                        @foreach($filter['data'] as $item)

                            <label class="filter_form-group-checkbox" for="{{ $item['name'] }}">
                                <input type="checkbox" {{ ((!empty($_GET[$filter['name']])) && (strpos($_GET[$filter['name']], $item['value']) !== false)) ? 'checked="checked"': '' }} class="filter_form-group-checkbox-input" id="{{ $item['name'] }}" name="{{ $filter['name'] }}" value="{{ $item['value'] }}">
                                <span class="filter_form-group-checkbox-indicator"></span>
                                <span class="filter_form-group-checkbox-label">@lang('filter.'.$filter['name'].'.'.$item['name'])</span>
                            </label>

                        @endforeach

                @endif

            </div>

        @endforeach




    </form>
</section>