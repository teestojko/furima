@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endsection

@section('content')
<div class="dashboard">
    <h1 class="dashboard_title">管理者ダッシュボード</h1>

    <div class="dashboard_content">
        <div class="dashboard_link">
            <a href="{{ route('admin.coupons-create') }}" class="btn btn_primary">クーポン作成</a>
        </div>

        <div class="dashboard_nav">
            <nav class="dashboard_nav_btn">
                <a class="btn btn_primary" href="{{ route('admin.categories.index') }}">
                    カテゴリー管理
                </a>
            </nav>
        </div>
        <div class="dashboard_link">
            <a href="{{ route('admin.reports.index') }}" class="btn btn_primary">
                通報一覧を確認する
            </a>
        </div>

    </div>
</div>
@endsection
