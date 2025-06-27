<?php


namespace OnNow\Xdeasy\Http\Controllers\Hawb;


use OnNow\Xdeasy\Http\Controllers\Controller;
use OnNow\Xdeasy\Repositories\PhxCargo\PhxCargo;
use Webkul\Sales\Models\Invoice;

class HawbController extends Controller
{

    public function create($invoice)
    {
        //if (env('APP_ENV') == 'production'){
            $php = new PhxCargo();
            $php->createAwb($invoice->order);
        //}

        return redirect()->back();
    }

    public function print($invoice)
    {
        $php = new PhxCargo();
        $hawb = $php->getMawb($invoice->order->awb_id);

        return redirect($hawb);
    }

}