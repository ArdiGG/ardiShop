<?php

namespace App\Services\Basket;

use App\Helpers\Basket;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BasketService
{
    public function index()
    {
        $orderId = session('orderId');
        $order = null;

        if (!is_null($orderId)) {
            $order = Order::findOrFail($orderId);
        }

        return $order;
    }

    public function place()
    {
        $basket = new Basket();

        $order = $basket->getOrder();

        if(!$basket->countAvailable()){
            session()->flash('warning', __('basket.you_cant_order_more'));
            return redirect()->route('basket');
        }

        return $order;
    }

    public function confirm(array $data)
    {
        $data['email'] = Auth::check() ? Auth::user()->email : $data['email'];

        if ((new Basket())->saveOrder($data)) {
            session()->flash('success', __('basket.you_order_confirmed'));
        } else {
            session()->flash('warning', __('basket.you_cant_order_more'));
        }

        Order::eraseFullSum();
    }

    public function store(Product $product)
    {
        $result = (new Basket(true))->addProduct($product);

        if($result) {
            session()->flash('success', __('basket.added') . $product->name);
        } else {
            session()->flash('warning', $product->name . __('basket.not_available_more'));
        }
    }

    public function remove(Product $product)
    {
        (new Basket())->removeProduct($product);

        session()->flash('warning', __('basket.removed') . $product->name);
    }
}
