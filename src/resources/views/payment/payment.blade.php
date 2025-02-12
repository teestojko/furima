@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment/payment.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endsection

@section('content')
    <div class="payment_main">
        <a href="{{ route('cart-view') }}" class="btn cart_back_btn">
            カートへ戻る
        </a>
        <div class="content_main">

            <div class="title">
                決済ページ
            </div>

            <form action="{{ route('coupon-apply') }}" method="POST">
                @csrf
                <label for="coupon_id">クーポンを選択:</label>
                <select name="coupon_id" id="coupon_id" required>
                    <option value="">-- クーポンを選択 --</option>
                    @foreach (Auth::user()->coupons as $coupon)
                        @if (!$coupon->is_used) {{-- 使用済みは表示しない --}}
                            <option value="{{ $coupon->id }}">
                                {{ $coupon->code }}（
                                @if ($coupon->discount_type === 'percentage')
                                    -{{ intval($coupon->discount) }}%
                                @else
                                    -¥{{ number_format($coupon->discount) }}
                                @endif
                                ）
                            </option>
                        @endif
                    @endforeach
                </select>
                <button type="submit">クーポンを適用</button>
            </form>

            <form action="{{ route('point-apply') }}" method="POST">
                @csrf
                <label for="use_points">使用するポイント:</label>
                <input type="number" name="use_points" id="use_points" min="0" max="{{ Auth::user()->points }}">
                <button type="submit">ポイントを使用</button>
            </form>

            <!-- 合計金額を表示 -->
            <div class="total_amount">
                <p class="amount_title">
                    合計金額: ¥{{ number_format(session('discounted_amount', session('total_amount')) - session('used_points', 0)) }}
                </p>
            </div>

            <form class="payment_form" action="{{ route('payment-process') }}" method="POST">
                @csrf
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ env('STRIPE_KEY') }}"
                    data-amount="{{ session('final_amount', session('discounted_amount', session('total_amount'))) }}"
                    data-name="Stripe決済デモ"
                    data-label="決済をする"
                    data-description="これはデモ決済です"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-currency="JPY">
                </script>
            </form>
        </div>
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
    </div>
@endsection
