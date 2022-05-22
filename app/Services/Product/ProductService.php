<?php

namespace App\Services\Product;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        if (isset($data['image'])) {
            $data['image'] = $request->file('image')->store('products');
        }

        Product::create($data);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->all();

        if (isset($data['image'])) {
            Storage::delete($product->image);
            $data['image'] = $request->file('image')->store('products');
        }

        foreach (['new', 'hit', 'recommend'] as $fieldName){
            if(!isset($data[$fieldName])){
                $data[$fieldName] = 0;
            }
        }

        $product->update($data);
    }
}
