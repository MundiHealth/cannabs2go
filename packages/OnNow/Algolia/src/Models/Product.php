<?php


namespace OnNow\Algolia\Models;

use Laravel\Scout\Searchable;
use Webkul\Product\Models\ProductFlat as ProductBaseModel;
use Webkul\Product\Models\ProductImageProxy;

class Product extends ProductBaseModel
{

    use Searchable;

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return "mp2go_";
    }

    public function toSearchableArray()
    {
        $array = $this->only('name', 'new', 'featured', 'price', 'locale', 'channel', 'description', 'meta_description', 'meta_keywords');
        $array['description'] = strip_tags($array['description']);

        return $array;
    }

    /**
     * The images that belong to the product.
     */
    /*public function images()
    {
        return $this->hasMany(ProductImageProxy::modelClass(), 'product_id');
    }*/

}