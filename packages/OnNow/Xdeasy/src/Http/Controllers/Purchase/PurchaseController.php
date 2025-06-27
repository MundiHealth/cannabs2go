<?php

namespace OnNow\Xdeasy\Http\Controllers\Purchase;

use Maatwebsite\Excel\Facades\Excel;
use OnNow\Xdeasy\Exports\PendingItemsExport;
use OnNow\Xdeasy\Http\Controllers\Controller;
use OnNow\Xdeasy\Repositories\PendingItems;

class PurchaseController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    public function __construct()
    {
        $this->_config = request('_config');
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function pending()
    {
        $repository = new PendingItems();
        $orders = $repository->getOrdersWithPendingItems();

        return Excel::download(new PendingItemsExport($orders),'pending-items.csv', \Maatwebsite\Excel\Excel::CSV);
    }

}