@extends('layouts.auth')

@section('tab-title')
    ログイン
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth-form">
        <h2 class="auth-form__title">ログイン</h2>
        <form class="auth-form__form" action="/login" method="POST">
            @csrf
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
            <button class="auth-form__btn" type="submit">ログインする</button>
        </form>
        <p class="auth-form__link-text">
            <a class="auth-form__link" href="/register">会員登録はこちら</a>
        </p>
    </div>
@endsection
