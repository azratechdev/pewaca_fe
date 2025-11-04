<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
  <title>Pewaca</title>
  <link rel="manifest" href="{{ url('manifest.json') }}">

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    .navbar-custom {
      background-color:  #198754; /* Tosca color */
      padding-top: 0px;
      padding-bottom: 0px;
    }
      
    .card , .login-alert, .logo{
        margin: 20px; /* Batas atas, kiri, kanan, dan bawah */
        border:0px;
    }
   
    a {
      text-decoration: none;
    }

    .waca-logo {
        width: 190px; /* Sesuaikan ukuran yang diinginkan */
        height: 60px; /* Sesuaikan ukuran yang diinginkan */
        border:0px;
    }

    .password-container {
      position: relative;
    }
    
    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6b7280;
    }

    .election-banner {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 20px;
      border-radius: 15px;
      margin-bottom: 20px;
      text-align: center;
      box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    }

    .election-banner h5 {
      margin: 0 0 8px 0;
      font-weight: 700;
      font-size: 1.1rem;
    }

    .election-banner p {
      margin: 5px 0;
      font-size: 0.9rem;
    }

    .countdown {
      font-size: 1.4rem;
      font-weight: 700;
      margin: 12px 0;
      color: #ffd700;
    }

    .btn-vote {
      background: white;
      color: #667eea;
      border: none;
      padding: 10px 25px;
      border-radius: 25px;
      font-weight: 600;
      margin-top: 10px;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }

    .btn-vote:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      color: #667eea;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                  <div class="mb-4 mt-4" style="align-items: left;">
                    <picture>
                      <img src="{{ asset('assets/plugins/images/mainlogo.png') }}" class="img-fluid img-thumbnail waca-logo" alt="Waca Logo">
                    </picture>
                  </div>

                  <div class="election-banner">
                    <h5><i class="fas fa-bullhorn"></i> PEMILIHAN KETUA PAGUYUBAN</h5>
                    <p>Teras Country Periode 2025 - 2029</p>
                    <div class="countdown" id="countdown">
                      <i class="fas fa-clock"></i> Menghitung waktu...
                    </div>
                    <p style="font-size: 0.85rem; margin-top: 5px;">Gunakan hak pilih Anda untuk masa depan yang lebih baik!</p>
                    <a href="{{ route('voting.index') }}" class="btn-vote">
                      <i class="fas fa-vote-yea"></i> Vote Sekarang
                    </a>
                  </div>

                  <div class="mb-3">
                    <p class="text-left">Selamat Datang di</p>
                    <p><strong>Pewaca</strong></p>
                  </div>
      
                  <div class="mb-3">
                    @include('layouts.elements.flash')
                  </div>
                    <form id="loginform" method="post" action="{{ route('postlogin') }}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating position-relative">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <label for="password">Password</label>
                            <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-12 col-sm-12">
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="form-check">
                                {{-- <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                  Ingat Saya
                                </label> --}}
                              </div>
                              <div>
                                <a href="{{ route('showFormReset') }}">Lupa Kata Sandi?</a>
                              </div>
                            </div>
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <div class="col-md-12">
                              <button type="submit" id="submitBtn" class="btn btn-success form-control" type="button" disabled>Masuk</button>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-12">
                              <a href="{{ route('companyProfile') }}" class="btn btn-outline-success form-control">
                                <i class="fas fa-globe"></i> Go to Pewaca Web
                              </a>
                          </div>
                        </div>
                        <br>
                        <div class="mb-3">
                          <p class="text-center">Belum punya akun? Hubungi Pengurus.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $('#loginform').on('submit', function(e) {
        Swal.fire({
            text: 'Loading...',
            allowOutsideClick: false, 
            allowEscapeKey: false,  
            didOpen: () => {
                Swal.showLoading(); 
            }
        });
    });

    // Password toggle functionality
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    // Email and password validation
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const submitBtn = document.getElementById('submitBtn');

    function toggleSubmitButton() {
        if (emailInput.value.trim() && passwordInput.value.trim()) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    emailInput.addEventListener('input', toggleSubmitButton);
    passwordInput.addEventListener('input', toggleSubmitButton);

    // Election Countdown Timer
    function updateCountdown() {
      const electionDate = new Date('2025-12-31 23:59:59').getTime();
      const now = new Date().getTime();
      const distance = electionDate - now;

      if (distance < 0) {
        document.getElementById('countdown').innerHTML = '<i class="fas fa-check-circle"></i> Pemilihan Sedang Berlangsung!';
        return;
      }

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

      let countdownText = '<i class="fas fa-clock"></i> ';
      
      if (days > 0) {
        countdownText += days + ' Hari ';
      }
      if (hours > 0 || days > 0) {
        countdownText += hours + ' Jam ';
      }
      countdownText += minutes + ' Menit';

      document.getElementById('countdown').innerHTML = countdownText;
    }

    updateCountdown();
    setInterval(updateCountdown, 60000);
  </script>
 
</body>
</html>
