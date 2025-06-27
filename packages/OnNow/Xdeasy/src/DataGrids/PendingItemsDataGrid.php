<?php


namespace OnNow\Xdeasy\DataGrids;

use Carbon\Carbon;
use Webkul\Ui\DataGrid\DataGrid;
use DB;

class PendingItemsDataGrid extends DataGrid
{

    protected $index = 'qty';

    protected $sortOrder = 'asc'; //asc or desc

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('product_inventories')
            ->select('product_inventories.*', 'products.sku', 'product_flat.name', 'product_flat.size_label')
            ->leftJoin('products', function($leftJoin) {
                $leftJoin->on('products.id', '=', 'product_inventories.product_id')
                    ->where('products.type', 'simple');
            })
            ->leftJoin('product_flat', function($leftJoin) {
                $leftJoin->on('product_flat.product_id', '=', 'product_inventories.product_id');
            });

        $this->addFilter('qty', DB::raw('SUM(product_inventories.qty)'));

        $queryBuilder->groupBy('product_inventories.product_id');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'sku',
            'label' => 'SKU',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => 'Name',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);


        $this->addColumn([
            'index' => 'qty',
            'label' => 'Quantity',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'code',
            'label' => 'Code',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
            'wrapper' => function($value){
                $code = explode('-', $value->sku);
                return strtoupper(end($code));
            }
        ]);

        $this->addColumn([
            'index' => 'size_label',
            'label' => 'Size',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);
    }

    public function prepareMassActions()
    {

    }

}