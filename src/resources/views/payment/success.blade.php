@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment/success.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endsection

@section('content')
    <div class="reserve_content">
        <div class="reserve_main">
            <div class="reserve_thanks_massage">
                お支払いが完了しました
            </div>
            <a class="reserve_nav" href="{{ route('user-index') }}">
                ホーム画面へ戻る
            </a>
        </div>
    </div>
@endsection
