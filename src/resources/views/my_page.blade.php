@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}">
@endsection

@section('content')
<div class="mypage">
    <div class="mypage_inner">
        <h1 class="mypage_title">マイページ</h1>
        <h2 class="favorite_title">お気に入り商品一覧</h2>
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
                            <div class="favorite-button"
                                data-product-id="{{ $product->id }}"
                                data-is-favorite="{{ $product->isFavorited() ? 'true' : 'false' }}">
                            </div>
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
</div>

@endsection
