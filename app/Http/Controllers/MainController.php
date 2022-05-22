<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subscription;
use App\Services\MainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MainController extends Controller
{
    private MainService $service;

    public function __construct(MainService $service)
    {
        $this->service = $service;
    }

    public function index(ProductsFilterRequest $request)
    {
        $data = $request->all();
        $data['query_string'] = $request->getQueryString();

        $products = $this->service->index($data);

        return view('index', compact('products'));
    }

    public function categories()
    {
        $categories = Category::get();

        return view('categories', compact('categories'));
    }

    public function product($category, $productCode)
    {
        $product = Product::withTrashed()->byCode($productCode)->first();

        return view('product', compact('product'));
    }

    public function category($code)
    {
        $category = Category::where('code', $code)->firstOrFail();

        return view('category', compact('category'));
    }

    public function subscribe(SubscriptionRequest $request, Product $product)
    {
        Subscription::create([
            'email' => $request->email,
            'product_id' => $product->id
        ]);

        return redirect()->back()->with('Спасибо, мы сообщим Вам о поступлении товара');
    }

    public function changeLocale($locale)
    {
        $availibleLocales = ['ru', 'en'];

        if (!in_array($locale, $availibleLocales)) {
            $locale = config('app.locale');
        }

        session(['locale' => $locale]);

        App::setLocale($locale);

        return redirect()->back();
    }
}
