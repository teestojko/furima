@extends('Layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/Admin/coupon_create.css') }}">
@endsection

@section('content')
<h1>クーポン作成</h1>
<form action="{{ route('admin-coupons-store') }}" method="POST">
    @csrf
    <div>
        <label for="code">クーポンコード:</label>
        <input type="text" name="code" id="code" required>
    </div>
    <div>
        <label for="discount">割引:</label>
        <input type="number" name="discount" id="discount" required min="1">
    </div>
    <div>
        <label for="discount_type">割引タイプ:</label>
        <select name="discount_type" id="discount_type" required>
            <option value="fixed">固定額</option>
            <option value="percentage">パーセンテージ</option>
        </select>
    </div>
    <div>
        <label for="valid_from">開始日:</label>
        <input type="date" name="valid_from" id="valid_from" required>
    </div>
    <div>
        <label for="valid_until">有効期限:</label>
        <input type="date" name="valid_until" id="valid_until" required>
    </div>
    <button type="submit">クーポン作成</button>
</form>
@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
