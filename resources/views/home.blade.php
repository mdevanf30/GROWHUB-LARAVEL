<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Kolaborasi Mahasiswa & UMKM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/home.css'])
</head>
<body>

    <header class="navbar">
        <h2 class="logo">
            <img src="{{ asset('IMAGES/LOGO_GROWHUB-removebg-preview.png') }}" alt="GrowHub Logo"> 
            GrowHub
        </h2>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="active">Home</a></li>
            <li><a href="#">Tentang</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Kontak</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
            <a href="{{ route('register') }}" class="btn-outline">Daftar</a>    
        </div>
    </header>

    <section class="hero" style="background: url('{{ asset('IMAGES/OIP (2).webp') }}') center/cover no-repeat;">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Selamat Datang di GrowHub</h1>
            <p>Platform interaktif yang mempertemukan ide kreatif mahasiswa dengan kebutuhan nyata UMKM.</p>
            <a href="{{ route('register') }}" class="btn-primary">Mulai Sekarang</a>
        </div>
    </section>

    <section class="hero-features">
        <div class="feature-card">
            <h3>Website UMKM</h3>
            <p>Pembuatan website kustom untuk memperluas jangkauan pasar bisnis Anda.</p>
        </div>
        <div class="feature-card">
            <h3>Branding & Logo</h3>
            <p>Desain logo dan identitas visual profesional untuk memperkuat brand.</p>
        </div>
        <div class="feature-card">
            <h3>Proyek Nyata</h3>
            <p>Mahasiswa mendapatkan portofolio real dari pelaku usaha secara langsung.</p>
        </div>
        <div class="feature-card">
            <h3>Kolaborasi</h3>
            <p>Tempat bertemunya solusi digital inovatif dengan pengembangan bisnis lokal.</p>
        </div>
    </section>

    <section class="herokedua">
        <div class="herokedua-images">
            <div class="circle-bg"></div>
            <img src="{{ asset('IMAGES/flat-design-of-microsite-concept-free-vector-removebg-preview.png') }}" alt="Kolaborasi Nyata">
        </div>
        
        <div class="herokedua-text">
            <h1>Kolaborasi Mahasiswa & UMKM</h1>
            <p>Membangun solusi digital bersama untuk masa depan bisnis dan pengalaman kerja nyata mahasiswa.</p>
            <p>Melalui GrowHub, mahasiswa bertindak sebagai freelancer profesional yang membantu mendigitalisasi sektor UMKM lokal secara langsung dan terarah.</p>
        </div>
    </section>

</body>
</html>