@extends('layout.app')

@section('content')
    <h1>カテゴリー追加</h1>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="カテゴリー名" required>
        <button type="submit">追加</button>
    </form>
@endsection
