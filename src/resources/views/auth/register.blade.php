@extends('layouts.auth')

@section('tab-title')
    会員登録
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth-form">
        <h2 class="auth-form__title">会員登録</h2>
        <form class="auth-form__form" action="/register" method="POST">
            @csrf
            <div class="auth-form__field">
                <label class="auth-form__label" for="user_name">ユーザー名</label>
                <input class="auth-form__input" type="text" id="user_name" name="user_name" value="{{ old('user_name') }}">
                @error('user_name')
                    <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="auth-form__field">
                <label class="auth-form__label" for="email">メールアドレス</label>
                <input class="auth-form__input" type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="auth-form__field">
                <label class="auth-form__label" for="password">パスワード</label>
                <input class="auth-form__input" type="password" id="password" name="password">
                @error('password')
                    <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="auth-form__field">
                <label class="auth-form__label" for="password_confirmation">確認用パスワード</label>
                <input class="auth-form__input" type="password" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                    <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>
            <button class="auth-form__btn" type="submit">登録する</button>
        </form>
        <p class="auth-form__link-text">
            <a class="auth-form__link" href="/login">ログインはこちら</a>
        </p>
    </div>
@endsection
