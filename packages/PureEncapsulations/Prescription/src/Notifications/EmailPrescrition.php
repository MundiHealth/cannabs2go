<?php
/**
 * Created by PhpStorm.
 * User: zaira
 * Date: 09/02/20
 * Time: 22:09
 */

namespace PureEncapsulations\Prescription\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailPrescrition extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            //todo corrigir falha de envio
            ->from('noreply@mypharma2go.com.br', 'Atendimento da MP2GO')
            ->subject(__('shop::app.mail.confirmation-prescription.subject') )
            ->view('shop::emails.sales.email-prescription', [
                'dados' => $this->dados
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

}