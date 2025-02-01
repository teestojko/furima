@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile/user_edit.css') }}">
@endsection

@section('content')
    <div class="user_edit">
        <div class="user_edit_inner">
                
            <div class="sale_profile">
                <a class="profile_link" href="{{ route('profile-show', Auth::user()->id) }}">
                    プロフィールへ戻る
                </a>
            </div>

            <div class="user_edit_title">
                プロフィール編集
            </div>
            <form class="user_edit_form" action="{{ route('user-update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (session('success'))
                    <p class="success_message">
                        {{ session('success') }}
                    </p>
                @endif
                <div class="user_edit_content">
                    <div class="content_title">
                        名前
                    </div>
                    <label for="name"></label>
                    <input type="text" id="input_id" name="name" value="{{ old('name', $user->name) }}">
                </div>
                @error('name')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
                <div class="user_edit_content">
                    <div class="content_title">
                        メールアドレス
                    </div>
                    <label for="email"></label>
                    <input type="email" id="input_id" name="email" value="{{ old('email', $user->email) }}">
                </div>
                @error('email')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
                <div class="user_edit_content">
                    <div class="content_title">
                        現在のパスワード
                    </div>
                    <label for="current_password"></label>
                    <input type="password" id="input_id" name="current_password">
                </div>
                @error('current_password')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror

                <div class="user_edit_content">
                    <div class="content_title">
                        新しいパスワード
                    </div>
                    <label for="new_password"></label>
                    <input type="password" id="input_id" name="new_password">
                </div>
                @error('new_password')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror

                <div class="user_edit_content">
                    <div class="content_title">
                        新しいパスワード（確認）
                    </div>
                    <label for="new_password_confirmation"></label>
                    <input type="password" id="input_id" name="new_password_confirmation">
                </div>
                @error('new_password_confirmation')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror

                <div class="user_edit_content">
                    <div class="content_title">
                        プロフィール画像
                    </div>
                    <label class="profile_image_label" for="profile_image" >
                        画像を選択
                    </label>
                    <input type="file" name="profile_image" id="profile_image" multiple>
                    <div id="file_name">
                        選択ファイル名
                    </div>
                </div>
                @error('profile_image')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror

                <div class="user_edit_button">
                    <button class="user_edit_button_button" type="submit">
                        更新
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('profile_image').addEventListener('change', function(){
            const fileName = this.files[0].name;
            document.getElementById('file_name').textContent = fileName;
        });
    </script>
@endsection
