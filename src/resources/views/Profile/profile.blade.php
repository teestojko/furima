@extends('Layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Profile/profile.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="profile-header">
        <div class="profile_back_button">
            <a href="{{ route('user-index') }}" class="btn back_button">
                一覧に戻る
            </a>
            <a class="profile_user_edit_link" href="/user/edit">
                プロフィール変更
            </a>
            <a href="{{ route('order-history') }}" class="btn profile_button">
                購入履歴
            </a>
            <a href="{{ route('sale-history') }}" class="btn sale_button">
                販売履歴
            </a>
            <a href="{{ route('notifications-show') }}" class="btn message_button">
                メール一覧
            </a>
        </div>
        <img class="profile-image" src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}">
        <h2>
            {{ $user->name }}
        </h2>
        <div class="star-rating">
            @for ($i = 1; $i <= 5; $i++)
                @php
                    // 各星の塗りつぶし割合を計算
                    $fillPercentage = max(0, min(100, ($averageStars - ($i - 1)) * 100));
                @endphp
                <span class="star" style="background: linear-gradient(90deg, gold {{ $fillPercentage }}%, lightgray {{ $fillPercentage }}%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">&#9733;</span>
            @endfor
        </div>
        <p>
            平均評価: {{ number_format($averageStars, 1) }}
        </p>
        <p>
            出品商品数: {{ $user->products()->count() }}
        </p>
    </div>

    <div class="profile_sale">
        <h3 class="profile_sale_heading">
            出品中の商品
        </h3>
        <div class="profile_sale_inner">
            @foreach ($products as $product)
                <div class="sale_content">
                    <div class="sale_section">
                        <img src="{{ asset($product->images->first()->path) }}" class="profile_sale_image" alt="{{ $product->name }}">
                        <div class="sale_item">
                            <h5 class="sale_title">
                                {{ $product->name }}
                            </h5>
                            <p class="sale_plice">
                                {{ $product->price }}円
                            </p>
                            <a href="{{ route('products-show', $product->id) }}" class="btn btn-primary">
                                詳細を見る
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
