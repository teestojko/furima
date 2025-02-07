@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/product/create.css') }}">
<link rel="stylesheet" href="{{ mix('css/sidebar.css') }}">
@endsection

@section('content')
    <div class="product_create">
        <div class="product_create_inner">

            <!-- React Sidebar のマウントポイント -->
            <div id="sidebar"></div>

            <div class="inner_title">
                出品
            </div>
            <form class="product_create_form" action="{{ route('products-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="product_create_content">
                    <div class="content_title">
                        商品名
                    </div>
                    <label class="name_label" for="name"></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}">
                </div>
                <div class="product_create_content">
                    <div class="content_title">
                        価格
                    </div>
                    <label class="price_lavel" for="price"></label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}">
                </div>
                <div class="product_create_content">
                    <div class="content_title">
                        在庫
                    </div>
                    <label class="stock_lavel" for="stock"></label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}">
                </div>
                <div class="product_create_content">
                    <div class="content_title">
                        カテゴリー
                    </div>
                    <label class="category_label" for="category"></label>
                    <select name="category_id" id="category">
                        <option value="">
                            選択
                        </option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="product_create_content">
                    <div class="content_title">
                        状態
                    </div>
                    <label class="condition_label" for="condition"></label>
                    <select name="condition_id" id="condition">
                        <option value="">選択</option>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="product_create_content2">
                    <div class="content_title2">
                        詳細
                    </div>
                    <label class="detail_label" for="detail"></label>
                    <textarea name="detail" id="detail">{{ old('detail') }}</textarea>
                </div>

                <!-- React FileDisplay のマウントポイント -->
                <div id="file-display"></div>

                <div class="product_create_button">
                    <button class="product_create_button_button" type="submit">
                        出品する
                    </button>
                </div>
            </form>
        </div>
        <div class="alert_messages">
            @if ($errors->any())
                <div class="alert alert_danger">
                    <h3>エラーが発生しました：</h3>
                    <ul class="error_ul">
                        @foreach ($errors->all() as $error)
                            <li class="error_message">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert_success">
                    <p class="success_message">{{ session('success') }}</p>
                </div>
            @endif
        </div>

    </div>

    <!-- React のエントリポイント -->
    <div id="app"></div>

@section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endsection

@endsection



