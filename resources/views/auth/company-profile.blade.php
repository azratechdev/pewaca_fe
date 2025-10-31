<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pewaca - Solusi Digital untuk Lingkungan Anda</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
    <link href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pewaca-green: #5FA782;
            --pewaca-dark: #2c3e50;
            --pewaca-light: #ecf0f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            overflow-x: hidden;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--pewaca-green) 0%, #4a9070 100%);
            color: white;
            padding: 80px 20px 60px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 30px;
        }

        .logo-container img {
            width: 100px;
            height: 100px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            background: white;
            padding: 10px;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .btn-login {
            background: white;
            color: var(--pewaca-green);
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            color: var(--pewaca-green);
        }

        .features-section {
            padding: 80px 20px;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--pewaca-dark);
            margin-bottom: 50px;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            margin-bottom: 30px;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--pewaca-green), #4a9070);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 25px;
        }

        .feature-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--pewaca-dark);
            margin-bottom: 15px;
        }

        .feature-text {
            color: #666;
            line-height: 1.6;
            font-size: 1rem;
        }

        .about-section {
            padding: 80px 20px;
            background: white;
        }

        .about-content {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .about-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 20px;
        }

        .highlight-box {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-left: 5px solid var(--pewaca-green);
            padding: 30px;
            border-radius: 10px;
            margin: 40px 0;
            text-align: left;
        }

        .highlight-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--pewaca-dark);
            margin-bottom: 15px;
        }

        .footer {
            background: var(--pewaca-dark);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .feature-card {
                margin-bottom: 25px;
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="logo-container">
                <img src="{{ asset('assets/plugins/images/logo.png') }}" alt="Pewaca Logo" class="pulse-animation">
            </div>
            <h1 class="hero-title">PEWACA</h1>
            <p class="hero-subtitle">Solusi digital terpadu untuk warga dan pengelola lingkungan</p>
            <a href="{{ route('showLoginForm') }}" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Aplikasi
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3 class="feature-title">Transparansi Iuran</h3>
                        <p class="feature-text">Pantau tagihan dan riwayat pembayaran iuran bulanan secara real-time, tanpa kebingungan atau miskomunikasi</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="feature-title">Social Media Internal</h3>
                        <p class="feature-text">Berinteraksi dengan tetangga, berbagi informasi, foto, dan pengumuman penting dalam satu platform</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3 class="feature-title">Pengelolaan Mudah</h3>
                        <p class="feature-text">Kelola data penghuni, catat pembayaran, dan sampaikan informasi penting dengan mudah dan terpusat</p>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3 class="feature-title">Digital Record</h3>
                        <p class="feature-text">Semua aktivitas tercatat digital, mengurangi penggunaan kertas dan mempercepat administrasi</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="feature-title">Mobile Friendly</h3>
                        <p class="feature-text">Akses dari mana saja, kapan saja melalui smartphone atau komputer dengan tampilan responsif</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Aman & Terpercaya</h3>
                        <p class="feature-text">Data Anda terlindungi dengan sistem keamanan modern dan backup otomatis</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <h2 class="section-title">Tentang Pewaca</h2>
                <p class="about-text">
                    Pewaca adalah aplikasi yang akan mempermudah pengelolaan lingkungan tempat tinggal, baik oleh pengurus maupun warga. 
                    Dengan fitur transparansi iuran bulanan, warga dapat melihat tagihan dan riwayat pembayaran secara real-time, 
                    sehingga tidak ada lagi kebingungan atau miskomunikasi soal keuangan.
                </p>
                <p class="about-text">
                    Selain itu, aplikasi ini juga menyediakan fitur social media internal yang memungkinkan warga saling berinteraksi, 
                    berbagi informasi, foto, atau pengumuman penting dalam lingkungan.
                </p>

                <div class="highlight-box">
                    <h3 class="highlight-title"><i class="fas fa-check-circle" style="color: var(--pewaca-green);"></i> Untuk Pengurus</h3>
                    <p class="about-text mb-0">
                        Pengurus dapat mengelola data penghuni, mencatat pembayaran, serta menyampaikan informasi penting dengan mudah dan terpusat. 
                        Semua aktivitas tercatat secara digital, mengurangi penggunaan kertas dan mempercepat proses administrasi.
                    </p>
                </div>

                <div class="highlight-box">
                    <h3 class="highlight-title"><i class="fas fa-home" style="color: var(--pewaca-green);"></i> Cocok untuk Semua Skala</h3>
                    <p class="about-text mb-0">
                        Aplikasi ini adalah solusi ideal bagi perumahan kecil maupun kompleks besar, untuk menciptakan komunitas yang transparan, rapi, dan terhubung.
                    </p>
                </div>

                <div class="mt-5">
                    <a href="{{ route('showLoginForm') }}" class="btn btn-lg px-5 py-3" style="background: var(--pewaca-green); color: white; border-radius: 50px; font-weight: 600;">
                        <i class="fas fa-rocket me-2"></i>Mulai Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Pewaca. Solusi digital untuk lingkungan yang lebih baik.</p>
        </div>
    </footer>

    <script src="{{ asset('assets/plugins/components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>
