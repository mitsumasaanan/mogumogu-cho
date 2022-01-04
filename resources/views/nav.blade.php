<nav class="navbar navbar-expand navbar-dark base-bg">

    <a class="navbar-brand" href="/">もぐもぐ帳 <i class="fas fa-utensils mr-1"></i></a>
    <div class="menu-btn">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </div>
    <ul class="menu">

        @guest
        <li class="nav-item menu__item">
            <a class="nav-link" href="{{ route('register') }}">ユーザー登録</a>
        </li>
        @endguest

        @guest
        <li class="nav-item menu__item">
            <a class="nav-link" href="{{ route('login') }}">ログイン</a>
        </li>
        @endguest

        @guest
        <li class="nav-item btn-success menu__item">
            <a class="nav-link" href="{{ route('login.guest') }}">ゲストログイン</a>
        </li>
        @endguest

        @auth
        @if(Auth::check())
        <li class="nav-item menu__item">{{ Auth::user()->name }}さん、こんにちは</li>
        @endif
        <li class="nav-item menu__item">
            <a class="nav-link" href="{{ route('articles.create') }}"><i class="fas fa-pen mr-1"></i>投稿する</a>
        </li>
        @endauth

        @auth
        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                <button class="dropdown-item" type="button" onclick="location.href='{{ route("users.show", ["name" => Auth::user()->name]) }}'">
                    マイページ
                </button>
                <div class="dropdown-divider"></div>
                <button form="logout-button" class="dropdown-item" type="submit">
                    ログアウト
                </button>
            </div>
        </li>
        <form id="logout-button" method="POST" action="{{ route('logout') }}">
            @csrf
        </form>
        <!-- Dropdown -->
        @endauth

    </ul>

</nav>