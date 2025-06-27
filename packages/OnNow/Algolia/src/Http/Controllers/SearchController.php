<?php


namespace OnNow\Algolia\Http\Controllers;

use OnNow\Algolia\Repositories\SearchRepository;
use Webkul\Shop\Http\Controllers\SearchController as BaseController;


class SearchController extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\SearchRepository $searchRepository
     * @return void
     */
    public function __construct(SearchRepository $searchRepository)
    {
        $this->_config = request('_config');

        $this->searchRepository = $searchRepository;
    }

    /**
     * Index to handle the view loaded with the search results
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $results = $this->searchRepository->search(request()->all());

        return view($this->_config['view'])->with('results', $results->count() ? $results : null);
    }

}