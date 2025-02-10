@extends('layout.app')

@section('content')
    <h1>カテゴリー編集</h1>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $category->name }}" required>
        <button type="submit">更新</button>
    </form>
@endsection
