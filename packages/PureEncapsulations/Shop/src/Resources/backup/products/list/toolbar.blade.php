@inject ('toolbarHelper', 'PureEncapsulations\Product\Helpers\Toolbar')

<div class="row">
    <div class="col-xl-6 col-lg-5 col-sm-12">
        <div class="product-showing">
            <p>{{ __('shop::app.products.pager-info', ['showing' => $products->firstItem() . '-' . $products->lastItem(), 'total' => $products->total()]) }}</p>
        </div>
    </div>
    <div class="col-xl-6 col-lg-7 col-sm-12">
        <div class="pro-filter-title">
            <i class="fas fa-sort-amount-down"></i> Organizar por <i class="fas fa-chevron-down"></i>
        </div>
        <div class="pro-filter mb-40 f-right">
            <form action="#">
                <select  name="pro-filter" id="pro-filter" onchange="window.location.href = this.value">

                    @foreach ($toolbarHelper->getAvailableOrders() as $key => $order)

                        <option value="{{ $toolbarHelper->getOrderUrl($key) }}" {{ $toolbarHelper->isOrderCurrent($key) ? 'selected' : '' }}>
                            {{ __('shop::app.products.' . $order) }}
                        </option>

                    @endforeach

                </select>

            </form>
        </div>
    </div>
</div>