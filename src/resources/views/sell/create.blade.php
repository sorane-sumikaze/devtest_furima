@extends('layouts.base')

@section('tab-title')
    商品の出品
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <div class="sell-form">
        <h2 class="sell-form__title">商品の出品</h2>
        <form class="sell-form__form" action="/sell" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="sell-form__section">
                <h3 class="sell-form__section-title">商品画像</h3>
                <div class="sell-form__image-upload">
                    <img id="sell-preview-img" class="sell-form__preview-img" style="display:none;" alt="プレビュー">
                    <label class="sell-form__image-label" for="image">
                        <span>画像を選択する</span>
                        <input class="sell-form__image-input" type="file" id="image" name="image" accept="image/*">
                    </label>
                    <span id="sell-preview-name" class="sell-form__preview-name" style="display:none;"></span>
                    @error('image')
                        <p class="sell-form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="sell-form__section">
                <h3 class="sell-form__section-title">商品の詳細</h3>

                <div class="sell-form__field">
                    <label class="sell-form__label">カテゴリー</label>
                    <div class="sell-form__categories">
                        @foreach ($categories as $category)
                            <label class="sell-form__category-label">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                    {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="sell-form__field">
                    <label class="sell-form__label" for="condition">商品の状態</label>
                    <select class="sell-form__select" id="condition" name="condition">
                        <option value="">選択してください</option>
                        <option value="1" {{ old('condition') == 1 ? 'selected' : '' }}>良好</option>
                        <option value="2" {{ old('condition') == 2 ? 'selected' : '' }}>目立った傷や汚れなし</option>
                        <option value="3" {{ old('condition') == 3 ? 'selected' : '' }}>やや傷や汚れあり</option>
                        <option value="4" {{ old('condition') == 4 ? 'selected' : '' }}>状態が悪い</option>
                    </select>
                    @error('condition')
                        <p class="sell-form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="sell-form__section">
                <h3 class="sell-form__section-title">商品名と説明</h3>

                <div class="sell-form__field">
                    <label class="sell-form__label" for="item_name">商品名</label>
                    <input class="sell-form__input" type="text" id="item_name" name="item_name"
                           value="{{ old('item_name') }}">
                    @error('item_name')
                        <p class="sell-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sell-form__field">
                    <label class="sell-form__label" for="brand_name">ブランド名</label>
                    <input class="sell-form__input" type="text" id="brand_name" name="brand_name"
                           value="{{ old('brand_name') }}">
                </div>

                <div class="sell-form__field">
                    <label class="sell-form__label" for="description">商品の説明</label>
                    <textarea class="sell-form__textarea" id="description" name="description"
                              rows="5">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="sell-form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="sell-form__section">
                <h3 class="sell-form__section-title">販売価格</h3>
                <div class="sell-form__field">
                    <label class="sell-form__label" for="price">販売価格（円）</label>
                    <input class="sell-form__input" type="number" id="price" name="price"
                           value="{{ old('price') }}" min="0">
                    @error('price')
                        <p class="sell-form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button class="sell-form__btn" type="submit">出品する</button>
        </form>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById('sell-preview-img');
                img.src = e.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(file);
            document.getElementById('sell-preview-name').textContent = file.name;
            document.getElementById('sell-preview-name').style.display = 'block';
        });
    </script>
@endsection
