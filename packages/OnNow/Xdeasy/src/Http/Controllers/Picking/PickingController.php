<?php

namespace OnNow\Xdeasy\Http\Controllers\Picking;


use Maatwebsite\Excel\Facades\Excel;
use OnNow\Xdeasy\Exports\AwbExport;
use OnNow\Xdeasy\Http\Controllers\Controller;
use Webkul\Sales\Repositories\OrderRepository;


class PickingController extends Controller
{

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * OrderRepository object
     *
     * @var array
     */
    protected $orderRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository $orderRepository
     * @return void
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->middleware('admin');

        $this->_config = request('_config');

        $this->orderRepository = $orderRepository;

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

    public function separate()
    {
        $data = request()->all();

        $orders = $this->orderRepository->findWhereIn('id', explode(',', $data['indexes']));

        foreach ($orders as $order){
            $order->status = 'separation';
            $order->update();
        }

        Session()->flash('success', 'Pedidos separados com sucesso!');

        return Excel::download(new AwbExport($orders), 'mawb.csv', \Maatwebsite\Excel\Excel::CSV);

        //return redirect()->route('admin.xdeasy.packing');
    }

}