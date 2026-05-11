@extends('layouts.base')

@section('tab-title')
    マイページ
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-profile">
        <div class="mypage-profile__avatar">
            @if ($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->user_name }}">
            @endif
        </div>
        <span class="mypage-profile__name">{{ $user->user_name }}</span>
        <a href="/mypage/profile" class="mypage-profile__edit-btn">プロフィールを編集</a>
    </div>

    <div class="mypage-tabs">
        <a href="/mypage?tab=sell"
           class="mypage-tabs__tab {{ $tab === 'sell' ? 'mypage-tabs__tab--active' : '' }}">
            出品した商品
        </a>
        <a href="/mypage?tab=buy"
           class="mypage-tabs__tab {{ $tab === 'buy' ? 'mypage-tabs__tab--active' : '' }}">
            購入した商品
        </a>
    </div>

    <div class="mypage-grid">
        @foreach ($items as $item)
            <a href="/items/{{ $item->id }}" class="mypage-grid__item">
                <div class="mypage-grid__image">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->item_name }}">
                    @else
                        <div class="mypage-grid__image-placeholder"></div>
                    @endif
                    @if ($item->sold)
                        <span class="mypage-grid__sold-badge">Sold</span>
                    @endif
                </div>
                <p class="mypage-grid__name">{{ $item->item_name }}</p>
            </a>
        @endforeach
    </div>
@endsection
