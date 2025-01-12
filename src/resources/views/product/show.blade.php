@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product/show.css') }}">
@endsection

@section('content')
<div class="product_show">
    <div class="product_show_inner">
        <div class="product_show_name">
            {{ $product->name }}
        </div>
        <div class="product_show_images">
            @foreach ($product->images as $image)
                <img src="{{ asset($image->path) }}" alt="{{ $product->name }}" class="product_image">
            @endforeach
        </div>
        <div class="product_detail">
            詳細: {{ $product->detail }}
        </div>
        <div class="product_price">
            価格: ¥{{ number_format($product->price, 0) }}
        </div>
        <div class="product_stock">
            在庫: {{ $product->stock }}
        </div>
        <div class="product_category">
            カテゴリ: {{ $product->category->name ?? '未分類' }}
        </div>
        <div class="product_condition">
            商品状態: {{ $product->condition->name ?? '不明' }}
        </div>
        <div class="product_delivery_method">
            配送方法: {{ $product->deliveryMethod->name ?? '未定義' }}
        </div>
        <div class="product_user_name">
            出品者: {{ $product->user->name ?? '匿名' }}
        </div>
        <div class="product_show_link">
            <a href="{{ route('user-index') }}" class="btn back_button">
                一覧に戻る
            </a>
            @can('update', $product)
                <a href="{{ route('products-edit', $product->id) }}" class="btn edit_button">
                    編集する
                </a>
            @endcan
            <a href="{{ route('reviews-review', ['product' => $product->id]) }}" class="btn review_button">
                レビューを投稿する
            </a>
            <a href="{{ route('messages-index', ['receiver' => $product->user_id]) }}" class="btn message-create-btn">
                メッセージを送る
            </a>
        </div>
    </div>
</div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const images = document.querySelectorAll('.product_image');
                images.forEach(image => {
                    image.addEventListener('click', () => {
                        // 背景ぼかし用のオーバーレイを作成
                        const overlay = document.createElement('div');
                        overlay.classList.add('modal-overlay');
                        document.body.appendChild(overlay);
                        // モーダルを作成
                        const modal = document.createElement('div');
                        modal.classList.add('modal');
                        modal.innerHTML = `
                            <div class="modal-content">
                                <span class="close-button">&times;</span>
                                <img src="${image.src}" class="modal-image">
                            </div>
                        `;
                        document.body.appendChild(modal);
                        // モーダルを閉じる処理
                        modal.querySelector('.close-button').onclick = () => {
                            modal.remove();
                            overlay.remove(); // オーバーレイを削除
                        };
                    });
                });
            });

        </script>
    @endsection
@endsection
