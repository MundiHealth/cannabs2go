<?php

namespace PureEncapsulations\Prescription\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PureEncapsulations\Prescription\Notifications\EmailPrescrition;
use PureEncapsulations\Prescription\Repositories\PrescriptionRepository;
use \PureEncapsulations\Prescription\Models\Prescription as PrescriptionModel;
use Webkul\Sales\Models\Order;
use Illuminate\Support\Facades\Notification;

class PrescriptionController extends Controller
{
    protected $prescriptionRepository;
    protected $prescriptionModel;
    protected $_config;

    public function __construct(
        PrescriptionRepository $prescriptionRepository,
        PrescriptionModel $prescriptionModel)
    {
        $this->_config = request('_config');
        $this->prescriptionRepository = $prescriptionRepository;
        $this->prescriptionModel = $prescriptionModel;
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function store(Request $request)
    {
        $orderId = $request->order_id;

        $order = Order::find($orderId);

        $validation = Validator::make($request->all(), [
//            'prescriptions' => 'required|file|mimes:jpeg,jpg,bmp,png,pdf|max:2048',
            'prescriptions' => 'required',
            'order_id' => 'required'
        ]);

        if ($validation->fails()){
            foreach ($validation->getMessageBag()->getMessages() as $erroMessage){
                session()->flash('error', end($erroMessage));
            }
        }

        if (!$validation->fails() && $files = $request->file('prescriptions')) {

            foreach ($files as $key => $file){

                $extension = $file->getClientOriginalExtension();
                $name = $request->order_id . "_" . $key . "_" . time() . "." . $extension;

                if($folder = $file->move('prescriptions', $name))
                {
                    $path = $folder->getPathname();
                    $prescription = new PrescriptionModel();
                    $prescription->prescription = $name;
                    $prescription->extension = $extension;
                    $prescription->path = $path;
                    $prescription->order_id = $request->order_id;
                    $prescription->save();

                }

            }

            if ($order->channel_id != 4) {
                Notification::route('mail', $order->customer_email)
                    ->notify(new EmailPrescrition($prescription));
            }

            session()->put('order', Order::find($request->order_id));
            session()->flash('success', 'Recebemos a prescrição médica com sucesso.');

        }

        return redirect()->back();

    }

    public function success()
    {
        return view($this->_config['view']);
    }

}