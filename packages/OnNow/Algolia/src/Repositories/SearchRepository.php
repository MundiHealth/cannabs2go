<?php


namespace OnNow\Algolia\Repositories;


use Illuminate\Container\Container as App;
use OnNow\Algolia\Models\Product;
use Webkul\Core\Eloquent\Repository;
use Webkul\Product\Repositories\ProductRepository;

class SearchRepository extends Repository
{

    /**
     * ProductRepository object
     *
     * @return Object
     */
    protected $productRepository;

    /**
     * Create a new repository instance.
     *
     * @param  Webkul\Product\Repositories\ProductRepository $productRepository
     * @return void
     */
    public function __construct(
        ProductRepository $productRepository,
        App $app
    )
    {
        parent::__construct($app);

        $this->productRepository = $productRepository;
    }

    function model()
    {
        return 'Webkul\Product\Contracts\Product';
    }

    public function search($data)
    {
        $term = isset($data['term']) ? $data['term'] : null;
        $termWithChannel = urldecode(str_replace('-', ' ', $term)) . ' ' . core()->getCurrentChannelCode() . ' ' . app()->getLocale();

        $search = $this->getAlgolia($termWithChannel);

        if($search->isEmpty()) {
            $search = $this->getAlgolia($term);
        }

        $productIds = $search->map(function ($item){
            return $item->product_id;
        })->toArray();

        $results = app('Webkul\Product\Repositories\ProductFlatRepository')->scopeQuery(function($query) use ($productIds) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());
            $locale = request()->get('locale') ?: app()->getLocale();

            $qb = $query->distinct()
                ->addSelect('product_flat.*')
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->whereIn('product_flat.product_id', $productIds)
                ->whereNotNull('product_flat.url_key')
                ->orderByRaw('FIELD(id, ' . implode(",", $productIds) . ')');

            return $qb;

        })->paginate(16);


        return $results;
    }

    protected function getAlgolia($term)
    {
        return Product::search($term, function ($algolia, $query, $options){

            $extraOptions = [
                'hitsPerPage' => 100,
            ];

            $options = array_merge($options, $extraOptions);

            return $algolia->search($query, $options);

        })->get();
    }

}