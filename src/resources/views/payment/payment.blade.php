@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment/payment.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endsection

@section('content')
    <div class="payment_main">
        <div class="content_main">
            <div class="title">
                決済ページ
            </div>
            <form action="{{ route('coupon-apply') }}" method="POST">
                    @csrf
                    <label for="coupon_code">クーポンコード:</label>
                    <input type="text" name="coupon_code" id="coupon_code" required>
                    <button type="submit">クーポンを適用</button>
            </form>

            <!-- 合計金額を表示 -->
            <div class="total_amount">
                <p class="amount_title">合計金額: ¥{{ number_format(session('discounted_amount', session('total_amount'))) }}</p>
            </div>

            <form class="payment_form" action="{{ route('payment-process') }}" method="POST">
                @csrf
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ env('STRIPE_KEY') }}"
                    data-amount="{{ session('discounted_amount', session('total_amount')) }}"
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
