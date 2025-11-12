<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="manifest" href="{{ url('manifest.json') }}">
   
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
    <title>Registrasi - Pewaca</title>
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Animation CSS -->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- Color CSS -->
    <link href="{{ asset('assets/css/colors/default.css') }}" id="theme" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .login-register {
            background: url(../assets/plugins/images/login-register.jpg) center center/cover no-repeat!important;
            height: 100%; 
            position: fixed;
        }
        .register-box {
            background: #fff;
            width: 500px;
            margin: 3% auto 3%;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .register-box .white-box {
            padding: 30px;
        }
        .register-box .footer {
            width: 100%;
            left: 0;
            right: 0;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            height: 45px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 5px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .form-label .required {
            color: #e53e3e;
        }
        .input-group-text {
            background-color: #f7fafc;
            border: 1px solid #ddd;
            border-right: none;
        }
        .input-group .form-control {
            border-left: none;
        }
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-header h3 {
            color: #2d3748;
            font-weight: 800;
            margin-bottom: 10px;
        }
        .register-header p {
            color: #718096;
            font-size: 14px;
        }
        .back-to-login {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        .back-to-login a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }
        .back-to-login a:hover {
            text-decoration: underline;
        }
        .alert {
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="mini-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    
    <section id="wrapper" class="login-register">
        <div class="register-box">
            <div class="white-box">
                <div class="register-header">
                    <h3><i class="fas fa-user-plus"></i> Registrasi Akun</h3>
                    <p>Daftar sebagai Warga atau Pengurus</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Terdapat Kesalahan!</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" id="registerForm">
                    @csrf
                    
                    <!-- Nama Lengkap -->
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-user"></i> Nama Lengkap <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('full_name') is-invalid @enderror" 
                               name="full_name" 
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('full_name') }}"
                               required>
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nomor HP -->
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-phone"></i> Nomor HP <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('phone_no') is-invalid @enderror" 
                               name="phone_no" 
                               placeholder="Contoh: 081234567890"
                               value="{{ old('phone_no') }}"
                               pattern="\d{8,13}"
                               required>
                        @error('phone_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">8-13 digit angka</small>
                    </div>

                    <!-- Residence -->
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-building"></i> Residence <span class="required">*</span>
                        </label>
                        <select class="form-control @error('residence_id') is-invalid @enderror" 
                                name="residence_id" 
                                required>
                            <option value="">-- Pilih Residence --</option>
                            @forelse($residences as $residence)
                                <option value="{{ $residence['id'] }}" {{ old('residence_id') == $residence['id'] ? 'selected' : '' }}>
                                    {{ $residence['name'] }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada data residence</option>
                            @endforelse
                        </select>
                        @error('residence_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Blok Rumah -->
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-home"></i> Blok Rumah <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('blok_rumah') is-invalid @enderror" 
                               name="blok_rumah" 
                               placeholder="Contoh: A-12"
                               value="{{ old('blok_rumah') }}"
                               required>
                        @error('blok_rumah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i> Email <span class="required">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               name="email" 
                               placeholder="Contoh: user@example.com"
                               value="{{ old('email') }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Password <span class="required">*</span>
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               placeholder="Minimal 6 karakter"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group mb-4">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Konfirmasi Password <span class="required">*</span>
                        </label>
                        <input type="password" 
                               class="form-control" 
                               name="password_confirmation" 
                               placeholder="Ulangi password"
                               required>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-center">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light btn-register" 
                                type="submit">
                            <i class="fas fa-user-plus"></i> Daftar Sekarang
                        </button>
                    </div>
                </form>

                <div class="back-to-login">
                    <p class="mb-0">
                        Sudah punya akun? <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
   
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap JavaScript -->
    <script src="{{ asset('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Slimscroll JavaScript -->
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <!-- Wave Effects JavaScript -->
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <!-- Custom JavaScript -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    
    <script>
        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const phoneNo = document.querySelector('input[name="phone_no"]').value;
            const phonePattern = /^\d{8,13}$/;
            
            if (!phonePattern.test(phoneNo)) {
                e.preventDefault();
                alert('Nomor HP harus terdiri dari 8-13 digit angka!');
                return false;
            }
        });
    </script>
</body>
</html>
