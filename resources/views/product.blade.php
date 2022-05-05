@extends('layouts.master')

@section('title', __('main.product'))

@section('content')
    <h1>{{$product->name}}</h1>
    <h2>{{$product->category->name}}</h2>
    <p>@lang('product.price'): <b>{{ $product->price }} @lang('main.rub').</b></p>
    <img src="{{ Storage::url($product->image) }}">
    <p>{{$product->description}}</p>

    @if($product->isAvailable())
        <form action="{{ route('basket-add', $product) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success" role="button">@lang('product.add_to_cart')</button>
        </form>
    @else
        <span>@lang('product.not_available')</span>
        <br>
        <span>@lang('product.tell_me'):</span>
        @include('auth.layouts.error', ['fieldname' => 'email']);
        <form action="{{ route('subscription', $product) }}" method="POST">
            @csrf
            <input type="text" name="email">
            <button type="submit">@lang('product.subscribe')</button>
        </form>
    @endif

@endsection
