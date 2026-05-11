@extends('layouts.base')

@section('tab-title')
    プロフィール設定
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="profile-form-wrap">
        <h2 class="profile-form__title">プロフィール設定</h2>

        <form class="profile-form" action="/mypage/profile" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="profile-form__avatar-wrap">
                <div class="profile-form__avatar">
                    <img id="profile-preview"
                         src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : '' }}"
                         alt="{{ $user->user_name }}"
                         @unless($user->profile_image) style="display:none;" @endunless>
                </div>
                <label class="profile-form__image-btn">
                    画像を選択する
                    <input type="file" id="profile-image-input" name="profile_image" accept="image/*" style="display:none;">
                </label>
            </div>
            @error('profile_image')
                <p class="profile-form__error">{{ $message }}</p>
            @enderror

            <div class="profile-form__field">
                <label class="profile-form__label" for="user_name">ユーザー名</label>
                <input class="profile-form__input" type="text" id="user_name" name="user_name"
                       value="{{ old('user_name', $user->user_name) }}">
                @error('user_name')
                    <p class="profile-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-form__field">
                <label class="profile-form__label" for="post_code">郵便番号</label>
                <input class="profile-form__input" type="text" id="post_code" name="post_code"
                       value="{{ old('post_code', $user->post_code) }}">
                @error('post_code')
                    <p class="profile-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-form__field">
                <label class="profile-form__label" for="address">住所</label>
                <input class="profile-form__input" type="text" id="address" name="address"
                       value="{{ old('address', $user->address) }}">
                @error('address')
                    <p class="profile-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-form__field">
                <label class="profile-form__label" for="building">建物名</label>
                <input class="profile-form__input" type="text" id="building" name="building"
                       value="{{ old('building', $user->building) }}">
                @error('building')
                    <p class="profile-form__error">{{ $message }}</p>
                @enderror
            </div>

            <button class="profile-form__btn" type="submit">更新する</button>
        </form>
    </div>

    <script>
        document.getElementById('profile-image-input').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('profile-preview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
