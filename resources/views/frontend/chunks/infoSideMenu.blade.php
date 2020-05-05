<div class="info-page_side-menu">
    <ul class="info-page_side-menu-list">
        @for ($i = 1; $i <= 9; $i++)
            <li class="info-page_side-menu-item">
                <a class="{{ (request()->is(__('info_side_menu.items.route_'. $i))) ? 'active' : '' }} info-page_side-menu-link" href="@lang('info_side_menu.items.route_'. $i)">
                    @lang('info_side_menu.items.name_'. $i)
                </a>
            </li>
        @endfor
    </ul>
</div>