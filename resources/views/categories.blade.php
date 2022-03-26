@extends('layouts.master')

@section('title', 'Все Категории')

@section('content')

    <h1>Все категории</h1>

    <div class="row">
            @foreach($categories as $category)
            <div class="col-sm-3 col-md-4">
                <a href="{{route('category', $category->code)}}">
                    <img src="{{ Storage::url($category->image) }}">
                    <h2>{{$category->name}}</h2>
                </a>
                <p>
                    {{$category->description}}
                </p>
            </div>
            @endforeach
        </div>
@endsection
