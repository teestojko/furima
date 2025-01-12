@extends('Layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/Notification/show.css') }}">
@endsection

@section('content')
    <h1>通知一覧</h1>

    <div class="notifications">
        <h2>未読通知</h2>
        @if ($unreadNotifications->isEmpty())
            <p>新しい通知はありません。</p>
        @else
            <ul>
                @foreach ($unreadNotifications as $notification)
                    @php
                        $notificationData = json_decode($notification->data, true);
                    @endphp
                    <li>
                        <a href="{{ route('notifications-mark-read-and-message-detail', ['notificationId' => $notification->id]) }}">
                            {{ $notificationData['message'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <h2>既読通知</h2>
        @if ($readNotifications->isEmpty())
            <p>既読の通知はありません。</p>
        @else
            <ul>
                @foreach ($readNotifications as $notification)
                    @php
                        $notificationData = json_decode($notification->data, true);
                    @endphp
                    <li>{{ $notificationData['message'] }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
