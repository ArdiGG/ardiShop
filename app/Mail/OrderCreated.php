<?php

namespace App\Mail;

use App\Helpers\Basket;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $order;

    /**
     * @param $name
     * @param $order
     */
    public function __construct($name, Order $order)
    {
        $this->name = $name;
        $this->order = $order;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fullSum = $this->order->calculateFullSum();

        return $this->view('mail.order_created', [
            'name' => $this->name,
            'order' => $this->order,
            'fullSum' => $fullSum
        ]);
    }
}
