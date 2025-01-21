@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}">
<link rel="stylesheet" href="{{ mix('css/sidebar.css') }}">
@endsection

@section('content')
<div class="mypage">

    <div id="sidebar"></div>


    <h1>マイページ</h1>
    <h2>お気に入り商品一覧</h2>
    <div class="index_back_button">
        <a href="{{ route('user-index') }}" class="btn back_button">
            一覧に戻る
        </a>
    </div>
    @if ($favoriteProducts->isEmpty())
        <p>お気に入り商品はありません。</p>
    @else
        <div class="favorite_list">
            @foreach ($favoriteProducts as $product)
                <div class="favorite_item">
                        <h2>{{ $product->name }}</h2>
                        <div class="favorite_images">
                            @foreach ($product->images as $image)
                                <img src="{{ asset($image->path) }}" alt="{{ $product->name }}" class="favorite_image">
                            @endforeach
                        </div>
                        <div class="favorite_price">
                            価格: ¥{{ intval($product->price) }}
                        </div>
                        <div class="detail_and_favorite">
                            <div class="favorite_detail">
                                <a href="{{ route('products-show', $product->id) }}" class="btn btn-primary">
                                    詳細を表示
                                </a>
                            </div>
                            <form class="favorite_favorite_button" action="{{ $product->isFavorited() ? route('favorites-toggle-remove', ['product' => $product->id]) : route('favorites-toggle-add', ['product' => $product->id]) }}" method="POST">
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
                        <div class="favorite_cart_link">
                            <form action="{{ route('cart-add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="favorite_id" value="{{ $product->id }}">
                                <input type="number" name="quantity" min="1" value="1" required>
                                <button type="submit">
                                    カートに追加
                                </button>
                            </form>
                        </div>
                    </div>
            @endforeach
        </div>
    @endif
</div>

<script src="{{ mix('js/app.js') }}"></script>


@endsection
