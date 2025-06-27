<?php


namespace PureEncapsulations\Product\Repositories;


use Illuminate\Support\Facades\Response;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Product\Models\ProductAttributeValue;
use Webkul\Product\Repositories\ProductAttributeValueRepository;

class ProductRepository extends \Webkul\Product\Repositories\ProductRepository
{

    /**
     * @param integer $categoryId
     * @return Collection
     */
    public function getAll($categoryId = null)
    {
        $params = request()->input();

        $results = app('Webkul\Product\Repositories\ProductFlatRepository')->scopeQuery(function($query) use($params, $categoryId) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            $qb = $query->distinct()
                ->addSelect('product_flat.*')
                ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
                ->leftJoin('product_categories', 'products.id', '=', 'product_categories.product_id')
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->whereNotNull('product_flat.url_key');

            if ($categoryId)
                $qb->where('product_categories.category_id', $categoryId);

            if (is_null(request()->input('status')))
                $qb->where('product_flat.status', 1);

            if (is_null(request()->input('visible_individually')))
                $qb->where('product_flat.visible_individually', 1);

            $queryBuilder = $qb->leftJoin('product_flat as flat_variants', function($qb) use($channel, $locale) {
                $qb->on('product_flat.id', '=', 'flat_variants.parent_id')
                    ->where('flat_variants.channel', $channel)
                    ->where('flat_variants.locale', $locale);
            });

            if (isset($params['search']))
                $qb->where('product_flat.name', 'like', '%' . urldecode($params['search']) . '%');

            if (isset($params['sort'])) {
                $attribute = $this->attributeRepository->findOneByField('code', $params['sort']);

                if ($params['sort'] == 'price') {
                    if ($attribute->code == 'price') {
                        $qb->orderBy('min_price', $params['order']);
                    } else {
                        $qb->orderBy($attribute->code, $params['order']);
                    }
                } else {
                    $qb->orderBy($params['sort'] == 'created_at' ? 'product_flat.created_at' : $attribute->code, $params['order']);
                }
            }

            $qb = $qb->leftJoin('products as variants', 'products.id', '=', 'variants.parent_id');

            $qb = $qb->where(function($query1) use($qb) {
                $aliases = [
                    'products' => 'filter_',
                    'variants' => 'variant_filter_'
                ];

                foreach($aliases as $table => $alias) {
                    $query1 = $query1->orWhere(function($query2) use($qb, $table, $alias) {

                        foreach ($this->attributeRepository->getProductDefaultAttributes(array_keys(request()->input())) as $code => $attribute) {
                            $aliasTemp = $alias . $attribute->code;

                            $qb = $qb->leftJoin('product_attribute_values as ' . $aliasTemp, $table . '.id', '=', $aliasTemp . '.product_id');

                            $column = ProductAttributeValue::$attributeTypeFields[$attribute->type];

                            $temp = explode(',', request()->get($attribute->code));

                            if ($attribute->type != 'price') {
                                $query2 = $query2->where($aliasTemp . '.attribute_id', $attribute->id);

                                $query2 = $query2->where(function($query3) use($aliasTemp, $column, $temp) {
                                    foreach($temp as $code => $filterValue) {
                                        $columns = $aliasTemp . '.' . $column;
                                        $query3 = $query3->orwhereRaw("find_in_set($filterValue, $columns)");
                                    }
                                });
                            } else {
                                $query2->where('product_flat.min_price', '>=', core()->convertToBasePrice(current($temp)))
                                    ->where('product_flat.min_price', '<=', core()->convertToBasePrice(end($temp)));
                            }
                        }
                    });
                }
            });

            return $qb->groupBy('product_flat.name');
        })->paginate(isset($params['limit']) ? $params['limit'] : 32);

        return $results;
    }

    public function getByAttributeValue($attributeCode, $value)
    {
        $attributeRepository =  app('Webkul\Attribute\Repositories\AttributeRepository')->getAttributeByCode($attributeCode);
        $productAttributeValue = new ProductAttributeValue();
        $attributeValue = $productAttributeValue
            ->where('attribute_id', $attributeRepository->id);

        switch ($attributeRepository->type){
            case 'text':
            case 'textarea':
            case 'multiselect':
                $attributeValue->where('text_value', 'LIKE', '%' . $value . '%');
                break;
            case 'boolean':
                $attributeValue->where('boolean_value', $value);
                break;
            case 'price':
                $attributeValue->where('float_value', $value);
                break;
            default:
                break;
        }


        $productIds = $attributeValue->get()->map(function($item){
            return $item->product_id;
        });

        $results = app('Webkul\Product\Repositories\ProductFlatRepository')->scopeQuery(function($query) use ($productIds) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            $qb = $query->distinct()
                ->addSelect('product_flat.*', 'products.type')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->whereIn('product_flat.product_id', $productIds)
                ->orderByRaw('RAND()');

            $qb->leftJoin('products', 'products.id', '=', 'product_flat.product_id');

            return $qb;

        })->paginate(4);

        return $results;

    }

    public function getAttributes($product)
    {

        $collection = collect();

        $attributes = $product->attribute_family
            ->custom_attributes()
            ->where('attributes.is_visible_on_front', 1)
            ->get();

        $attributeOptionReposotory = app('Webkul\Attribute\Repositories\AttributeOptionRepository');

        foreach ($attributes as $attribute) {
            if ($product instanceof \Webkul\Product\Models\ProductFlat) {
                $value = $product->product->{$attribute->code};
            } else {
                $value = $product->{$attribute->code};
            }

            if ($attribute->type == 'boolean') {
                $value = $value ? true : false;
            } else if($value) {
                if ($attribute->type == 'select') {
                    $attributeOption = $attributeOptionReposotory->find($value);
                    if ($attributeOption)
                        $value = $attributeOption->label ?? $attributeOption->admin_name;
                } else if ($attribute->type == 'multiselect' || $attribute->type == 'checkbox') {
                    $value = explode(",", $value);
                }
            }

            $attribute->value = $value;

            $collection->push($attribute);
        }

        return $collection;
    }

    public function downloadFile($filename){
        $path = storage_path('app/public/' . $filename);
        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }

}