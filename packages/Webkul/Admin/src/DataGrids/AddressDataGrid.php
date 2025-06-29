<?php

namespace Webkul\Admin\DataGrids;

use DB;
use Webkul\Ui\DataGrid\DataGrid;
use Webkul\Customer\Repositories\CustomerRepository as Customer;

/**
 * Address Data Grid class
 *
 * @author Vivek Sharma <viveksh047@webkul.com>
 * @copyright 2019 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class AddressDataGrid extends DataGrid
{
    /**
     *
     * @var integer
     */
    public $index = 'address_id';

    protected $sortOrder = 'desc'; //asc or desc

    /**
     * CustomerRepository object
     *
     * @var object
    */
    protected $customer;

    /**
     * Create a new controller instance.
     *
     * @param  Webkul\Customer\Repositories\CustomerRepository  $customer
     * @return void
     */
    public function __construct(
        Customer $customer
    )
    {
        parent::__construct();

        $this->customer = $customer;
    }

    public function prepareQueryBuilder()
    {

        $customer = $this->customer->find(request('id'));

        $queryBuilder = DB::table('customer_addresses as ca')
                ->leftJoin('countries', 'ca.country', '=', 'countries.code')
                ->leftJoin('customers as c', 'ca.customer_id', '=', 'c.id')
                ->addSelect('ca.id as address_id', 'ca.address1', 'ca.country', DB::raw('countries.name as country_name'), 'ca.state', 'ca.city', 'ca.postcode', 'ca.phone', 'ca.default_address')
                ->where('c.id', $customer->id);

        $queryBuilder = $queryBuilder->leftJoin('country_states', function($qb) {
            $qb->on('ca.state', 'country_states.code')
            ->on('countries.id', 'country_states.country_id');
        });

        $queryBuilder
            ->groupBy('ca.id')
            ->addSelect(DB::raw('country_states.default_name as state_name'));

        $this->addFilter('address_id', 'ca.id');
        $this->addFilter('address1', 'ca.address1');
        $this->addFilter('city', 'ca.city');
        $this->addFilter('state', 'ca.state');
        $this->addFilter('country_name', DB::raw('countries.name'));
        $this->addFilter('postcode', 'ca.postcode');
        $this->addFilter('default_address', 'ca.default_address');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'address_id',
            'label' => trans('admin::app.customers.addresses.address-id'),
            'type' => 'number',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'address1',
            'label' => trans('admin::app.customers.addresses.address-1'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'city',
            'label' => trans('admin::app.customers.addresses.city'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'state',
            'label' => trans('admin::app.customers.addresses.state-name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'postcode',
            'label' => trans('admin::app.customers.addresses.postcode'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'default_address',
            'label' => trans('admin::app.customers.addresses.default-address'),
            'type' => 'boolean',
            'sortable' => true,
            'searchable' => false,
            'closure' => true,
            'wrapper' => function($row) {
                if ($row->default_address == 1)
                    return '<span class="badge badge-md badge-success"">' . trans('admin::app.customers.addresses.yes') . '</span>';
                else
                    return trans('admin::app.customers.addresses.dash');
            }
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'type' => 'Edit',
            'method' => 'GET', //use post only for redirects only
            'route' => 'admin.customer.addresses.edit',
            'icon' => 'icon pencil-lg-icon'
        ]);

        $this->addAction([
            'type' => 'Delete',
            'method' => 'POST',
            'route' => 'admin.customer.addresses.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'address']),
            'icon' => 'icon trash-icon'
        ]);
    }

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type' => 'delete',
            'label' => trans('admin::app.customers.addresses.delete'),
            'action' => route('admin.customer.addresses.massdelete', request('id')),
            'method' => 'DELETE'
        ]);
    }
}