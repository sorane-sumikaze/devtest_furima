@extends('layouts.base')

@section('tab-title')
    住所変更
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
    <div class="address-form">
        <h2 class="address-form__title">住所の変更</h2>
        <form class="address-form__form" action="/purchase/address/{{ $item->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="address-form__field">
                <label class="address-form__label" for="post_code">郵便番号</label>
                <input class="address-form__input" type="text" id="post_code" name="post_code"
                    value="{{ old('post_code', $user->post_code) }}">
                @error('post_code')
                    <p class="address-form__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="address-form__field">
                <label class="address-form__label" for="address">住所</label>
                <input class="address-form__input" type="text" id="address" name="address"
                    value="{{ old('address', $user->address) }}">
                @error('address')
                    <p class="address-form__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="address-form__field">
                <label class="address-form__label" for="building">建物名</label>
                <input class="address-form__input" type="text" id="building" name="building"
                    value="{{ old('building', $user->building) }}">
            </div>
            <button class="address-form__btn" type="submit">更新する</button>
        </form>
    </div>
@endsection