<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    @yield('css')
</head>
<body>
    @auth
        <div class="header">
            <div class="header__inner">
                <button id="menu-toggle" class="header__menu-btn">
                    <div class="menu-icon-wrapper">
                        <img src="{{ asset('images/ber.jpeg') }}" alt="menu" class="menu-icon">
                    </div>
                </button>
                <a href="{{ route('manager.shop.index') }}" class="title">Rese</a>
                <nav id="side-menu" class="side-menu">
                    <button id="menu-close" class="side-menu__close">
                        <span class="close-icon">&times;</span>
                    </button>
                    <ul>
                        <li><a href="{{ route('manager.shop.index') }}">List</a></li>
                        <li><a href="{{ route('manager.create') }}">Create</a></li>
                        <li>
                            <form action="{{ route('manager.logout') }}" method="post">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    @endauth
    <main>
        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const menuClose = document.getElementById('menu-close');
            const sideMenu = document.getElementById('side-menu');

            menuToggle.addEventListener('click', () => {
                sideMenu.classList.add('open');
            });

            menuClose.addEventListener('click', () => {
                sideMenu.classList.remove('open');
            });

            document.addEventListener('click', (e) => {
                if (!sideMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                    sideMenu.classList.remove('open');
                }
            });
        });
    </script>
</body>
</html>