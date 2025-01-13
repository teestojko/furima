@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="index">
        <div class="index_inner">




            <link rel="stylesheet" href="{{ mix('css/sidebar.css') }}">
            <div id="sidebar"></div>
            <script src="{{ mix('js/app.js') }}"></script>




            <div id="app">
                <index_form
                    :categories='@json($categories)'
                    :filter-url="'{{ route('products-filter') }}'">
                </index_form>
                <index_nav></index_nav>
            </div>
            <script src="{{ mix('js/app.js') }}"></script>





            <div class="product_content">
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
    </div>
@endsection

