<?php

namespace App\Services;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\ProductsFilterRequest;
use App\Models\Product;
use Illuminate\Support\Facades\App;

class MainService
{
    public function index(array $data)
    {
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($data)]);

        $productsQuery = Product::with('category')->filter($filter);

        foreach (['hit', 'recommend', 'new'] as $field) {
            if (isset($data[$field])) {
                $productsQuery->$field();
            }
        }

        $products = $productsQuery->orderBy('id')->paginate(6);

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
