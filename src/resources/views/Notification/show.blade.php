@extends('Layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/Notification/show.css') }}">
@endsection

@section('content')
    <h1>メッセージ一覧</h1>

    <div class="notifications">
        <div class="notification_show_back_button">
            <a class="notification_show_back_button_link" href="{{ route('profile-show', Auth::user()->id)}}">
                戻る
            </a>
        </div>
        <h2>通知</h2>
        @if ($notifications->isEmpty())
            <p>新しい通知はありません。</p>
        @else
            <ul>
                @foreach ($notifications as $notification)
                    {{-- @php
                        // JSON文字列を配列にデコード
                        $notificationData = json_decode($notification->data, true);
                    @endphp --}}

                    <li>
                        @if ($notification->type === 'message')
                            <a href="{{ route('messages-show', ['userId' => $notificationData['sender_id']]) }}">
                                {{ $notificationData['message'] }}
                            </a>
                        @elseif ($notification->type === 'transaction')
                            <a href="{{ route('orders-show', ['orderId' => $notificationData['order_id']]) }}">
                                {{ $notificationData['message'] }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
