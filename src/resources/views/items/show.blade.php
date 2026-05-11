@extends('layouts.base')

@section('tab-title')
    {{ $item->item_name }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')
    <div class="item-detail">
        <div class="item-detail__image-col">
            <div class="item-detail__image">
                @if ($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->item_name }}">
                @else
                    <div class="item-detail__image-placeholder">商品画像</div>
                @endif
            </div>
        </div>

        <div class="item-detail__info-col">
            <h1 class="item-detail__title">{{ $item->item_name }}</h1>
            @if ($item->brand_name)
                <p class="item-detail__brand">{{ $item->brand_name }}</p>
            @endif
            <p class="item-detail__price">¥{{ number_format($item->price) }}<span class="item-detail__tax">（税込）</span></p>

            <div class="item-detail__actions">
                @auth
                    <form action="/items/{{ $item->id }}/likes" method="POST" class="like-form">
                        @csrf
                        <button type="submit" class="like-btn {{ $isLiked ? 'like-btn--active' : '' }}">
                            ♥
                        </button>
                    </form>
                @else
                    <span class="like-btn">♥</span>
                @endauth
                <span class="item-detail__like-count">{{ $item->likes->count() }}</span>

                <span class="comment-icon">○</span>
                <span class="item-detail__comment-count">{{ $item->comments->count() }}</span>
            </div>

            <a href="/purchase/{{ $item->id }}" class="item-detail__buy-btn">購入手続きへ</a>

            <section class="item-detail__section">
                <h2 class="item-detail__section-title">商品説明</h2>
                <p class="item-detail__description">{{ $item->description }}</p>
            </section>

            <section class="item-detail__section">
                <h2 class="item-detail__section-title">商品の情報</h2>
                <dl class="item-detail__info-list">
                    <div class="item-detail__info-row">
                        <dt class="item-detail__info-label">カテゴリー</dt>
                        <dd class="item-detail__info-value">
                            @foreach ($item->categories as $category)
                                <span class="item-detail__category-tag">{{ $category->name }}</span>
                            @endforeach
                        </dd>
                    </div>
                    <div class="item-detail__info-row">
                        <dt class="item-detail__info-label">商品の状態</dt>
                        <dd class="item-detail__info-value">{{ $item->condition }}</dd>
                    </div>
                </dl>
            </section>

            <section class="item-detail__section">
                <h2 class="item-detail__section-title">コメント({{ $item->comments->count() }})</h2>
                @foreach ($item->comments as $comment)
                    <div class="comment">
                        <div class="comment__header">
                            <div class="comment__avatar"></div>
                            <span class="comment__username">{{ $comment->user->user_name }}</span>
                        </div>
                        <p class="comment__body">{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </section>

            <section class="item-detail__section">
                <h2 class="item-detail__section-title">商品へのコメント</h2>
                @auth
                    <form action="/items/{{ $item->id }}/comments" method="POST" class="comment-form">
                        @csrf
                        <textarea class="comment-form__textarea" name="comment" rows="5">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="comment-form__error">{{ $message }}</p>
                        @enderror
                        <button class="comment-form__btn" type="submit">コメントを送信する</button>
                    </form>
                @endauth
            </section>
        </div>
    </div>
@endsection
