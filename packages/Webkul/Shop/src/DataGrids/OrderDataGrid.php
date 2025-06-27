<?php

namespace Webkul\Shop\DataGrids;

use Carbon\Carbon;
use Webkul\Ui\DataGrid\DataGrid;
use DB;

/**
 * OrderDataGrid class
 *
 * @author Rahul Shukla <rahulshkla.symfont517@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class OrderDataGrid extends DataGrid
{
    protected $index = 'id'; //the column that needs to be treated as index column

    protected $sortOrder = 'desc'; //asc or desc

    public function prepareQueryBuilder()
    {
        $currentChannel = core()->getCurrentChannel();

        $queryBuilder = DB::table('orders as order')
                ->addSelect('order.id', 'order.increment_id', 'order.status', 'order.created_at', 'order.grand_total', 'order.order_currency_code', 'channel_name')
                ->where('customer_id', auth()->guard('customer')->user()->id);

        if ($currentChannel->id != 1) {
            $queryBuilder->where('channel_id', $currentChannel->id);
        }

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $currentChannel = core()->getCurrentChannel();

        $this->addColumn([
            'index' => 'increment_id',
            'label' => trans('shop::app.customer.account.order.index.order_id'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        if ($currentChannel->id == 1) {
            $this->addColumn([
                'index' => 'channel_name',
                'label' => 'Loja',
                'type' => 'string',
                'searchable' => false,
                'sortable' => true,
                'filterable' => true
            ]);
        }

        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('shop::app.customer.account.order.index.date'),
            'type' => 'datetime',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'wrapper' => function ($value) {
                try {
                    return Carbon::parse($value->created_at)->format('d/m/Y H:i:s');
                } catch (\Exception $exception){
                    return "-";
                }
            }
        ]);

        $this->addColumn([
            'index' => 'grand_total',
            'label' => trans('shop::app.customer.account.order.index.total'),
            'type' => 'number',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'wrapper' => function ($value) {
                return core()->formatPrice($value->grand_total, $value->order_currency_code);
            }
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('shop::app.customer.account.order.index.status'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'closure' => true,
            'wrapper' => function ($value) {
                if ($value->status == 'processing')
                    return '<span class="badge badge-md badge-processing">Processing</span>';
                else if ($value->status == 'completed')
                    return '<span class="badge badge-md badge-success">Completed</span>';
                else if ($value->status == "canceled")
                    return '<span class="badge badge-md badge-danger">Canceled</span>';
                else if ($value->status == "closed")
                    return '<span class="badge badge-md badge-closed">Closed</span>';
                else if ($value->status == "pending")
                    return '<span class="badge badge-md badge-warning">Pending</span>';
                else if ($value->status == "pending_payment")
                    return '<span class="badge badge-md badge-payment">Pending Payment</span>';
                else if ($value->status == "fraud")
                    return '<span class="badge badge-md badge-danger">Fraud</span>';
                else if ($value->status == "invoiced")
                    return '<span class="badge badge-md badge-invoiced">Invoiced </span>';
                else if ($value->status == "separation")
                    return '<span class="badge badge-md badge-separation">Separation</span>';
                else if ($value->status == "dispatched")
                    return '<span class="badge badge-md badge-dispached">Dispatched</span>';
            },
            'filterable' => true
        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'type' => 'View',
            'method' => 'GET',
            'route' => 'customer.orders.view',
            'icon' => 'fas fa-eye',
            'title' => 'Ver Pedido'
        ]);

        $this->addAction([
            'type' => 'View',
            'method' => 'GET',
            'route' => 'customer.orders.copy',
            'icon' => 'fas fa-copy',
            'title' => 'Copiar Pedido'
        ]);

        $this->addAction([
            'type' => 'View',
            'method' => 'GET',
            'route' => 'customer.orders.payment',
            'icon' => 'fas fa-credit-card',
            'title' => 'Pagar Pedido'
        ]);
    }
}