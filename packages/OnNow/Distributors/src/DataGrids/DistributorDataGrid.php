<?php

namespace OnNow\Distributors\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class DistributorDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('distributors')
                ->addSelect('id', 'name', 'commission');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => '#',
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => 'Nome',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'commission',
            'label' => "Comissão",
            'type' => 'price',
            'currencyCode' => 'BRL',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);
    }
}