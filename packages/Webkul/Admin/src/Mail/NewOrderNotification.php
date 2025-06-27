<?php

namespace Webkul\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/**
 * New Order Mail class
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class NewOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info('Send Order Create Mail');
        try {
            return $this->to($this->order->customer_email, $this->order->customer_full_name)
                //todo corrigir falha de envio
                ->from('noreply@mypharma2go.com.br', 'Atendimento da MP2GO')
                ->subject(trans('shop::app.mail.order.subject'))
                ->view('shop::emails.sales.new-order');
        } catch (\Exception $exception) {
            Log::warning($exception->getMessage());
        }
    }
}
