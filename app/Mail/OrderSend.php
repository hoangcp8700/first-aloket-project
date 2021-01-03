<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSend extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

            return $this->from('damnecogiko87@gmail.com','Aloket')
            ->to($this->data[0]['order']['email'],$this->data[0]['order']['name'])
            ->subject('Đơn hàng '.$this->data[0]['order']['order_code'])
            ->markdown('emails.testMail');

        // return $this->from('example@example.com','Aloket')


        // ->to($this->data['email'],$this->data['name'])
        // ->subject('Order #')
        //     ->view('emails.testMail');
    }
}
