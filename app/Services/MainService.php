<?php

namespace App\Services;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Product;

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
}
