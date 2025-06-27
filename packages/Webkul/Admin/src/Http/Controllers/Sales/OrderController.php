<?php

namespace Webkul\Admin\Http\Controllers\Sales;

use OnNow\Ebanx\Services\Ebanx;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Sales\Models\OrderPayment;
use Webkul\Sales\Repositories\OrderRepository;

/**
 * Sales Order controller
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;

    /**
     * OrderRepository object
     *
     * @var array
     */
    protected $orderRepository;

    protected $orderPaymentModel;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository $orderRepository
     * @return void
     */
    public function __construct(OrderRepository $orderRepository, OrderPayment $orderPaymentModel)
    {
        $this->middleware('admin');

        $this->_config = request('_config');

        $this->orderRepository = $orderRepository;

        $this->orderPaymentModel = $orderPaymentModel;

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
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $order = $this->orderRepository->findOrFail($id);

        return view($this->_config['view'], compact('order'));
    }

    /**
     * Cancel action for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $result = $this->orderRepository->cancel($id);

        if ($result) {
            session()->flash('success', trans('admin::app.response.cancel-success', ['name' => 'Order']));
        } else {
            session()->flash('error', trans('admin::app.response.cancel-error', ['name' => 'Order']));
        }

        return redirect()->back();
    }

    public function zero($id)
    {
        $result = $this->orderRepository->zero($id);

        if ($result) {
            session()->flash('success', 'Pedido zerado com sucesso');
        } else {
            session()->flash('error', 'Erro ao zerar o pedido');
        }

        return redirect()->back();
    }

    public function linkEbanx($id)
    {
        $order = $this->orderRepository->findOrFail($id);

        $orderPayment = $this->orderPaymentModel->find($order->payment->id);

        $payment = new Ebanx();
        $payment->pay([], "link", $order);


        if($payment->response->status == 'SUCCESS'){
            $orderPayment->ext_transaction_code = $payment->response->payment->hash;
            $orderPayment->update();

            return redirect($payment->response->redirect_url);
        }

        session()->flash('error', 'Erro ao gerar novo link de pagamento');

        return redirect()->back();

    }
}