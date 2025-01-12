@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sale/history.css') }}">
@endsection

@section('content')
<div class="sale_profile">
    <a class="profile_link" href="{{ route('profile-show', Auth::user()->id) }}">
        プロフィールへ戻る
    </a>
</div>
<h1 class="sales_title">販売履歴</h1>
    @foreach ($sales as $sale)
        <div class="sale">
            <h2 class="sale_id">
                販売ID: {{ $sale->id }} ({{ $sale->status->name }})
            </h2>
            <p class="sale_date">
                販売日: {{ $sale->created_at->format('Y-m-d') }}
            </p>
            <p class="sale_total">
                合計収益: ¥{{ number_format($sale->items->sum('seller_revenue')) }}
            </p>

            <h3 class="sale_products">販売商品</h3>
            <table>
                <thead>
                    <tr class="sale_table">
                        <th class="table_title">商品名</th>
                        <th class="table_title">数量</th>
                        <th class="table_title">単価</th>
                        <th class="table_title">収益</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->items as $item)
                        <tr>
                            <td class="table_item">{{ $item->product->name }}</td>
                            <td class="table_item">{{ $item->quantity }}</td>
                            <td class="table_item">¥{{ number_format($item->price) }}</td>
                            <td class="table_item">¥{{ number_format($item->seller_revenue) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endsection
