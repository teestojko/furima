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
                    <li>
                        @if ($notification->type === 'message')
                            <a href="{{ route('messages.show', ['userId' => $notification->data['sender_id']]) }}">
                                {{ $notification->data['message'] }}
                            </a>
                        @elseif ($notification->type === 'transaction')
                            <a href="{{ route('orders.show', ['orderId' => $notification->data['order_id']]) }}">
                                {{ $notification->data['message'] }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="messages">
        <h2>メッセージ履歴</h2>
        @foreach ($messages as $message)
            <div class="message">
                <p><strong>{{ $message->sender->name }}</strong> → <strong>{{ $message->receiver->name }}</strong></p>
                <p>{{ $message->message }}</p>
                <small>{{ $message->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>
@endsection
