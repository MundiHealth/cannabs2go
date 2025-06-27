<?php

namespace Webkul\Admin\DataGrids;

use Webkul\Attribute\Models\AttributeOption;
use Webkul\Product\Helpers\ProductImage;
use Webkul\Product\Models\ProductFlat;
use Webkul\Ui\DataGrid\DataGrid;
use DB;

/**
 * ProductDataGrid Class
 *
 * @author Prashant Singh <prashant.singh852@webkul.com> @prashant-webkul
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class ProductDataGrid extends DataGrid
{
    protected $sortOrder = 'desc'; //asc or desc

    protected $index = 'product_id';

    protected $itemsPerPage = 20;

    public function prepareQueryBuilder()
    {
        $filter = $_GET['pure_code']??"";

        $productId = 0;

        if($filter) {
            $query = DB::table('product_attribute_values')
                    ->where('text_value', $filter['eq'])
                    ->first();

            $productId = $query->product_id;

        }


        $queryBuilder = DB::table('product_flat')
            ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
            ->leftJoin('attribute_families', 'products.attribute_family_id', '=', 'attribute_families.id')
//            ->leftJoin('product_inventories', 'product_flat.product_id', '=', 'product_inventories.product_id')
            ->select('product_flat.product_id as product_id', 'product_flat.sku as product_sku', 'product_flat.name as product_name', 'products.type as product_type', 'product_flat.status', 'product_flat.price', 'attribute_families.name as attribute_family')
            ->selectRaw('(SELECT SUM(qty) FROM product_inventories WHERE product_inventories.product_id = product_flat.product_id) as quantity')
//            ->whereNotNull('product_flat.name')
            ->where('locale', app()->getLocale())
            ->groupBy('product_flat.product_id')
            ->whereNull('deleted_at');



        $this->addFilter('product_id', 'product_flat.product_id');
        $this->addFilter('product_name', 'product_flat.name');
        $this->addFilter('product_sku', 'product_flat.sku');
        $this->addFilter('status', 'product_flat.status');
        $this->addFilter('product_type', 'products.type');
        $this->addFilter('attribute_family', 'attribute_families.name');
        $this->addFilter('pure_code', function ($q) use ($productId) {

            if ($productId > 0) {
                $q->where('product_flat.product_id', $productId);
            }
        });

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'product_id',
            'label' => trans('admin::app.datagrid.id'),
            'type' => 'number',
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

                $query= DB::table('product_attribute_values')
                        ->where(['product_id' => $value->product_id, 'attribute_id' => 27])
                        ->first();

                $code = !empty($query) ? $query->text_value : null;
                return $code;
            }
        ]);

        $this->addColumn([
            'index' => 'product_sku',
            'label' => trans('admin::app.datagrid.sku'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'product_name',
            'label' => trans('admin::app.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'attribute_family',
            'label' => trans('admin::app.datagrid.attribute-family'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'product_type',
            'label' => trans('admin::app.datagrid.type'),
            'type' => 'string',
            'sortable' => true,
            'searchable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('admin::app.datagrid.status'),
            'type' => 'boolean',
            'sortable' => true,
            'searchable' => false,
            'filterable' => true,
            'wrapper' => function($value) {
                if ($value->status == 1)
                    return 'Active';
                else
                    return 'Inactive';
            }
        ]);

        $this->addColumn([
            'index' => 'price',
            'label' => trans('admin::app.datagrid.price'),
            'type' => 'price',
            'sortable' => true,
            'searchable' => false,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'quantity',
            'label' => trans('admin::app.datagrid.qty'),
            'type' => 'number',
            'sortable' => true,
            'searchable' => false,
            'filterable' => false,
            'wrapper' => function($value) {
                if (is_null($value->quantity))
                    return 0;
                else
                    return $value->quantity;
            }
        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'title' => 'Atualizar estoque',
            'condition' => function() {
                return true;
            },
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'admin.catalog.products.inventory.index',
            'icon' => 'icon graph-up-icon'
        ]);

        $this->addAction([
            'title' => 'Edit Product',
            'condition' => function() {
                return true;
            },
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'admin.catalog.products.edit',
            'icon' => 'icon pencil-lg-icon'
        ]);

        $this->addAction([
            'title' => 'Delete Product',
            'method' => 'POST', // use GET request only for redirect purposes
            'route' => 'admin.catalog.products.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'product']),
            'icon' => 'icon trash-icon'
        ]);

        $this->enableAction = true;
    }

    public function prepareMassActions() {
        $this->addMassAction([
            'type' => 'delete',
            'label' => 'Delete',
            'action' => route('admin.catalog.products.massdelete'),
            'method' => 'DELETE'
        ]);

        $this->addMassAction([
            'type' => 'update',
            'label' => 'Update Status',
            'action' => route('admin.catalog.products.massupdate'),
            'method' => 'PUT',
            'options' => [
                'Active' => 1,
                'Inactive' => 0
            ]
        ]);

        $this->enableMassAction = true;
    }

    public function facebook($records) {

        $products = [];
        foreach ($records as $record) {
            $product = ProductFlat::where('product_id', $record->product_id)
                ->whereNotNull('name')
                ->whereNotNull('url_key')
                ->first();

            if (is_null($product))
                continue;

            $productBaseImage = new ProductImage();
            if ($brand = $product->product->attribute_values()->where('attribute_id', 25)->first()){
                $brand = AttributeOption::findOrFail($brand->integer_value);
            }

            $products[$record->product_id] = [
                'id' => $product->id,
                'title' => $product->name,
                'description' => strip_tags($product->short_description),
                'availability' => 'in stock',
                'condition' => 'new',
                'price' => $product->moeda_base_label . ' ' . number_format($product->price, 2,',', ''),
                'link' => route('shop.products.index', $product->url_key),
                'image_link' => $productBaseImage->getProductBaseImage($product->product)['large_image_url'],
                'brand' => $brand ? $brand->admin_name : null,
                'google_product_category',
                'fb_product_category',
                'quantity_to_sell_on_facebook' => null,
                'sale_price' => $product->moeda_base_label . ' ' . number_format($product->price, 2,',', ''),
                'sale_price_effective_date' => null,
                'item_group_id' => null,
                'gender' => null,
                'color' => null,
                'size' => null,
                'age_group' => null,
                'material' => null,
                'pattern' => null,
                'shipping' => null,
                'shipping_weight' => null,
                'style[0]' => null
            ];
        }

        return $products;
    }
}