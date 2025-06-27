<div class="sidebar">
    @foreach ($menu->items as $menuItem)
        <div class="menu-block">
            <div class="menu-block-title">
                {{ trans($menuItem['name']) }}

                <i class="fas fa-chevron-down right" id="down-icon"></i>
            </div>

            <div class="menu-block-content">
                <ul class="menubar">
                    <li><a href="{{ route('customer.session.destroy') }}">Sair</a></li>

                    @foreach ($menuItem['children'] as $subMenuItem)
                        <li class="menu-item {{ $menu->getActive($subMenuItem) }}">
                            <a href="{{ $subMenuItem['url'] }}">
                                {{ trans($subMenuItem['name']) }}
                            </a>

                            <i class="icon angle-right-icon"></i>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $(".fa-chevron-down.right").on('click', function(e){
            var currentElement = $(e.currentTarget);
            if (currentElement.hasClass('fa-chevron-down')) {
                $(this).parents('.menu-block').find('.menubar').show();
                currentElement.removeClass('fa-chevron-down');
                currentElement.addClass('fa-chevron-up');
            } else {
                $(this).parents('.menu-block').find('.menubar').hide();
                currentElement.removeClass('fa-chevron-up');
                currentElement.addClass('fa-chevron-down');
            }
        });
    });
</script>
@endpush