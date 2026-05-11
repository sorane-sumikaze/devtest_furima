@extends('layouts.base')

@section('tab-title')
    COACHTECH フリマ
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    @php $keyword = $keyword ?? ''; @endphp
    <div class="tabs">
        <a href="{{ $keyword ? '/search?tab=recommended&keyword='.urlencode($keyword) : '/?tab=recommended' }}"
           class="tabs__item {{ $tab === 'recommended' ? 'tabs__item--active' : '' }}">
            おすすめ
        </a>
        <a href="{{ $keyword ? '/search?tab=mylist&keyword='.urlencode($keyword) : '/?tab=mylist' }}"
           class="tabs__item {{ $tab === 'mylist' ? 'tabs__item--active' : '' }}">
            マイリスト
        </a>
    </div>

    <div class="items">
        @foreach ($items as $item)
            <a href="/items/{{ $item->id }}" class="item-card">
                <div class="item-card__image">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->item_name }}">
                    @else
                        <div class="item-card__image-placeholder"></div>
                    @endif
                    @if ($item->sold)
                        <span class="item-card__sold-badge">Sold</span>
                    @endif
                </div>
                <p class="item-card__name">{{ $item->item_name }}</p>
            </a>
        @endforeach
    </div>
@endsection
