<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
  <title>Pendaftaran Warga - Pewaca</title>
  <link rel="manifest" href="{{ url('manifest.json') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.sitekey') }}"></script>
  
<style>
/* Modern Registration Styles */
:root {
    --primary-color: #2ca25f;
    --primary-light: #99d8c9;
    --primary-lighter: #e5f5f9;
    --gradient-start: #2ca25f;
    --gradient-end: #99d8c9;
}

body {
    background: linear-gradient(135deg, var(--primary-lighter) 0%, #ffffff 100%);
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.registration-container {
    padding: 2rem 1rem;
    min-height: 100vh;
    display: flex;
    align-items: center;
}

.registration-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 10px 40px rgba(44, 162, 95, 0.1);
    overflow: hidden;
    max-width: 600px;
    width: 100%;
    margin: 0 auto;
}

.card-header-modern {
    background: linear-gradient(135deg, rgba(44, 162, 95, 0.85), rgba(153, 216, 201, 0.85))
                @if(isset($resdetail['image']) && !empty($resdetail['image']))
                , url('{{ $resdetail['image'] }}') center/cover
                @endif
    ;
    padding: 2.5rem 2rem;
    text-align: center;
    position: relative;
}

.card-header-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 1;
}

.logo-wrapper {
    position: relative;
    z-index: 1;
    margin-bottom: 1.5rem;
}

.waca-logo {
    max-width: 200px;
    height: auto;
    filter: brightness(0) invert(1);
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.header-title {
    color: white;
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 0.75rem 0;
    position: relative;
    z-index: 1;
}

.residence-info {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 1rem 1.5rem;
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    z-index: 1;
}

.residence-icon-img {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    object-fit: cover;
}

.residence-icon-img.fas {
    border-radius: 0;
    filter: brightness(0) invert(1);
}

.residence-name {
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.card-body-modern {
    padding: 2.5rem 2rem;
}

.subtitle-text {
    color: #666;
    font-size: 0.95rem;
    margin-bottom: 2rem;
    text-align: center;
}

.subtitle-icon {
    color: var(--primary-color);
    margin-right: 0.5rem;
}

/* Form Sections */
.form-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--primary-color);
    margin: 0 0 1.25rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--primary-lighter);
}

.section-title i {
    font-size: 1.1rem;
    color: var(--primary-light);
}

/* Form Groups */
.form-group-modern {
    margin-bottom: 1.25rem;
}

.form-label-modern {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label-modern i {
    font-size: 0.9rem;
    color: var(--primary-light);
}

.form-control-modern,
.form-select-modern {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--primary-lighter);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-control-modern:focus,
.form-select-modern:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(44, 162, 95, 0.1);
    outline: none;
}

.form-control-modern.is-invalid,
.form-select-modern.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: none;
}

.form-control-modern.is-invalid ~ .invalid-feedback,
.form-select-modern.is-invalid ~ .invalid-feedback {
    display: block;
}

.form-hint {
    font-size: 0.8rem;
    color: #666;
    margin-top: 0.25rem;
}

/* Password Toggle */
.password-wrapper {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #999;
    transition: color 0.3s ease;
    font-size: 1.1rem;
}

.toggle-password:hover {
    color: var(--primary-color);
}

/* File Upload */
.file-upload-wrapper {
    position: relative;
    overflow: hidden;
}

.file-upload-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem;
    border: 2px dashed var(--primary-lighter);
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary-lighter) 0%, #f8fdff 100%);
    cursor: pointer;
    transition: all 0.3s ease;
}

.file-upload-label:hover {
    border-color: var(--primary-light);
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-lighter) 100%);
}

.file-upload-label i {
    font-size: 1.5rem;
    color: var(--primary-color);
}

.file-upload-text {
    color: var(--primary-color);
    font-weight: 600;
}

input[type="file"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

#imagePreviewContainer {
    margin-top: 1rem;
    padding: 1rem;
    background: var(--primary-lighter);
    border-radius: 12px;
}

#imagePreview {
    max-width: 100%;
    border-radius: 8px;
}

#removeImageButton {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

#removeImageButton:hover {
    background: #c82333;
    transform: scale(1.1);
}

