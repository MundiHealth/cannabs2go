<?php

namespace Webkul\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * New Invoice Mail class
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class NewInvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The invoice instance.
     *
     * @var Invoice
     */
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @param mixed $invoice
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->invoice->order;

        return $this->to($order->customer_email, $order->customer_full_name)
                //todo corrigir falha de envio
                ->from('noreply@mypharma2go.com.br', 'Atendimento da MP2GO')
                ->subject(trans('shop::app.mail.invoice.subject', ['order_id' => $order->increment_id]))
                ->view('shop::emails.sales.new-invoice');
    }
}
