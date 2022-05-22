<?php

namespace App\Services;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Product;
use Illuminate\Support\Facades\App;

class MainService
{
    public function index(array $data)
    {
        $productsQuery = Product::with('category');

        if (isset($data['price_from'])) {
            $productsQuery->where('price', '>=', $data['price_from']);
        }

        if (isset($data['price_to'])) {
            $productsQuery->where('price', '<=', $data['price_to']);
        }

        foreach (['hit', 'recommend', 'new'] as $field) {
            if (isset($data[$field])) {
                $productsQuery->$field();
            }
        }

        $products = $productsQuery->orderByDesc('id')->paginate(6)->withPath("?" . $data['query_string']);

        return $products;
    }

    public function changeLocale($locale)
    {
        $availibleLocales = ['ru', 'en'];

        if (!in_array($locale, $availibleLocales)) {
            $locale = config('app.locale');
        }

        session(['locale' => $locale]);

        App::setLocale($locale);
    }
}
