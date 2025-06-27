<?php

namespace Webkul\Admin\DataGrids;

use Carbon\Carbon;
use Webkul\Ui\DataGrid\DataGrid;
use DB;

/**
 * OrderDataGrid Class
 *
 * @author Prashant Singh <prashant.singh852@webkul.com> @prashant-webkul
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class OrderDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc'; //asc or desc

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('orders')
                ->leftJoin('order_address as order_address_shipping', function($leftJoin) {
                    $leftJoin->on('order_address_shipping.order_id', '=', 'orders.id')
                        ->where('order_address_shipping.address_type', 'shipping');
                })
                ->leftJoin('order_address as order_address_billing', function($leftJoin) {
                    $leftJoin->on('order_address_billing.order_id', '=', 'orders.id')
                        ->where('order_address_billing.address_type', 'billing');
                })
                ->leftJoin('prescriptions as prescription', 'prescription.order_id', '=', 'orders.id')->groupBy('orders.id')

                ->addSelect('orders.id','orders.increment_id', 'orders.discount_amount', 'orders.grand_total', 'orders.created_at', 'channel_name', 'status', 'prescription.prescription', 'order_address_shipping.taxvat', 'coupon_code', 'order_address_shipping.phone')
                ->addSelect(DB::raw('CONCAT(order_address_billing.first_name, " ", order_address_billing.last_name) as billed_to'))
                ->addSelect(DB::raw('CONCAT(order_address_shipping.first_name, " ", order_address_shipping.last_name) as shipped_to'))
                ->addSelect(DB::raw('CONCAT(order_address_shipping.address1, ", ", order_address_shipping.city, ", ", order_address_shipping.postcode) as address'))
                ->whereNull('deleted_at');

        $this->addFilter('prescription', 'prescription.prescription');
        $this->addFilter('taxvat', 'order_address_shipping.taxvat');
        $this->addFilter('billed_to', DB::raw('CONCAT(order_address_billing.first_name, " ", order_address_billing.last_name)'));
        $this->addFilter('shipped_to', DB::raw('CONCAT(order_address_shipping.first_name, " ", order_address_shipping.last_name)'));
        $this->addFilter('increment_id', 'orders.increment_id');
        $this->addFilter('created_at', 'orders.created_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'increment_id',
            'label' => trans('admin::app.datagrid.id'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'channel_name',
            'label' => trans('admin::app.datagrid.channel-name'),
            'type' => 'string',
            'sortable' => true,
            'searchable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'grand_total',
            'label' => trans('admin::app.datagrid.grand-total'),
            'type' => 'price',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'discount_amount',
            'label' => trans('admin::app.datagrid.discount-amount'),
            'type' => 'price',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('admin::app.datagrid.order-date'),
            'type' => 'datetime',
            'sortable' => true,
            'searchable' => false,
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
            'index' => 'status',
            'label' => trans('admin::app.datagrid.status'),
            'type' => 'string',
            'sortable' => true,
            'searchable' => true,
            'closure' => true,
            'filterable' => true,
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
            }
        ]);


        $this->addColumn([
            'index' => 'prescription',
            'label' => trans('admin::app.datagrid.prescription'),
            'type' => 'string',
            'sortable' => true,
            'searchable' => false,
            'closure' => true,
            'filterable' => true,
            'wrapper' => function ($value) {
                if (!$value->prescription)
                    return '<span class="icon nochecked-icon"></span>';
                else
                    return '<span class="icon checked-icon"></span>';
            }
        ]);

        $this->addColumn([
            'index' => 'billed_to',
            'label' => trans('admin::app.datagrid.patient'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'taxvat',
            'label' => 'CPF',
            'type' => 'string',
            'searchable' => true,
            'sortable' => false,
            'filterable' => false
        ]);

//        $this->addColumn([
//            'index' => 'shipped_to',
//            'label' => trans('admin::app.datagrid.shipped-to'),
//            'type' => 'string',
//            'searchable' => true,
//            'sortable' => true,
//            'filterable' => true
//        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'title' => 'Order View',
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'admin.sales.orders.view',
            'icon' => 'icon eye-icon'
        ]);
    }
}