<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FURIMA</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/category_create.css') }}">
</head>
<body>
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
</body>
</html>

