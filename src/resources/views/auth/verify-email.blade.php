@extends('layouts.auth')

@section('tab-title')
    メール認証
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="verify-email">
        <p class="verify-email__message">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>

        <a class="verify-email__btn" href="http://localhost:8025" target="_blank">認証はこちらから</a>

        <form action="/email/verification-notification" method="POST">
            @csrf
            <button class="verify-email__resend" type="submit">認証メールを再送する</button>
        </form>
    </div>
@endsection
