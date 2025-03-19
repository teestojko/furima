@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/cart/cart.css') }}">
@endsection

@section('content')
    <div class="cart">
        <div class="cart_inner">
            <h2 class="cart_title">カート</h2>
            <div class="cart_buttons">
                <div class="cart_button">
                    <a href="{{ route('user-index') }}" class="btn back_button">一覧に戻る</a>
                </div>
            </div>
            @if ($carts->isEmpty())
                <p class="cart_empty_message">カートに商品が追加されていません。</p>
            @else
                <form action="{{ route('cart-purchase') }}" method="POST">
                    @csrf
                        <div id="product_list">
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
                    <div class="btn_content">
                        <button id="select_all_btn" type="button" class="btn">全選択</button>
                        <button type="submit" class="btn purchase_btn">選択した商品を購入</button>
                    </div>
                </form>
            @endif
            <div class="alert_messages">
                @if (session('error'))
                    <div class="alert-error">
                        <p class="error_message">
                            {{ session('error') }}
                        </p>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert_success">
                        <p class="success_message">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // 全選択ボタンのイベント
        document.getElementById('select_all_btn').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = true);
        });
    </script>

@endsection

