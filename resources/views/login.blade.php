<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    @vite(['resources/css/login.css'])
</head>
<body>
    <header>
        <nav class="navbar">
            <h2 class="logo"><img src="{{ asset('IMAGES/LOGO_GROWHUB-removebg-preview.png') }}" alt="GrowHub Logo" class="logo-img"> GrowHub</h2>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="###">Tentang</a></li>
                <li><a href="###">Blog</a></li>
                <li><a href="###">Kontak</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
                <a href="{{ route('register') }}" class="btn-outline">Daftar</a>
            </div>
        </nav>
    </header>

    <div class="container">

        <div class="left">
            <h2>Login</h2>

            @if($errors->has('login_error'))
                <div style="color: #e3342f; background-color: #fce8e6; padding: 10px; rounded: 8px; margin-bottom: 15px; font-size: 14px;">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf 

                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required>
                
                <input type="password" placeholder="Password" name="password" required>
                
                <button type="submit">Login</button>
            </form>

            <p style="margin-top:15px; font-size:14px;">
                Don't have an account?
                <a href="{{ route('register') }}">Register</a>
            </p>
        </div>

        <div class="right">
            <h2>Hello, Friend!</h2>
        </div>

    </div>

</body>
</html>