/* Checkbox */
.checkbox-wrapper {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.checkbox-modern {
    width: 20px;
    height: 20px;
    min-width: 20px;
    border: 2px solid var(--primary-lighter);
    border-radius: 6px;
    cursor: pointer;
    margin-top: 2px;
    accent-color: var(--primary-color);
}

.checkbox-label {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.5;
}

.checkbox-label a {
    color: var(--primary-color);
    font-weight: 600;
    text-decoration: none;
}

.checkbox-label a:hover {
    text-decoration: underline;
}

/* Submit Button */
.btn-submit-modern {
    width: 100%;
    padding: 1rem 2rem;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    color: white;
    border: none;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(44, 162, 95, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.btn-submit-modern:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(44, 162, 95, 0.4);
}

.btn-submit-modern:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-submit-modern i {
    font-size: 1.2rem;
}

/* Footer Links */
.footer-links {
    text-align: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid var(--primary-lighter);
}

.footer-link {
    color: #666;
    font-size: 0.95rem;
}

.footer-link a {
    color: var(--primary-color);
    font-weight: 600;
    text-decoration: none;
}

.footer-link a:hover {
    text-decoration: underline;
}

/* Select2 Modern Styling */
.select2-container--default .select2-selection--single {
    height: auto !important;
    padding: 0.875rem 1rem !important;
    border: 2px solid var(--primary-lighter) !important;
    border-radius: 12px !important;
    transition: all 0.3s ease;
}

.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 4px rgba(44, 162, 95, 0.1) !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    padding: 0 !important;
    line-height: 1.5 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100% !important;
    right: 1rem !important;
}

/* SweetAlert Custom */
.swal2-popup.rounded-alert {
    border-radius: 16px !important;
    padding: 2rem !important;
}

.swal2-popup .swal2-title {
    color: var(--primary-color) !important;
    font-size: 1.5rem !important;
    font-weight: 700 !important;
}

.swal2-popup .swal2-content {
    font-size: 1rem !important;
    color: #666 !important;
}

.swal-confirm-btn {
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end)) !important;
    border-radius: 8px !important;
    padding: 0.75rem 2rem !important;
    font-weight: 600 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .registration-container {
        padding: 1rem 0.5rem;
    }
    
    .card-header-modern {
        padding: 2rem 1.5rem;
    }
    
    .card-body-modern {
        padding: 2rem 1.5rem;
    }
    
    .header-title {
        font-size: 1.5rem;
    }
    
    .waca-logo {
        max-width: 160px;
    }
    
    .residence-info-card {
        padding: 1rem 1.25rem;
    }
    
    .residence-icon {
        width: 36px;
        height: 36px;
    }
    
    .form-label {
        font-size: 0.85rem;
    }
    
    .form-control,
    .form-select {
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }
}

@media (max-width: 480px) {
    .registration-container {
        padding: 0.75rem 0.25rem;
    }
    
    .card-header-modern {
        padding: 1.5rem 1rem;
    }
    
    .card-body-modern {
        padding: 1.5rem 1rem;
    }
    
    .header-title {
        font-size: 1.25rem;
    }
    
    .waca-logo {
        max-width: 140px;
    }
    
    .residence-info-card {
        padding: 0.875rem 1rem;
    }
    
    .residence-icon {
        width: 32px;
        height: 32px;
    }
    
    .residence-name {
        font-size: 1rem;
    }
    
    .section-header {
        padding: 0.875rem 1rem;
    }
    
    .section-title {
        font-size: 1rem;
    }
    
    .section-title i {
        font-size: 1rem;
    }
    
    .form-control,
    .form-select {
        padding: 0.625rem 0.875rem;
        font-size: 0.9rem;
    }
    
    .password-toggle {
        width: 36px;
        height: 36px;
    }
    
    .btn-register {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
    }
}
</style>

