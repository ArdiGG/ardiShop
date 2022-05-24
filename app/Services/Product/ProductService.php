<?php

namespace App\Services\Product;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Traits\Uploadable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Ramsey\Uuid\Uuid;

class ProductService
{
    use Uploadable;


    public function store(array $data)
    {
        if (isset($data['load_image'])) {
            $data['image'] = $this->uploadImage($data['load_image']);
        }

        Product::create($data);
    }

    public function update(array $data, Product $product)
    {
        if (isset($data['load_image'])) {
            Storage::delete($product->image);

            $data['image'] = $this->uploadImage($data['load_image']);
        }

        foreach (['new', 'hit', 'recommend'] as $fieldName) {
            if (!isset($data[$fieldName])) {
                $data[$fieldName] = 0;
            }
        }

        $product->update($data);
    }

    public function uploadImage($image)
    {
        $name = uuid::uuid4();
        $folder = '/products/';
        $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();

        $this->uploadOne($image, $folder, 'public', $name);

        return $filePath;
    }
}
