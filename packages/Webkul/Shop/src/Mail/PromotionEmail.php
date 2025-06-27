<?php

namespace Webkul\Shop\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromotionEmail extends Mailable
{

    use Queueable, SerializesModels;

    public $customer_data;
    public function __construct($customer_data)
    {
        $this->customer_data = $customer_data;
    }

    public function build()
    {
        return $this->to($this->customer_data['customer_email'])
            ->from('atendimento@mypharma2go.com', 'Atendimento da MP2GO')
            ->subject('Mounjaro Projeto Verão 2025')
            ->view('shop::emails.sales.promotion');
    }

}