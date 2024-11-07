@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="profile-header">
        <div class="profile_back_button">
            <a href="{{ route('user-my-page') }}" class="btn back_button">
                一覧に戻る
            </a>
        </div>
        <img class="profile-image" src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}">
        <h2>
            {{ $user->name }}
        </h2>
        <p>
            評価: {{ $user->rating }} / 5
        </p>
        <p>
            出品商品数: {{ $user->products()->count() }}
        </p>
        <div class="profile_user_edit">
            <a class="profile_user_edit_link" href="/user/edit">
                プロフィール変更
            </a>
        </div>
        {{-- <p>購入商品数: {{ $user->purchases()->count() }}</p> --}}
    </div>

    <div class="product-list mt-4">
        <h3>
            出品中の商品
        </h3>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset($product->images->first()->path) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $product->title }}
                            </h5>
                            <p class="card-text">
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
