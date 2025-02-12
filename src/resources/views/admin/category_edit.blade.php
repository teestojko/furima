@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/category_edit.css') }}">
@endsection

@section('content')
<div class="category_edit">
    <div class="category_edit_inner">
        <h1 class="category_edit_title">
            カテゴリー編集
        </h1>
        <div class="category_edit_form">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text" name="name" id="name" value="{{ $category->name }}">
                <button type="submit" class="category_edit_btn">更新</button>
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
