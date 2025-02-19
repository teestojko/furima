@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/report/create.css') }}">
@endsection

@section('content')

<div class="report_create">
    <div class="report_create_inner">
        <h2 class="report_create_title">
            通報フォーム
        </h2>

        <form action="{{ route('report-store') }}" method="POST">
            @csrf
            <input type="hidden" name="reported_product_id" value="{{ $reportedProduct->id }}">
            <input type="hidden" name="reported_user_id" value="{{ $reportedUser->id ?? '' }}">

            <label for="reason">通報理由：</label>
            <select name="reason" id="reason" required>
                <option value="不適切な内容">不適切な内容</option>
                <option value="詐欺の疑い">詐欺の疑い</option>
                <option value="その他">その他</option>
            </select>

            <label for="comment">詳細コメント：</label>
            <textarea name="comment" id="comment" placeholder="詳細を入力（任意）"></textarea>

            <button class="report_btn" type="submit">通報する</button>
        </form>
    </div>
</div>

@endsection



