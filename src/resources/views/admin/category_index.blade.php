@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/category_index.css') }}">
@endsection

@section('content')
    <div class="category_index">
        <div class="category_index_inner">
            <h1 class="category_index_title">
                カテゴリー一覧
            </h1>
            <a href="{{ route('admin.categories.create') }}" class="category_create_link">
                カテゴリー追加
            </a>
            <ul class="category_list">
                @foreach($categories as $category)
                    <div class="category_list_inner">
                        <li class="category_list_content">
                            <div class="list_title">
                                {{ $category->name }}
                            </div>
                            <div class="category_edit_link">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="category_edit_link_btn">
                                    編集
                                </a>
                            </div>
                            <div class="category_form_content">
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="category_form">
                                    @csrf
                                    @method('DELETE')
                                    <div class="delete_btn_content">
                                        <button class="delete_btn" type="submit">
                                            削除
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </div>
                @endforeach
            </ul>
            <div class="pagination_container">
                {{ $categories->links('vendor.pagination.bootstrap-4') }}
            </div>

        </div>
        @if(session('success'))
            <div class="alert alert_success">
                <p class="success_message">{{ session('success') }}</p>
            </div>
        @endif
    </div>
@endsection
