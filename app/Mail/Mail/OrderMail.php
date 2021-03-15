<?php

namespace App\Mail\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $nombre;
    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($order)
    {
        //
        $this->order=$order;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->view("store.orders.compras-mail")
            ->from("silvahfreddy@gmail.com")
            ->subject("Bienvenida a mi sitio");
    }
}
