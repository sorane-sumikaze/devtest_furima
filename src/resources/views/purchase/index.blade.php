@extends('layouts.base')

@section('tab-title')
    購入手続き
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase">
        <div class="purchase__left">
            <div class="purchase__item">
                <div class="purchase__item-image">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->item_name }}">
                    @endif
                </div>
                <div class="purchase__item-info">
                    <p class="purchase__item-name">{{ $item->item_name }}</p>
                    <p class="purchase__item-price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <div class="purchase__payment">
                <h3 class="purchase__section-title">支払い方法</h3>
                <form id="purchase-form" action="/purchase/{{ $item->id }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_code" value="{{ $user->post_code }}">
                    <input type="hidden" name="address" value="{{ $user->address }}">
                    <select class="purchase__payment-select" name="payment_method">
                        <option value="">選択してください</option>
                        <option value="1" {{ old('payment_method') == 1 ? 'selected' : '' }}>クレジットカード</option>
                        <option value="2" {{ old('payment_method') == 2 ? 'selected' : '' }}>コンビニ払い</option>
                    </select>
                    @error('payment_method')
                        <p class="purchase__error">{{ $message }}</p>
                    @enderror
                </form>
            </div>

            <div class="purchase__address">
                <div class="purchase__address-header">
                    <h3 class="purchase__section-title">配送先</h3>
                    <a class="purchase__address-change" href="/purchase/address/{{ $item->id }}">変更する</a>
                </div>
                <p>〒{{ $user->post_code }}</p>
                <p>{{ $user->address }}</p>
                @if ($user->building)
                    <p>{{ $user->building }}</p>
                @endif
            </div>
        </div>

        <div class="purchase__right">
            <div class="purchase__summary">
                <div class="purchase__summary-row">
                    <span>商品代金</span>
                    <span>¥{{ number_format($item->price) }}</span>
                </div>
                <div class="purchase__summary-row">
                    <span>支払い方法</span>
                    <span id="selected-payment">—</span>
                </div>
            </div>
            <button class="purchase__btn" form="purchase-form" type="submit">購入する</button>
        </div>
    </div>

    <script>
        const labels = { '1': 'クレジットカード', '2': 'コンビニ払い' };
        document.querySelector('.purchase__payment-select').addEventListener('change', function () {
            document.getElementById('selected-payment').textContent = labels[this.value] ?? '—';
        });
    </script>
@endsection
