<?php


namespace OnNow\Xdeasy\Listeners;


use OnNow\Xdeasy\Repositories\PhxCargo\PhxCargo;

/**
 * Class Hawb
 * @package OnNow\Xdeasy\Listeners
 */
class Hawb
{

    /**
     * @param $order
     */
    public function sendShipping($order)
    {

        try {

            if (env('APP_ENV') == 'production'){
                $phx = new PhxCargo();
                $phx->createAwb($order);
            }

        } catch (\Exception $exception){

        }

    }

}