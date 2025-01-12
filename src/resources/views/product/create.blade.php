@extends('Layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">

<link rel="stylesheet" href="{{ asset('css/Product/create.css') }}">
@endsection

@section('content')
    <div class="product_create">
        <div class="product_create_inner">
            <div class="inner_title">
                出品
            </div>
            <form class="product_create_form" action="{{ route('products-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="product_create_content">
                    <div class="content_title">
                        画像
                    </div>
                    <label class="images_label" for="images" >
                        画像を選択
                    </label>
                    <input type="file" name="images[]" id="images" multiple>
                    <div id="file_name">
                        選択ファイル名
                    </div>
                </div>
                <div class="product_create_content">
                    <div class="content_title">
                        商品名
                    </div>
                    <label class="name_label" for="name"></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}">
                </div>
                @error('name')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
                <div class="product_create_content">
                    <div class="content_title">
                        価格
                    </div>
                    <label class="price_lavel" for="price"></label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}">
                </div>
                @error('price')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
                <div class="product_create_content">
                    <div class="content_title">
                        在庫
                    </div>
                    <label class="stock_lavel" for="stock"></label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}">
                </div>
                @error('stock')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
                <div class="product_create_content">
                    <div class="content_title">
                        カテゴリー
                    </div>
                    <label class="category_label" for="category"></label>
                    <select name="category_id" id="category">
                        <option value="">
                            選択してください
                        </option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('category_id')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
                <div class="product_create_content">
                    <div class="content_title">
                        商品の状態
                    </div>
                    <label class="condition_label" for="condition"></label>
                    <select name="condition_id" id="condition">
                        <option value="">選択してください</option>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('condition_id')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
                <div class="product_create_content2">
                    <div class="content_title2">
                        詳細
                    </div>
                    <label class="detail_label" for="detail"></label>
                    <textarea name="detail" id="detail">{{ old('detail') }}</textarea>
                </div>
                @error('detail')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
                <div class="product_create_button">
                    <button class="product_create_button_button" type="submit">
                        出品する
                    </button>
                </div>
            </form>
            <div class="product_create_back_button">
                <a class="product_create_back_button_link" href="{{ route('user-index')}}">
                    戻る
                </a>
            </div>
        </div>
        @if (session('success'))
            <p class="success_message">
                {{ session('success') }}
            </p>
        @endif
    </div>
    <script>
        document.getElementById('images').addEventListener('change', function(){
            const fileName = this.files[0].name;
            document.getElementById('file_name').textContent = fileName;
        });
    </script>
@endsection
