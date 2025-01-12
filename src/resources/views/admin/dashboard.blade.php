@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endsection

@section('content')
    <h1>管理者ダッシュボード</h1>

<div class="dashboard-buttons">
    <a href="{{ route('admin-coupons-create') }}" class="btn btn-primary">クーポン作成</a>
</div>
@endsection
