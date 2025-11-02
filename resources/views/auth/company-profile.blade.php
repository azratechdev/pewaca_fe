<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PT HEMITECH KARYA INDONESIA - Solusi Digital untuk Lingkungan Anda</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/hemitech-logo.png') }}">
    <link href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pewaca-green: #5FA782;
            --pewaca-green-dark: #4a9070;
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

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--pewaca-green) 0%, var(--pewaca-green-dark) 100%);
            color: white;
            padding: 100px 20px 80px;
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
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .logo-container img {
            width: 120px;
            height: 120px;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            background: white;
            padding: 15px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin: 30px 0 20px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.2);
        }

        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 15px;
            opacity: 0.95;
            font-weight: 300;
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 40px;
            opacity: 0.9;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-login {
            background: white;
            color: var(--pewaca-green);
            padding: 18px 45px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            margin: 5px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.3);
            color: var(--pewaca-green);
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background: white;
            color: var(--pewaca-green);
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
        }

        .stat-card {
            text-align: center;
            padding: 30px 20px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            display: block;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Features Section */
        .features-section {
            padding: 100px 20px;
            background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--pewaca-dark);
            margin-bottom: 20px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 60px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            height: 100%;
            margin-bottom: 30px;
            border: 1px solid #f0f0f0;
        }

        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 50px rgba(95, 167, 130, 0.2);
            border-color: var(--pewaca-green);
        }

        .feature-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--pewaca-green), var(--pewaca-green-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto 25px;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--pewaca-dark);
            margin-bottom: 15px;
        }

        .feature-text {
            color: #666;
            line-height: 1.7;
            font-size: 1rem;
        }

        /* Benefits Section */
        .benefits-section {
            padding: 100px 20px;
            background: white;
        }

        .benefit-item {
            display: flex;
            align-items: start;
            margin-bottom: 40px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .benefit-item:hover {
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transform: translateX(10px);
        }

        .benefit-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--pewaca-green), var(--pewaca-green-dark));
            color: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-right: 25px;
            flex-shrink: 0;
        }

        .benefit-content h3 {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--pewaca-dark);
            margin-bottom: 10px;
        }

        .benefit-content p {
            color: #666;
            line-height: 1.7;
            margin: 0;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--pewaca-green) 0%, var(--pewaca-green-dark) 100%);
            color: white;
            padding: 80px 20px;
            text-align: center;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        /* How it Works */
        .how-section {
            padding: 100px 20px;
            background: #f8f9fa;
        }

        .step-card {
            text-align: center;
            padding: 30px;
            position: relative;
        }

        .step-number {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--pewaca-green), var(--pewaca-green-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            margin: 0 auto 25px;
            box-shadow: 0 5px 20px rgba(95, 167, 130, 0.3);
        }

        .step-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--pewaca-dark);
            margin-bottom: 15px;
        }

        .step-text {
            color: #666;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background: var(--pewaca-dark);
            color: white;
            padding: 50px 20px 30px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-logo {
            width: 80px;
            margin-bottom: 20px;
        }

        .footer-text {
            margin-bottom: 30px;
            opacity: 0.8;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 2rem; }
            .hero-subtitle { font-size: 1.1rem; }
            .section-title { font-size: 2rem; }
            .stat-number { font-size: 2.2rem; }
            .cta-title { font-size: 1.8rem; }
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content fade-in">
            <div class="logo-container">
                <img src="{{ asset('assets/plugins/images/hemitech-logo.png') }}" alt="PT HEMITECH KARYA INDONESIA Logo">
            </div>
            <h1 class="hero-title">PT HEMITECH KARYA INDONESIA</h1>
            <p class="hero-subtitle">Solusi digital terpadu untuk warga dan pengelola lingkungan</p>
            <p class="hero-description">
                Kelola perumahan Anda dengan mudah. Transparansi iuran, komunikasi efektif, dan administrasi digital dalam satu platform.
            </p>
            <div>
                <a href="{{ route('showLoginForm') }}" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Aplikasi
                </a>
                <a href="#fitur" class="btn-login btn-outline">
                    <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number"><i class="fas fa-users"></i></span>
                        <div class="stat-label">Untuk Semua Warga</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number"><i class="fas fa-shield-alt"></i></span>
                        <div class="stat-label">100% Aman</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number"><i class="fas fa-mobile-alt"></i></span>
                        <div class="stat-label">Mobile Friendly</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number"><i class="fas fa-clock"></i></span>
                        <div class="stat-label">Akses 24/7</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="fitur">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Semua yang Anda butuhkan untuk mengelola lingkungan dengan lebih baik</p>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3 class="feature-title">Transparansi Iuran</h3>
                        <p class="feature-text">Pantau tagihan dan riwayat pembayaran iuran bulanan secara real-time. Tidak ada lagi kebingungan atau miskomunikasi soal keuangan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="feature-title">Komunitas Digital</h3>
                        <p class="feature-text">Social media internal untuk berinteraksi dengan tetangga, berbagi informasi, foto, dan pengumuman penting.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Laporan Real-time</h3>
                        <p class="feature-text">Akses laporan keuangan, statistik pembayaran, dan data administrasi kapan saja dengan visualisasi yang mudah dipahami.</p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h3 class="feature-title">Pembayaran Digital</h3>
                        <p class="feature-text">Bayar iuran dengan QRIS atau transfer bank. Bukti pembayaran tersimpan otomatis dan terverifikasi sistem.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3 class="feature-title">Notifikasi Otomatis</h3>
                        <p class="feature-text">Terima pengingat tagihan, pengumuman penting, dan update komunitas langsung ke perangkat Anda.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3 class="feature-title">Manajemen Terpusat</h3>
                        <p class="feature-text">Pengurus dapat mengelola data penghuni, mencatat pembayaran, dan menyampaikan informasi dengan mudah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="how-section">
        <div class="container">
            <h2 class="section-title">Cara Kerja</h2>
            <p class="section-subtitle">Mulai dalam 3 langkah sederhana</p>
            
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h3 class="step-title">Daftar & Verifikasi</h3>
                        <p class="step-text">Hubungi pengurus untuk mendapatkan akun. Verifikasi data Anda dan akun siap digunakan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h3 class="step-title">Lengkapi Profil</h3>
                        <p class="step-text">Isi data diri dan keluarga Anda. Semakin lengkap profil, semakin mudah komunikasi dengan tetangga.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h3 class="step-title">Nikmati Layanan</h3>
                        <p class="step-text">Mulai bayar iuran, berinteraksi dengan warga, dan akses semua fitur PT HEMITECH dengan mudah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title">Manfaat untuk Anda</h2>
            <p class="section-subtitle">Mengapa ribuan warga dan pengurus memilih PT HEMITECH KARYA INDONESIA</p>
            
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Untuk Warga</h3>
                            <p>Lihat tagihan kapan saja, bayar dengan mudah, dan tetap terhubung dengan komunitas. Semua informasi penting ada di genggaman Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Untuk Pengurus</h3>
                            <p>Kelola iuran, catat pembayaran, dan komunikasikan informasi penting dengan efisien. Hemat waktu administrasi hingga 70%.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Ramah Lingkungan</h3>
                            <p>Kurangi penggunaan kertas untuk nota, kwitansi, dan pengumuman. Semua tercatat digital dan mudah diakses.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Skalabel untuk Semua</h3>
                            <p>Cocok untuk perumahan kecil maupun kompleks besar. Sistem kami dapat disesuaikan dengan kebutuhan Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Siap Memulai?</h2>
            <p class="cta-text">Bergabunglah dengan komunitas yang lebih transparan, rapi, dan terhubung</p>
            <a href="{{ route('showLoginForm') }}" class="btn-login" style="margin-top: 10px;">
                <i class="fas fa-rocket me-2"></i>Mulai Sekarang - GRATIS
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('assets/plugins/images/hemitech-logo.png') }}" alt="PT HEMITECH KARYA INDONESIA" class="footer-logo">
                        <p class="footer-text">
                            PT HEMITECH KARYA INDONESIA adalah solusi digital terpadu untuk warga dan pengelola lingkungan. 
                            Kami membantu menciptakan komunitas yang lebih transparan, rapi, dan terhubung.
                        </p>
                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-3">Tautan Cepat</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#fitur" style="color: white; text-decoration: none; opacity: 0.8;">Fitur</a></li>
                            <li class="mb-2"><a href="{{ route('showLoginForm') }}" style="color: white; text-decoration: none; opacity: 0.8;">Login</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-3">Hubungi Kami</h5>
                        <p style="opacity: 0.8;">
                            <i class="fas fa-envelope me-2"></i>info@hemitech.co.id<br>
                            <i class="fas fa-globe me-2"></i>www.hemitech.co.id
                        </p>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p class="mb-0">&copy; {{ date('Y') }} PT HEMITECH KARYA INDONESIA. Solusi digital untuk lingkungan yang lebih baik.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/plugins/components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Fade in on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card, .benefit-item, .step-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>
