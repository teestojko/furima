@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/category_create.css') }}">
@endsection

@section('content')
<div class="category_create">
    <div class="category-create_inner">

        <h1 class="category_create_title">
            カテゴリー追加
        </h1>
        <div class="category_create_form">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <input type="text" name="name" id="name" placeholder="カテゴリー名">
                <button type="submit" class="category_create_btn">追加</button>
            </form>
        </div>
        <div class="back_btn_content">
            <a href="{{ route('admin.categories.index') }}" class="btn category_back_btn">
                カテゴリー一覧へ戻る
            </a>
        </div>
    </div>
</div>
@endsection
