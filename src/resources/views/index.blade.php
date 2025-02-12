@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ mix('css/sidebar.css') }}">
@endsection

@section('content')

    {{-- Vue.js/React用のデータを渡す --}}
    <div id="categories" data-categories='@json($categories)'></div>
    <div id="filter-url" data-url="{{ route('products-filter') }}"></div>

    <div id="sidebar"></div>

    <div class="index">
        <div class="index_inner">

            @for ($i = 0; $i < 10; $i++)
                <div class="light-effect"></div>
            @endfor

            <div id="search-form"></div>

            <div class="product_content">
                <div class="product_title">
                    商品一覧
                </div>
                <div class="index_points">
                    <div class="user-points">
                        <span class="points-label">保有ポイント:</span>
                        <span class="points-value">{{ number_format($points) }} pt</span>
                    </div>
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

            <div class="coupon_list_container">
                <h1 class="coupon_list_title">クーポン一覧</h1>
                @if($coupons->isEmpty())
                    <p class="coupon_list_none">現在、利用可能なクーポンはありません。</p>
                @else
                    <div class="coupon-list">
                        @foreach ($coupons as $coupon)
                            <div class="coupon-card">
                                <p>クーポンコード: {{ $coupon->code }}</p>
                                <p>割引: {{ $coupon->discount }} @if($coupon->discount_type == 'percentage') % @else 円 @endif</p>

                                @if(is_null($coupon->user_id))
                                    <form action="{{ route('coupons.claim', $coupon->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="coupon-button">クーポンを取得</button>
                                    </form>
                                @else
                                    <p>✅ 取得済み</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
    <!-- React のエントリポイント -->
    <div id="app"></div>

    <script src="{{ mix('js/app.js') }}"></script>

@endsection

