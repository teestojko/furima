@extends('Layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/Review/index.css') }}">
@endsection

@section('content')
    <div class="reviews_index">
        <div class="reviews_index_title">
            {{ $product->name }}のレビュー
        </div>
        @if ($reviews->isEmpty())
            <div class="reviews_index_not_reviews">
                この店舗にはまだレビューを投稿していません。
            </div>
        @else
            <ul class="reviews_index_table">
                @foreach ($reviews as $review)
                    <table class="table_inner">
                        <tr class="table_content">
                            <td class="table_item">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $review->stars ? 'filled' : '' }}">&#9733;</span>
                                @endfor
                            </td>
                        </tr>
                        <tr class="table_content_comment_title">
                            <td class="table_item_comment_title">
                                コメント
                            </td>
                        </tr>
                        <tr class="table_content_comment">
                            <td class="table_item_comment">
                                {{ $review->comment }}
                            </td>
                        </tr>
                    </table>
                    <form class="reviews_index_form" action="{{ route('reviews-destroy', $review->id) }}" method="POST">
                    @csrf
                        @method('DELETE')
                            <button class="reviews_index_button" type="submit">
                                レビューを削除
                            </button>
                        </form>
                @endforeach
            </ul>
        @endif
        <div class="reviews_index_back_button">
            <a class="reviews_index_back_button_link" href="{{ route('reviews-review', ['product' => $product->id]) }}">
                戻る
            </a>
        </div>
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('ellor'))
            <div class="alert-success">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endsection
