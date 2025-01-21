@extends('layout.app')

@section('content')
    <div class="container">
        <h1>通報フォーム</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reports.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="reported_product_id" class="form-label">通報する商品ID (任意)</label>
                <input type="text" name="reported_product_id" id="reported_product_id" class="form-control">
            </div>

            <div class="mb-3">
                <label for="reported_user_id" class="form-label">通報するユーザーID (任意)</label>
                <input type="text" name="reported_user_id" id="reported_user_id" class="form-control">
            </div>

            <div class="mb-3">
                <label for="reason" class="form-label">通報理由</label>
                <textarea name="reason" id="reason" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">通報する</button>
        </form>
    </div>
@endsection
