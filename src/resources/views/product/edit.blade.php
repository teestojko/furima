@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/product/edit.css') }}">
@endsection

@section('content')
    <form action="{{ route('products-update', $product->id) }}" method="POST" enctype="multipart/form-data" class="product-form">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name" class="form-label">商品名:</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="form-input">
    </div>

    <div class="form-group">
        <label for="detail" class="form-label">商品詳細:</label>
        <textarea name="detail" id="detail" required class="form-textarea">{{ old('detail', $product->detail) }}</textarea>
    </div>

    <div class="form-group">
        <label for="price" class="form-label">価格:</label>
        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required class="form-input">
    </div>

    <div class="form-group">
        <label for="stock" class="form-label">在庫:</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required class="form-input">
    </div>

    <div class="form-group">
        <label for="category_id" class="form-label">カテゴリ:</label>
        <select name="category_id" id="category_id" required class="form-select">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="condition_id" class="form-label">状態:</label>
        <select name="condition_id" id="condition_id" required class="form-select">
            @foreach($conditions as $condition)
                <option value="{{ $condition->id }}" {{ $condition->id == $product->condition_id ? 'selected' : '' }}>
                    {{ $condition->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="images" class="form-label">画像:</label>
        <input type="file" name="images[]" id="images" multiple class="form-file-input">
    </div>

    <button type="submit" class="form-button">更新</button>

    @if(session('success'))
        <div class="form-success">{{ session('success') }}</div>
    @endif
</form>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('images');
        const previewContainer = document.createElement('div');
        imageInput.parentNode.appendChild(previewContainer);

        imageInput.addEventListener('change', function () {
            previewContainer.innerHTML = ''; // プレビューをリセット
            Array.from(imageInput.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    });
    </script>
@endsection
@endsection
