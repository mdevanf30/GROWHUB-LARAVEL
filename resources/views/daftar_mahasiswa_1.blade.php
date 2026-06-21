<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - GrowHub</title>
    @vite(['resources/css/daftar_mahasiswa_1.css'])
</head>
<body>

<div class="container-alert" style="padding: 0 8%; margin-top: 20px;">
    @if(session('sukses'))
        <div style="color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 12px; border-radius: 6px; font-weight: bold; margin-bottom: 15px;">
            {{ session('sukses') }}
        </div>
    @endif

    @if(session('gagal'))
        <div style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 12px; border-radius: 6px; font-weight: bold; margin-bottom: 15px;">
            {{ session('gagal') }}
        </div>
    @endif

    @if($errors->any())
        <div style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 12px; border-radius: 6px; margin-bottom: 15px;">
            <ul style="margin-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<header>
    <nav class="navbar">
        <h2 class="logo">
            <img src="{{ asset('IMAGES/LOGO_GROWHUB-removebg-preview.png') }}" alt="GrowHub Logo" class="logo-img"> 
            GrowHub
        </h2>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="#">Tentang</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Kontak</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
            <a href="{{ route('register') }}" class="btn-outline">Daftar</a>    
        </div>
    </nav>
</header>

<div class="container">
    <div class="left">
        <h2>Registration</h2>
        
        <form action="{{ route('register.post') }}" method="POST">
            @csrf 
            
            <input type="text" placeholder="Full Name" name="full_name" value="{{ old('full_name') }}" required>
            <input type="date" name="birth_date" value="{{ old('birth_date') }}" required>
            <input type="email" placeholder="Email Address" name="email" value="{{ old('email') }}" required>
            <textarea placeholder="Home Address" name="home_address" required>{{ old('home_address') }}</textarea>
            <input type="text" placeholder="Phone Number" name="phone_number" value="{{ old('phone_number') }}" required>
            <input type="password" placeholder="Password" name="password" required>
            <input type="password" placeholder="Confirm Password" name="confirm_password" required>
            
            <button type="submit" name="register">Daftar rek!</button>
        </form>
    </div>

    <div class="right">
        <h2>Welcome Mahasiswa & Freelancer!</h2>
    </div>
</div>

</body>
</html>