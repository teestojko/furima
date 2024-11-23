@extends('Layout.app')

@section('content')
<h1>メッセージ詳細</h1>

<p><strong>送信者:</strong> {{ $message->sender->name }}</p>
<p><strong>受信者:</strong> {{ $message->receiver->name }}</p>
<p><strong>メッセージ内容:</strong> {{ $message->message }}</p>
<p><strong>送信日時:</strong> {{ $message->created_at }}</p>
@endsection