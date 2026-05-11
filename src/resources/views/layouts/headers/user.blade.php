<header class="header">
    <div class="header__inner">
        <a class="header__logo" href="/">
            <img src="{{ asset('storage/material_images/coachtech-logo-white.svg') }}" alt="COACHTECH">
        </a>
        <form class="header__search" action="/search" method="GET">
            <input class="header__search-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
        </form>
        <nav class="header__nav">
            <a class="header__nav-link" href="/logout"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                ログアウト
            </a>
            <form id="logout-form" action="/logout" method="POST" style="display:none;">
                @csrf
            </form>
            <a class="header__nav-link" href="/mypage">マイページ</a>
            <a class="header__nav-btn" href="/sell">出品</a>
        </nav>
    </div>
</header>
