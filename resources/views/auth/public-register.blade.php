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
            min-height: 100vh;
            overflow-y: auto;
            padding: 20px 0;
        }
        .register-box {
            background: #fff;
            width: 500px;
            max-width: 95%;
            margin: 0 auto;
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
        
        /* Loading Overlay */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        .loading-overlay.active {
            display: flex;
        }
        .loading-content {
            text-align: center;
            color: #fff;
        }
        .loading-spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .btn-register:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="mini-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <h4>Memproses registrasi...</h4>
            <p>Mohon tunggu sebentar</p>
        </div>
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
                        
                        <!-- Dropdown (preferred) -->
                        <select class="form-control @error('unit_id') is-invalid @enderror" 
                                name="unit_id" 
                                id="unitDropdown"
                                disabled
                                style="display:block;">
                            <option value="">-- Pilih Residence terlebih dahulu --</option>
                        </select>
                        <input type="hidden" name="unit_name" id="unitNameHidden" value="{{ old('unit_name') }}">
                        
                        <!-- Fallback text input (if dropdown fails to load) -->
                        <input type="text" 
                               class="form-control @error('unit_id') is-invalid @enderror" 
                               name="blok_rumah_fallback" 
                               id="blokRumahFallback"
                               placeholder="Contoh: A-12"
                               value="{{ old('blok_rumah_fallback') }}"
                               style="display:none;">
                        
                        @error('unit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted" id="unitHelpText">Pilih residence untuk melihat daftar unit</small>
                    </div>

                    <!-- Jenis Akun -->
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-user-tag"></i> Jenis Akun <span class="required">*</span>
                        </label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input @error('account_type') is-invalid @enderror" 
                                       type="radio" 
                                       name="account_type" 
                                       id="accountTypeWarga" 
                                       value="warga"
                                       {{ old('account_type', 'warga') == 'warga' ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label" for="accountTypeWarga">
                                    <i class="fas fa-users"></i> Warga
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('account_type') is-invalid @enderror" 
                                       type="radio" 
                                       name="account_type" 
                                       id="accountTypePengurus" 
                                       value="pengurus"
                                       {{ old('account_type') == 'pengurus' ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label" for="accountTypePengurus">
                                    <i class="fas fa-user-shield"></i> Pengurus
                                </label>
                            </div>
                        </div>
                        @error('account_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Pilih jenis akun yang sesuai dengan status Anda</small>
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
                                type="submit"
                                id="submitBtn">
                            <i class="fas fa-user-plus"></i> <span id="btnText">Daftar Sekarang</span>
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const residenceDropdown = document.querySelector('select[name="residence_id"]');
        const unitDropdown = document.getElementById('unitDropdown');
        const blokRumahFallback = document.getElementById('blokRumahFallback');
        const unitHelpText = document.getElementById('unitHelpText');
        const unitNameHidden = document.getElementById('unitNameHidden');
        let timeoutId = null;
        let loadedUnits = [];
        let apiAvailable = true;

        // Function to reset button state
        function resetButtonState() {
            submitBtn.disabled = false;
            btnText.innerHTML = 'Daftar Sekarang';
            loadingOverlay.classList.remove('active');
            if (timeoutId) {
                clearTimeout(timeoutId);
                timeoutId = null;
            }
        }

        // Load units based on selected residence
        residenceDropdown.addEventListener('change', function() {
            const residenceId = this.value;
            
            // Reset unit dropdown
            unitDropdown.innerHTML = '<option value="">-- Pilih Blok Rumah --</option>';
            unitDropdown.disabled = true;
            unitHelpText.textContent = 'Memuat data unit...';
            
            if (!residenceId) {
                unitHelpText.textContent = 'Pilih residence untuk melihat daftar unit';
                return;
            }

            // Show loading state
            unitHelpText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat data unit...';

            // Fetch units from Django API
            fetch(`https://admin.pewaca.id/api/units/residence/${residenceId}/`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.data && data.data.length > 0) {
                    loadedUnits = data.data;
                    
                    // Populate dropdown with units
                    data.data.forEach(unit => {
                        const option = document.createElement('option');
                        option.value = unit.unit_id;
                        option.textContent = unit.unit_name;
                        unitDropdown.appendChild(option);
                    });
                    unitDropdown.disabled = false;
                    unitHelpText.textContent = `${data.data.length} unit tersedia`;
                    
                    // Restore previously selected unit (for validation errors)
                    const oldUnitId = '{{ old('unit_id') }}';
                    if (oldUnitId) {
                        unitDropdown.value = oldUnitId;
                        const selectedUnit = loadedUnits.find(u => u.unit_id == oldUnitId);
                        if (selectedUnit) {
                            unitNameHidden.value = selectedUnit.unit_name;
                        }
                    }
                } else {
                    unitDropdown.innerHTML = '<option value="">Tidak ada unit tersedia</option>';
                    unitHelpText.textContent = 'Tidak ada unit tersedia untuk residence ini';
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Unit Tidak Tersedia',
                        text: 'Tidak ada unit yang tersedia untuk residence ini. Silakan pilih residence lain.',
                        confirmButtonColor: '#667eea'
                    });
                }
            })
            .catch(error => {
                console.error('Error loading units:', error);
                
                // Switch to fallback text input
                apiAvailable = false;
                unitDropdown.style.display = 'none';
                unitDropdown.disabled = true;
                unitDropdown.removeAttribute('required');
                
                blokRumahFallback.style.display = 'block';
                blokRumahFallback.disabled = false;
                blokRumahFallback.setAttribute('required', 'required');
                blokRumahFallback.focus();
                
                unitHelpText.innerHTML = '<i class="fas fa-exclamation-triangle text-warning"></i> Gunakan input manual untuk Blok Rumah';
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Mode Manual Aktif',
                    html: 'Dropdown tidak tersedia.<br>Silakan ketik Blok Rumah secara manual (contoh: A-12)',
                    confirmButtonColor: '#667eea'
                });
            });
        });

        // Update hidden unit_name when unit is selected
        unitDropdown.addEventListener('change', function() {
            const selectedUnitId = this.value;
            if (selectedUnitId && loadedUnits.length > 0) {
                const selectedUnit = loadedUnits.find(u => u.unit_id == selectedUnitId);
                if (selectedUnit) {
                    unitNameHidden.value = selectedUnit.unit_name;
                }
            } else {
                unitNameHidden.value = '';
            }
        });

        // Auto-load units on page load if residence is already selected (validation errors)
        document.addEventListener('DOMContentLoaded', function() {
            const oldResidenceId = '{{ old('residence_id') }}';
            if (oldResidenceId && residenceDropdown) {
                // Trigger change event to load units
                residenceDropdown.value = oldResidenceId;
                residenceDropdown.dispatchEvent(new Event('change'));
            }
        });

        // Form validation & submit handler
        form.addEventListener('submit', function(e) {
            // Validate phone number
            const phoneNo = document.querySelector('input[name="phone_no"]').value;
            const phonePattern = /^\d{8,13}$/;
            
            if (!phonePattern.test(phoneNo)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Format Nomor HP Salah!',
                    text: 'Nomor HP harus terdiri dari 8-13 digit angka',
                    confirmButtonColor: '#667eea'
                });
                return false;
            }

            // Show loading state
            submitBtn.disabled = true;
            btnText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            loadingOverlay.classList.add('active');

            // Set timeout (30 seconds)
            timeoutId = setTimeout(function() {
                resetButtonState();
                Swal.fire({
                    icon: 'warning',
                    title: 'Request Timeout',
                    text: 'Proses memakan waktu terlalu lama. Silakan coba lagi.',
                    confirmButtonColor: '#667eea'
                });
            }, 30000);
        });

        // Clear timeout on page unload (successful submit/redirect)
        window.addEventListener('beforeunload', function() {
            if (timeoutId) {
                clearTimeout(timeoutId);
            }
        });

        // Reset state if page loads with errors (validation failed)
        document.addEventListener('DOMContentLoaded', function() {
            @if($errors->any())
                resetButtonState();
            @endif
        });

        // Handle success/error messages from Laravel session
        @if(session('success'))
            resetButtonState();
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil!',
                html: '{{ session('success') }}',
                confirmButtonColor: '#667eea',
                confirmButtonText: 'Login Sekarang'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('login') }}';
                }
            });
        @endif

        @if(session('error'))
            resetButtonState();
            Swal.fire({
                icon: 'error',
                title: 'Registrasi Gagal!',
                html: '{{ session('error') }}',
                confirmButtonColor: '#667eea'
            });
        @endif
    </script>
</body>
</html>
