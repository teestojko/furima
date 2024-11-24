@extends('Layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="index">
        <div id="overlay" style="display: none;"></div>
        <div class="index_inner">
            <div class="index_form">
                <div class="index_search">
                    <nav>
                        <button id="toggle-search-btn">検索</button>
                    </nav>
                </div>
                <!-- 検索フォーム -->
            <form id="search-form" action="{{ route('products-filter') }}" method="GET" style="display: none;">
                <div class="search_container">
                    <!-- カテゴリ選択 -->
                    <div class="index_search_category">
                        <label class="index_search_label" for="category_id">カテゴリ</label>
                        <select class="index_search_select_category" name="category_id" id="category_id">
                            <option value="">All category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 商品名検索 -->
                    <div class="index_search_product_name">
                        <label class="index_search_label" for="product_name">商品名</label>
                        <input type="text" name="product_name" id="product_name" class="search_input" placeholder="Search ..." value="{{ request('product_name') }}">
                    </div>

                    <!-- 価格帯の絞り込み -->
                    <div class="index_search_price_range">
                        <label class="index_search_label" for="min_price">価格帯</label>
                        <input type="number" name="min_price" id="min_price" placeholder="Min" value="{{ request('min_price') }}">
                        <input type="number" name="max_price" id="max_price" placeholder="Max" value="{{ request('max_price') }}">
                    </div>

                    <!-- 価格順の並び替え -->
                    <div class="index_search_price_order">
                        <label class="index_search_label" for="price_order">価格順</label>
                        <select name="price_order" id="price_order">
                            <option value="">Select</option>
                            <option value="asc" {{ request('price_order') == 'asc' ? 'selected' : '' }}>安い順</option>
                            <option value="desc" {{ request('price_order') == 'desc' ? 'selected' : '' }}>高い順</option>
                        </select>
                    </div>

                    <!-- 人気順の並び替え -->
                    <div class="index_search_popularity">
                        <label class="index_search_label" for="popularity">人気順</label>
                        <select name="popularity" id="popularity">
                            <option value="">Select</option>
                            <option value="desc" {{ request('popularity') == 'desc' ? 'selected' : '' }}>
                                人気順
                            </option>
                        </select>
                    </div>
                </div>

                <!-- 検索ボタン -->
                <div class="search_button">
                    <button class="search_button_link" type="submit">
                        検索
                    </button>
                </div>
            </form>
            </div>

            <div id="app">
                <button_hover></button_hover>
            </div>
            <script src="{{ mix('js/app.js') }}"></script>

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
                            ¥{{ number_format($product->price, 0) }}
                        </div>
                        <div class="detail_and_favorite">
                            <div class="product_detail">
                                <a href="{{ route('products-show', $product->id) }}" class="btn btn-primary">
                                    詳細を表示
                                </a>
                            </div>
                            <form class="product_favorite_button" action="{{ $product->isFavorited() ? route('favorites-toggle-remove', ['product' => $product->id]) : route('favorites-toggle-add', ['product' => $product->id]) }}" method="POST">
                            @csrf
                                @if ($product->isFavorited())
                                @method('DELETE')
                                    <button type="submit" class="submit_favorite">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                @else
                                    <button type="submit" class="submit_not_favorite">
                                        <i class="far fa-heart"></i>
                                    </button>
                                @endif
                            </form>
                        </div>
                        <div class="product_cart_link">
                            <form action="{{ route('cart-add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="number" name="quantity" min="1" value="1" required>
                                <button type="submit">
                                    カートに追加
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.getElementById('toggle-search-btn').addEventListener('click', function () {
                var searchForm = document.getElementById('search-form');
                var overlay = document.getElementById('overlay');
                // フォームとオーバーレイの表示状態を切り替え
                if (searchForm.style.display === 'none' || searchForm.style.display === '') {
                    searchForm.style.display = 'block';
                    overlay.style.display = 'block';
                } else {
                    searchForm.style.display = 'none';
                    overlay.style.display = 'none';
                }
            });
            // オーバーレイをクリックしてもフォームを非表示にする
            document.getElementById('overlay').addEventListener('click', function () {
                document.getElementById('search-form').style.display = 'none';
                document.getElementById('overlay').style.display = 'none';
            });
        </script>
    @endsection
@endsection
