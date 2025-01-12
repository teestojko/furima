@extends('Layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Order/history.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endsection

@section('content')
<div class="order_profile">
    <a class="profile_link" href="{{ route('profile-show', Auth::user()->id) }}">
        プロフィールへ戻る
    </a>
</div>
<h1 class="order_title">購入履歴</h1>
    @foreach ($orders as $order)
        <div class="order">
            <h2 class="order_id">
                注文ID: {{ $order->id }} ({{ $order->status->name }})
            </h2>
            <p class="order_date">
                <i class="fa fa-calendar"></i>
                注文日: {{ $order->order_date }}
            </p>
            <p class="order_price">
                <i class="fa fa-yen-sign"></i>
                合計金額: ¥{{ number_format($order->total_price) }}
            </p>

            <h3 class="order_product">購入商品</h3>
            <table>
                <thead>
                    <tr class="order_table">
                        <th class="table_title">
                            商品名
                        </th>
                        <th class="table_title">
                            数量
                        </th>
                        <th class="table_title">
                            単価
                        </th>
                        <th class="table_title">
                            合計金額
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="order_teble">
                            <td class="table_item">
                                {{ $item->product->name }}
                            </td>
                            <td class="table_item">
                                {{ $item->quantity }}
                            </td>
                            <td class="table_item">
                                ¥{{ number_format($item->price) }}
                            </td>
                            <td class="table_item">
                                ¥{{ number_format($item->quantity * $item->price) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endsection
