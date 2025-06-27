<?php

namespace Webkul\Product\Http\Controllers;

use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Models\Channel;
use Webkul\Product\Http\Requests\ProductForm;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Product\Repositories\ProductInventoryRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Repositories\ProductDownloadableLinkRepository;
use Webkul\Product\Repositories\ProductDownloadableSampleRepository;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Webkul\Inventory\Repositories\InventorySourceRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Product controller
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class ProductController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * CategoryRepository object
     *
     * @var Object
     */
    protected $categoryRepository;

    /**
     * ProductRepository object
     *
     * @var Object
     */
    protected $productRepository;

    /**
     * ProductDownloadableLinkRepository object
     *
     * @var Object
     */
    protected $productDownloadableLinkRepository;

    /**
     * ProductDownloadableSampleRepository object
     *
     * @var Object
     */
    protected $productDownloadableSampleRepository;

    /**
     * AttributeFamilyRepository object
     *
     * @var Object
     */
    protected $attributeFamilyRepository;

    /**
     * InventorySourceRepository object
     *
     * @var Object
     */
    protected $inventorySourceRepository;

    /**
     * @var ProductFlatRepository
     */
    protected $productFlatRepository;

    /**
     * @var ProductInventoryRepository
     */
    protected $productInventoryRepository;


    /**
     * ProductController constructor.
     * @param CategoryRepository $categoryRepository
     * @param ProductRepository $productRepository
     * @param ProductDownloadableLinkRepository $productDownloadableLinkRepository
     * @param ProductDownloadableSampleRepository $productDownloadableSampleRepository
     * @param AttributeFamilyRepository $attributeFamilyRepository
     * @param InventorySourceRepository $inventorySourceRepository
     * @param ProductFlatRepository $productFlatRepository
     * @param ProductInventoryRepository $productInventoryRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        ProductDownloadableLinkRepository $productDownloadableLinkRepository,
        ProductDownloadableSampleRepository $productDownloadableSampleRepository,
        AttributeFamilyRepository $attributeFamilyRepository,
        InventorySourceRepository $inventorySourceRepository,
        ProductFlatRepository $productFlatRepository,
        ProductInventoryRepository $productInventoryRepository
    )
    {
        $this->_config = request('_config');

        $this->categoryRepository = $categoryRepository;

        $this->productRepository = $productRepository;

        $this->productDownloadableLinkRepository = $productDownloadableLinkRepository;

        $this->productDownloadableSampleRepository = $productDownloadableSampleRepository;

        $this->attributeFamilyRepository = $attributeFamilyRepository;

        $this->inventorySourceRepository = $inventorySourceRepository;

        $this->productFlatRepository = $productFlatRepository;

        $this->productInventoryRepository = $productInventoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $families = $this->attributeFamilyRepository->all();

        $configurableFamily = null;

        if ($familyId = request()->get('family')) {
            $configurableFamily = $this->attributeFamilyRepository->find($familyId);
        }

        return view($this->_config['view'], compact('families', 'configurableFamily'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (! request()->get('family')
            && request()->input('type') == 'configurable'
            && request()->input('sku') != '') {

            return redirect(url()->current() . '?type=' . request()->input('type') . '&family=' . request()->input('attribute_family_id') . '&sku=' . request()->input('sku'));
        }

        if (request()->input('type') == 'configurable'
            && (! request()->has('super_attributes')
            || ! count(request()->get('super_attributes')))) {

            session()->flash('error', trans('admin::app.catalog.products.configurable-error'));

            return back();
        }

        $this->validate(request(), [
            'type' => 'required',
            'attribute_family_id' => 'required',
            'sku' => ['required', 'unique:products,sku', new \Webkul\Core\Contracts\Validations\Slug]
        ]);

        $product = $this->productRepository->create(request()->all());

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Product']));

        return redirect()->route($this->_config['redirect'], ['id' => $product->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $product = $this->productRepository->with(['variants', 'variants.inventories'])->findOrFail($id);

        $categories = $this->categoryRepository->getCategoryTree();

        $inventorySources = $this->inventorySourceRepository->all();

        return view($this->_config['view'], compact('product', 'categories', 'inventorySources'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Webkul\Product\Http\Requests\ProductForm $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductForm $request, $id)
    {
        $product = $this->productRepository->update(request()->all(), $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Product']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Uploads downloadable file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadLink($id)
    {
        return response()->json(
            $this->productDownloadableLinkRepository->upload(request()->all(), $id)
        );
    }

    /**
     * Uploads downloadable sample file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadSample($id)
    {
        return response()->json(
            $this->productDownloadableSampleRepository->upload(request()->all(), $id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productRepository->findOrFail($id);

        try {
            $this->productRepository->delete($id);

            session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Product']));

            return response()->json(['message' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Product']));
        }

        return response()->json(['message' => false], 400);
    }

    /**
     * Mass Delete the products
     *
     * @return response
     */
    public function massDestroy()
    {
        $productIds = explode(',', request()->input('indexes'));

        foreach ($productIds as $productId) {
            $product = $this->productRepository->find($productId);

            if (isset($product)) {
                $this->productRepository->delete($productId);
            }
        }

        session()->flash('success', trans('admin::app.catalog.products.mass-delete-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Mass updates the products
     *
     * @return response
     */
    public function massUpdate()
    {
        $data = request()->all();

        if (!isset($data['massaction-type'])) {
            return redirect()->back();
        }

        if (!$data['massaction-type'] == 'update') {
            return redirect()->back();
        }

        $productIds = explode(',', $data['indexes']);

        foreach ($productIds as $productId) {
            $this->productRepository->update([
                'channel' => null,
                'locale' => null,
                'status' => $data['update-options']
            ], $productId);
        }

        session()->flash('success', trans('admin::app.catalog.products.mass-update-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /*
     * To be manually invoked when data is seeded into products
     */
    public function sync()
    {
        Event::fire('products.datagrid.sync', true);

        return redirect()->route('admin.catalog.products.index');
    }

    /**
     * Result of search product.
     *
     * @return \Illuminate\View\View | \Illuminate\Http\JsonResponse
     */
    public function productLinkSearch()
    {
        if (request()->ajax()) {
            $results = [];

            foreach ($this->productRepository->searchProductByAttribute(request()->input('query')) as $row) {
                $results[] = [
                        'id' => $row->product_id,
                        'sku' => $row->sku,
                        'name' => $row->name,
                    ];
            }

            return response()->json($results);
        } else {
            return view($this->_config['view']);
        }
    }

     /**
     * Download image or file
     *
     * @param  int $productId, $attributeId
     * @return \Illuminate\Http\Response
     */
    public function download($productId, $attributeId)
    {
        $productAttribute = $this->productAttributeValue->findOneWhere([
            'product_id'   => $productId,
            'attribute_id' => $attributeId
        ]);

        return Storage::download($productAttribute['text_value']);
    }

    /**
     * Search simple products
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchSimpleProducts()
    {
        return response()->json(
            $this->productRepository->searchSimpleProducts(request()->input('query'))
        );
    }

    public function price()
    {
        return view($this->_config['view']);
    }

    public function priceUpdate()
    {
        if (request()->get('channel')){
            $where = [
                'locale' => request()->get('locale'),
                'channel' => request()->get('channel')
            ];
        } else {
            $where = [
                'locale' => request()->get('locale')
            ];
        }

        $productsFlat = $this->productFlatRepository->findWhere($where)->groupBy('product_id');
        $productsIds = $productsFlat->map(function ($product){
            return $product->first()->product_id;
        })->toArray();

        $products = $this->productRepository->findWhereIn('id', $productsIds);

        DB::beginTransaction();

        try{
            foreach ($products->where('type', 'simple') as $product) {

                Event::fire('catalog.product.update.before', $product->id);

                $price = $product->price;

                if ($price <= 0 || is_null($price)){
                    continue;
                }

                if ('fix' == request()->get('type')){
                    if ('sum' == request()->get('action')){
                        $price += request()->get('value');
                    }

                    if ('sub' == request()->get('action')){
                        $price -= request()->get('value');
                    }
                }

                if ('percentage' == request()->get('type')){
                    if ('sum' == request()->get('action')){
                        $price += ($price / 100) * request()->get('value');
                    }

                    if ('sub' == request()->get('action')){
                        $price -= ($price / 100) * request()->get('value');
                    }
                }

                if (request()->get('channel')){
                    $channels = Channel::query()->select('id')->whereIn('code', [
                        request()->get('channel'),
                        'default'
                    ])->get();
                    $product['channels'] = $channels->map(function ($channel){
                        return $channel->id;
                    });
                }

                $productArray = $product->toArray();

                $productArray['price'] = $price;
                $productArray['channel'] = request()->get('channel');
                $productArray['locale'] = request()->get('locale');

                $this->productRepository->update($productArray, $product->id);
            }
        } catch (QueryException $e){
            DB::rollBack();

            throw $e;
        }

        DB::commit();

        session()->flash('success', 'Os preços foram atualizados com sucesso.');

        return redirect()->route($this->_config['redirect']);

    }

    public function inventory($id)
    {
        $inventories = $this->productInventoryRepository->findWhere(['product_id' => $id]);
        return view($this->_config['view'], compact('inventories'));
    }

    public function inventoryUpdate($id)
    {
        $inventories = $this->productInventoryRepository->findWhere(['product_id' => $id]);
        $qty = request()->get('qty');

        $this->productInventoryRepository->create([
            'qty' => 'sum' == request()->get('action') ? $qty : $qty * -1,
            'product_id' => $id,
            'inventory_source_id' => $inventories->first()->inventory_source_id,
            'vendor_id' => $inventories->count()
        ]);

        session()->flash('success', 'Estoque atualizado com sucesso!');

        return redirect()->route($this->_config['redirect']);
    }
}