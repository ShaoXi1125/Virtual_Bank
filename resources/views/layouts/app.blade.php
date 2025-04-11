<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Virtual Bank</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @if(session()->has('online_banking_user'))
                        {{-- 用户已登录，显示用户名和登出按钮 --}}
                        <li class="nav-item">
                            <span class="nav-link">Hello, {{ session('user_name') }}</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('online_banking.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('online_banking.logout') }}" class="d-none">
                            @csrf
                        </form>
                    @else
                        {{-- 用户未登录，显示 Login 和 Register --}}
                        <li class="nav-item"><a class="nav-link" href="{{ route('online_banking.login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('online_banking.register') }}">Register</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
