@extends('Layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <a class="products_create_link" href="/products/create">
        出品へ進む
    </a>
@endsection
