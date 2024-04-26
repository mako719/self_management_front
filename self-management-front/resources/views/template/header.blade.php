<header>
    <div class="header-area bg-white shadow">
        <a href="{{ route('top') }}" class="font-semibold text-xl text-gray-800 leading-tight header-font-color">
            {{ __("SELF MANAGEMENT") }}
        </a>
        <div class="haguruma">
            <img src="{{ asset('img/icon_haguruma.png') }}" alt="設定" width="30" height="20">
        </div>
    </div>
    <ul class="slide-menu">
        <li>
            <a href="{{ route('profile.edit') }}">{{ __('プロフィール設定') }}</a>
        </li>
        <li>{{ __('通知設定') }}</li>
        <li>{{ __('人生時計') }}</li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
            <li>
                {{ __('ログアウト') }}
            </li>
            </a>
        </form>
    </ul>
</header>
