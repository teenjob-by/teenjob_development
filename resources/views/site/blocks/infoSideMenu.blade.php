<div class="info-side-menu">
    <ul>
        @for ($i = 1; $i <= 9; $i++)
            <li>
                <a class="{{ (request()->is(__('info_side_menu.items.route_'. $i))) ? 'active' : '' }} side-menu-link" href="@lang('info_side_menu.items.route_'. $i)">
                    @lang('info_side_menu.items.name_'. $i)
                </a>
            </li>
        @endfor
    </ul>
</div>