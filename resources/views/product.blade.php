@extends('layouts.master')

@section('title', 'Product');

@section('content')
    <h1>{{$product->name}}</h1>
    <h2>{{$product->category->name}}</h2>
    <p>Цена: <b>{{$product->price}} ₽</b></p>
    <img src="{{ Storage::url($product->image) }}">
    <p>{{$product->description}}</p>

    <form action="/basket/add/1" method="POST">
        <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>

        <input type="hidden" name="_token" value="LHu1Do7vOcWjQGDTexHFj9q9Jn1GxNjQv7yeG6pv">
    </form>
@endsection
