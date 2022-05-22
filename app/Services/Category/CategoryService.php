<?php

namespace App\Services\Category;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class CategoryService
{
    public function store(array $data)
    {
        $data['image'] = $this->uploadImage($data['load_image']);

        Category::create($data);
    }

    public function update(array $data, Category $category)
    {
        if (isset($params['load_image'])) {
            Storage::delete($category->image);

            $data['image'] = $this->uploadImage($data['load_image']);
        }
        $category->update($params);

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
