@extends('Layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <form action="{{ route('products-update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="name">商品名:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div>
            <label for="detail">商品詳細:</label>
            <textarea name="detail" id="detail" required>{{ old('detail', $product->detail) }}</textarea>
        </div>

        <div>
            <label for="price">価格:</label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required>
        </div>

        <div>
            <label for="stock">在庫:</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required>
        </div>

        <div>
            <label for="category_id">カテゴリ:</label>
            <select name="category_id" id="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="condition_id">状態:</label>
            <select name="condition_id" id="condition_id" required>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ $condition->id == $product->condition_id ? 'selected' : '' }}>
                        {{ $condition->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="images">画像:</label>
            <input type="file" name="images[]" id="images" multiple>
        </div>

        <button type="submit">更新</button>
    </form>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
@endsection
