@extends('Layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/Cart/cart.css') }}">
@endsection

@section('content')
    <div class="cart">
        <h2 class="cart_title">カート</h2>
        <div class="cart_buttons">
            <!-- 全選択ボタン -->
            <button id="select-all-btn" class="btn">全選択</button>

            <!-- 複数選択ボタン -->
            <button id="multiple-select-btn" class="btn">複数選択</button>

            <div class="cart_button">
                <a href="{{ route('user-my-page') }}" class="btn back_button">一覧に戻る</a>
            </div>
        </div>

        <form action="{{ route('cart-purchase') }}" method="POST">
            @csrf
            <div id="product-list">
                @foreach ($carts as $cart)
                    <div class="cart_section">
                        <div class="cart_item">
                            <input type="checkbox" name="selected_items[]" value="{{ $cart->id }}" class="cart-checkbox">
                            <p class="item_title">{{ $cart->product->name }} - {{ $cart->quantity }}個</p>
                            <div class="cart_images">
                                @foreach ($cart->product->images as $image)
                                    <img src="{{ asset($image->path) }}" alt="{{ $cart->product->name }}" class="cart_image">
                                @endforeach
                            </div>
                            <div class="cart_price">
                                価格: ¥{{ intval($cart->product->price) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn purchase-btn">選択した商品を購入</button>
        </form>
    </div>

    <script>
        // 全選択ボタンのイベント
        document.getElementById('select-all-btn').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = true);
        });

        // 複数選択ボタンのイベント
        document.getElementById('multiple-select-btn').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = false);
        });
    </script>

@endsection
