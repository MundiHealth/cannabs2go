<?php

namespace Webkul\Customer\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;

class CustomerResetPassword extends ResetPassword
{

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            //todo corrigir falha de envio
            ->from('noreply@mypharma2go.com.br', 'Atendimento da MP2GO')
            ->subject(__('shop::app.mail.forget-password.subject') )
            ->view('shop::emails.customer.forget-password', [
                'user_name' => $notifiable->name,
                'token' => $this->token
            ]);
    }
}