</head>
<body>
    <div class="registration-container">
        <div class="registration-card">
            <!-- Header -->
            <div class="card-header-modern">
                <div class="logo-wrapper">
                    <img src="{{ asset('assets/plugins/images/mainlogo.png') }}" class="waca-logo" alt="Waca Logo">
                </div>
                <h1 class="header-title">Pendaftaran Warga</h1>
                <div class="residence-info">
                    @if(!empty($resdetail['image']))
                        <img src="{{ $resdetail['image'] }}" class="residence-icon-img" alt="{{ $resdetail['name'] }}">
                    @else
                        <i class="fas fa-home residence-icon-img"></i>
                    @endif
                    <span class="residence-name">{{ $resdetail['name'] }}</span>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body-modern">
                <p class="subtitle-text">
                    <i class="fas fa-info-circle subtitle-icon"></i>
                    Mohon lengkapi data untuk persyaratan menjadi warga
                </p>

                <form id="registrasi" method="post" action="{{ route('postRegister') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" id="code" name="code" value="">
                    
                    <!-- Section 1: Unit & Identitas -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-home"></i>
                            Unit & Identitas
                        </h3>
                        
                        <div class="form-group-modern">
                            <label for="unitSelect" class="form-label-modern">
                                <i class="fas fa-door-open"></i>
                                No Unit
                            </label>
                            <select class="form-select-modern @error('unit_id') is-invalid @enderror" id="unitSelect" name="unit_id" required>
                                <option value="">Pilih Unit</option>
                                @foreach ($units as $unit)
                                <option value="{{ $unit['unit_id'] }}" {{ old('unit_id') == $unit['unit_id'] ? 'selected' : '' }}>{{ $unit['unit_name'] }}</option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group-modern">
                            <label for="full_name" class="form-label-modern">
                                <i class="fas fa-user"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" pattern="[A-Za-z\s]+" class="form-control-modern @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group-modern">
                            <label for="phone_no" class="form-label-modern">
                                <i class="fas fa-phone"></i>
                                Nomor Telepon
                            </label>
                            <input type="text" pattern="\d{8,13}" minlength="8" maxlength="13" inputmode="numeric" class="form-control-modern @error('phone_no') is-invalid @enderror" value="{{ old('phone_no') }}" id="phone_no" name="phone_no" required>
                            <small class="form-hint">Minimal 8 digit, maksimal 13 digit</small>
                            <small class="text-danger d-none" id="phone_no-error">Nomor Telepon minimal 8 digit dan maksimal 13 digit</small>
                            @error('phone_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group-modern">
                            <label for="family_as" class="form-label-modern">
                                <i class="fas fa-users"></i>
                                Status Keluarga
                            </label>
                            <select class="form-select-modern @error('family_as') is-invalid @enderror" id="family_as" name="family_as" required>
                                <option value="">Pilih Status</option>
                                @foreach ($families as $family)
                                <option value="{{ $family['id'] }}" {{ old('family_as') == $family['id'] ? 'selected' : '' }}>{{ $family['name'] }}</option>
                                @endforeach
                            </select>
                            @error('family_as')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 2: Akun & Keamanan -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-lock"></i>
                            Akun & Keamanan
                        </h3>
                        
                        <div class="form-group-modern">
                            <label for="email" class="form-label-modern">
                                <i class="fas fa-envelope"></i>
                                Alamat Email
                            </label>
                            <input type="email" class="form-control-modern @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" name="email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group-modern">
                            <label for="password" class="form-label-modern">
                                <i class="fas fa-key"></i>
                                Kata Sandi
                            </label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control-modern @error('password') is-invalid @enderror" value="{{ old('password') }}" id="password" name="password" required>
                                <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Recaptcha -->
                    <div class="g-recaptcha"
                        data-sitekey="{{ config('recaptcha.sitekey') }}"
                        data-callback="onSubmit"
                        data-size="invisible">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn" class="btn-submit-modern">
                        <i class="fas fa-user-plus"></i>
                        Daftar Sebagai Warga
                    </button>

                    <!-- Footer Links -->
                    <div class="footer-links">
                        <p class="footer-link">
                            Sudah punya akun? <a href="{{ route('showLoginForm') }}">Masuk di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
   
  <!-- Tambahkan jQuery -->
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Select2 for Enhanced Dropdowns -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
  <!-- Browser Image Compression Library -->
  <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
   
     // Password toggle functionality
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
});
</script>
    <script>
        $('#registrasi').on('submit', function(e) {
            e.preventDefault(); // Hentikan submit default

            const form = this;
            Swal.fire({
                title: 'Memproses Data',
                text: 'Harap tunggu sebentar...',
                allowOutsideClick: false, 
                allowEscapeKey: false,  
                didOpen: () => {
                    Swal.showLoading(); 
                }
             });
            // const btn = $('#submitBtn');
            // btn.addClass('loading');
            // btn.html('<span>Memproses Data...</span>');

            // Jalankan reCAPTCHA invisible
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('recaptcha.sitekey') }}', { action: 'registrasi' })
                    .then(function(token) {
                        // Tambahkan token ke form sebagai input hidden
                        let recaptchaInput = form.querySelector('input[name="g-recaptcha-response"]');
                        if (!recaptchaInput) {
                            recaptchaInput = document.createElement('input');
                            recaptchaInput.type = 'hidden';
                            recaptchaInput.name = 'g-recaptcha-response';
                            form.appendChild(recaptchaInput);
                        }
                        recaptchaInput.value = token;

                        // Kirim form
                        form.submit();
                    })
                    .catch(function(error) {
                        console.error('reCAPTCHA error:', error);
                        Swal.close();
                        btn.removeClass('loading');
                        btn.html('Login');
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Verifikasi keamanan gagal. Silakan coba lagi.'
                        });
                    });
            });
        });
   
        // $('#registrasi').on('submit', function(e) {
        //     Swal.fire({
        //         title: 'Memproses Data',
        //         text: 'Harap tunggu sebentar...',
        //         allowOutsideClick: false, 
        //         allowEscapeKey: false,  
        //         didOpen: () => {
        //             Swal.showLoading(); 
        //         }
        //     });
        // });
    </script>
  @if (session('status') == 'success')
    <script>
    
        Swal.fire({
            html: `
                <div style="text-align: center; font-size: 14px;">
                    <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0">
                        {{ session("message") }}
                    </h2>
                    <p>Silahkan cek email Anda untuk melanjutkan verifikasi.</p>
                    <img
                        src="{{ asset('assets/plugins/images/verified-send.jpeg') }}"
                        alt="Verified"
                        style="width: 180px; height: 175px; margin: 10px 0" />
                </div>
            `,
            
            showConfirmButton: true,
            confirmButtonText: 'Mengerti',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'rounded-alert', // Class untuk border-radius
                confirmButton: 'swal-confirm-btn'
            }
        }).then(() => {
            window.location.href = '{{ route('showLoginForm') }}';
        });
    </script>
