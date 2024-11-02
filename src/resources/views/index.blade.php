@extends('Layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="index">
        <div class="index_inner">
            <div class="index_form">
                <form class="search_form" id="filterForm" action="{{ route('products-filter') }}" method="GET">
                    <div class="search_container">
                        <div class="index_search_category">
                            <label class="index_search_label" for="category_id"></label>
                            <select class="index_search_select_category" name="category_id" id="category_id">
                                <option value="" class="placeholder">
                                    All category
                                </option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-caret-down"></i>
                        </div>
                        <div class="index_search_product_name">
                            <label class="index_search_label" for="product_name"></label>
                                <button type="submit" class="submit_product_name">
                                    <i class="fas fa-search search_icon"></i>
                                </button>
                            <input type="text" name="product_name" id="product_name" class="search_input" placeholder="Search ...">
                        </div>
                    </div>
                </form>
                <div class="index_nav">
                    <div class="index_products_create">
                        <a class="products_create_link" href="/products/create">
                            出品
                        </a>
                    </div>
                    <div class="index_user_edit">
                        <a class="user_edit_link" href="/user/edit">
                            プロフィール変更
                        </a>
                    </div>
                </div>
            </div>
            <div class="product_title">
                商品一覧
            </div>
            <div class="product_list">
                @foreach ($products as $product)
                    <div class="product_item">
                        <h2>{{ $product->name }}</h2>
                        <div class="product_images">
                            @foreach ($product->images as $image)
                                <img src="{{ asset($image->path) }}" alt="{{ $product->name }}" class="product_image">
                            @endforeach
                        </div>
                        <div class="product_price">
                            価格: ¥{{ intval($product->price) }}
                        </div>
                        <a href="{{ route('products-show', $product->id) }}" class="btn btn-primary">
                            詳細を表示
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterForm = document.getElementById('filterForm');
            const selects = filterForm.querySelectorAll('select');

            // カテゴリの選択ボックスにアニメーション効果を追加
            const categorySelect = document.getElementById('category_id');
            if (categorySelect) {
                categorySelect.addEventListener('change', function () {
                    categorySelect.classList.add('active'); // 選択時にクラス追加
                });
                categorySelect.addEventListener('blur', function () {
                    if (categorySelect.value === "") {
                        categorySelect.classList.remove('active'); // 選択が空ならクラスを削除
                    }
                });
            }

            selects.forEach(select => {
                select.addEventListener('change', function () {
                    filterForm.submit();
                });
            });
        });
        </script>
    @endsection
@endsection
