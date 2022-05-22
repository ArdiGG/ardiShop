<?php

namespace App\Http\Controllers\Basket;

use App\Helpers\Basket;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\Basket\BasketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Object_;

class BasketController extends Controller
{
    private BasketService $service;

    public function __construct(BasketService $service)
    {
        $this->service = $service;
    }

    public function basket()
    {
        $order = $this->service->index();

        return view('basket', ['order' => $order]);
    }

    public function basketPlace()
    {
        $order = $this->service->place();

        return view('order', compact('order'));
    }

    public function basketConfirm(Request $request)
    {
        $data = $request->all();

        $this->service->confirm($data);

        return redirect()->route('basket');
    }

    public function store(Product $product)
    {
        $this->service->store($product);

        return redirect()->route('basket');
    }

    public function remove(Product $product)
    {
        $this->service->remove($product);

        return redirect()->route('basket');
    }
}
