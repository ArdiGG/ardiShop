<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const PRICE_FROM = 'price_from';
    public const PRICE_TO = 'price_to';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::PRICE_FROM => [$this, 'price_from'],
            self::PRICE_TO => [$this, 'price_to'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function price_from(Builder $builder, $value)
    {
        $builder->where('price', '>=', $value);
    }

    public function price_to(Builder $builder, $value)
    {
        $builder->where('price', '<=', $value);
    }
}
