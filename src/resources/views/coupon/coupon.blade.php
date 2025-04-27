@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/coupon/coupon.css') }}">
@endsection

@section('content')
<div class="coupon_list_container">
    <h1>取得済みクーポン一覧</h1>

    @if($coupons->isEmpty())
        <p>現在、利用可能なクーポンはありません。</p>
    @else
        <table class="coupon_table">
            <thead>
                <tr>
                    <th>クーポンコード</th>
                    <th>割引</th>
                    <th>有効期間</th>
                    <th>状態</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coupons as $coupon)
                    @if (!$coupon->is_used)
                        <tr>
                            <td>{{ $coupon->code }}</td>
                            <td>
                                {{ $coupon->discount_type === 'percentage' ? $coupon->discount . '%' : '¥' . number_format($coupon->discount, 2) }}
                            </td>
                            <td>{{ $coupon->valid_from }} 〜 {{ $coupon->valid_until }}</td>
                            <td>{{ $coupon->is_active ? '有効' : '無効' }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