@elseif (session('status') == 'error')
    <script>
     
      let uuid = $('input#code').length ? $('input#code').val() : '';

        Swal.fire({
            html: `
                <div style="text-align: center; font-size: 14px;">
                    <i class="swal2-icon swal2-error" style="font-size: 50px; margin-bottom: 10px;"></i>
                    <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                       {{ session("message") }}
                    </h2>
                    <p>Gagal Verifikasi, Pastikan anda memiliki akses internet.</p>
                </div>
            `,
            showConfirmButton: true,
            icon: 'error',
            confirmButtonText: 'Verifikasi Ulang',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'rounded-alert',
                confirmButton: 'swal-confirm-btn'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                if (uuid) {
                    window.location.href = '{{ route('showRegister', ['uuid' => '']) }}' + uuid;
                }
            }
        });
    </script>

@endif
    <script>
     
        const form = document.getElementById('registrasi');
        const submitBtn = document.getElementById('submitBtn');
        
      
        function checkFormValidity() {
           
            const isValid = [...form.querySelectorAll('input[required], select[required]')].every(input => {
            
                if (input.type === 'file') {
                    return input.files.length > 0 || input.optional; // Periksa jika input file kosong
                }
                return input.value.trim() !== '';
            });
         
            submitBtn.disabled = !isValid;
        }

        form.addEventListener('input', checkFormValidity);

        checkFormValidity();
    </script>
    <script>
        const url = window.location.href;
        const id = url.split('/').pop();
        $('input#code').val(id);

        function validateUUID(id) {
            const uuidRegex = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;
            return uuidRegex.test(id);
        }
       
        document.getElementById("registrasi").addEventListener("submit", function(event) {
            const id = document.getElementById("code").value;
            if (!validateUUID(id)) {
                event.preventDefault();
                Swal.fire({
                    html: `
                        <div style="text-align: center; font-size: 14px;">
                            <i class="swal2-icon swal2-error" style="font-size: 50px; margin-bottom: 10px;"></i>
                            <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                                Unknow Page
                            </h2>
                            <p>Tindakan tidak dikenali, pastikan anda menuju halaman yang benar.</p>
                        </div>
                    `,
                    showConfirmButton: true,
                    icon: 'error',
                    confirmButtonText: 'Mengerti',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'rounded-alert',
                        confirmButton: 'swal-confirm-btn'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (uuid) {
                            window.location.href = '{{ route('showRegister', ['uuid' => '']) }}' + uuid;
                        }
                    }
                });
            }
        });
    </script>


<script>
    document.getElementById('phone_no').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Hanya angka

    if (value.length > 13) {
        value = value.substring(0, 13); // Batasi 16 digit
    }

    e.target.value = value;

    const errorEl = document.getElementById('phone_no-error');
    const counterEl = document.getElementById('phone_no-counter');

    // Tampilkan error jika tidak kosong dan < 8
    if ((value.length > 0 && value.length < 8) || value.length > 13) {
        errorEl.classList.remove('d-none');
        e.target.classList.add('is-invalid');
    } else {
        errorEl.classList.add('d-none');
        e.target.classList.remove('is-invalid');
    }

    // Update counter jika ada
    if (counterEl) {
        counterEl.textContent = `${value.length}/8`;
    }
});
</script>
<script>
    $(document).ready(function() {
        $('#unitSelect').select2({
            placeholder: " ",
            allowClear: true,
            width: '100%',
        });
    });
</script>

</body>
</html>

