@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/mail/message_received.css') }}">
<link rel="stylesheet" href="{{ mix('css/sidebar.css') }}">
@endsection

@section('content')

    <div id="sidebar"></div>


    <form action="{{ route('messages-send-email', $receiverId) }}" method="POST">
        @csrf
        <div class="send_email_section">
            <div class="send_email_section">
                <div class="section_title">
                    メッセージ
                </div>
                <div class="send_email_message2">
                    <label class="message" for="message"></label>
                    <textarea name="message" id="message" rows="5"></textarea>
                </div>
            </div>
            @error('message')
                <div class="alert_danger_comment">
                    {{ $message }}
                </div>
            @enderror
            <div class="send_email_button">
                <button class="send_email_button_button" type="submit">
                    送信する
                </button>
            </div>
            @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if (session('ellor'))
                <div class="alert-success">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </form>

    <div id="app"></div>
    <script src="{{ mix('js/app.js') }}"></script>

@endsection



