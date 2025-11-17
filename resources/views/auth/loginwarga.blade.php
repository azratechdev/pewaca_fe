<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
  <title>Pewaca - Login</title>
  <link rel="manifest" href="{{ url('manifest.json') }}">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    /* Animated background shapes */
    body::before {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      top: -250px;
      right: -250px;
      animation: float 20s infinite ease-in-out;
    }

    body::after {
      content: '';
      position: absolute;
      width: 300px;
      height: 300px;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 50%;
      bottom: -150px;
      left: -150px;
      animation: float 15s infinite ease-in-out reverse;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px) translateX(0px); }
      50% { transform: translateY(-30px) translateX(30px); }
    }

    .login-container {
      width: 100%;
      max-width: 450px;
      position: relative;
      z-index: 1;
      animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-card {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(10px);
      border-radius: 24px;
      padding: 45px 40px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15),
                  0 0 0 1px rgba(255, 255, 255, 0.1);
      border: none;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
    }

    .logo-container {
      text-align: center;
      margin-bottom: 30px;
    }

    .logo-container img {
      width: 160px;
      height: auto;
      transition: transform 0.3s ease;
    }

    .logo-container img:hover {
      transform: scale(1.05);
    }

    .welcome-text {
      text-align: center;
      margin-bottom: 35px;
    }

    .welcome-text h4 {
      font-size: 15px;
      color: #6b7280;
      font-weight: 400;
      margin-bottom: 5px;
      letter-spacing: 0.3px;
    }

    .welcome-text h2 {
      font-size: 28px;
      font-weight: 700;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin: 0;
    }

    .form-floating {
      margin-bottom: 20px;
      position: relative;
    }

    .form-floating > .form-control {
      height: 56px;
      border-radius: 12px;
      border: 2px solid #e5e7eb;
      padding: 16px 20px;
      font-size: 15px;
      transition: all 0.3s ease;
      background: #f9fafb;
    }

    .form-floating > .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
      background: white;
      outline: none;
    }

    .form-floating > label {
      padding: 16px 20px;
      font-size: 14px;
      color: #6b7280;
      font-weight: 500;
    }

    .toggle-password {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #9ca3af;
      font-size: 16px;
      transition: color 0.2s ease;
      z-index: 10;
    }

    .toggle-password:hover {
      color: #667eea;
    }

    .forgot-password {
      text-align: right;
      margin-bottom: 25px;
    }

    .forgot-password a {
      color: #667eea;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: color 0.2s ease;
    }

    .forgot-password a:hover {
      color: #764ba2;
      text-decoration: underline;
    }

    .btn-login {
      width: 100%;
      height: 56px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      border-radius: 12px;
      color: white;
      font-size: 16px;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
      position: relative;
      overflow: hidden;
    }

    .btn-login::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .btn-login:hover::before {
      left: 100%;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-login:disabled {
      background: #d1d5db;
      cursor: not-allowed;
      box-shadow: none;
    }

    .btn-login:disabled:hover {
      transform: none;
    }

    .powered-by {
      text-align: center;
      margin-top: 30px;
      padding-top: 25px;
      border-top: 1px solid #e5e7eb;
    }

    .powered-by p {
      font-size: 14px;
      color: #6b7280;
      margin: 0;
      font-weight: 500;
    }

    .powered-by a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .powered-by a:hover {
      color: #764ba2;
    }

    /* Alert styling */
    .alert {
      border-radius: 12px;
      border: none;
      padding: 16px 20px;
      margin-bottom: 25px;
      animation: slideDown 0.4s ease-out;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert-danger {
      background: #fee2e2;
      color: #991b1b;
    }

    .alert-success {
      background: #d1fae5;
      color: #065f46;
    }

    /* Responsive */
    @media (max-width: 576px) {
      .login-card {
        padding: 35px 25px;
        border-radius: 20px;
      }

      .welcome-text h2 {
        font-size: 24px;
      }

      .form-floating > .form-control {
        height: 52px;
      }

      .btn-login {
        height: 52px;
      }
    }

    /* Loading animation */
    .btn-login.loading {
      pointer-events: none;
    }

    .btn-login.loading::after {
      content: '';
      position: absolute;
      width: 16px;
      height: 16px;
      border: 2px solid white;
      border-top-color: transparent;
      border-radius: 50%;
      animation: spin 0.6s linear infinite;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
    }

    @keyframes spin {
      to { transform: translateY(-50%) rotate(360deg); }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="login-card">
      <!-- Logo -->
      <div class="logo-container">
        <img src="{{ asset('assets/plugins/images/mainlogo.png') }}" alt="Pewaca Logo" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22160%22 height=%2260%22%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2224%22 fill=%22%23667eea%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3EPewaca%3C/text%3E%3C/svg%3E'">
      </div>

      <!-- Welcome Text -->
      <div class="welcome-text">
        <h4>Selamat Datang di</h4>
        <h2>Pewaca</h2>
      </div>

      <!-- Flash Messages -->
      <div class="flash-messages">
        @include('layouts.elements.flash')
      </div>

      <!-- Login Form -->
      <form id="loginform" method="post" action="{{ route('postlogin') }}">
        @csrf
        
        <!-- Email -->
        <div class="form-floating">
          <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
          <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
        </div>

        <!-- Password -->
        <div class="form-floating position-relative">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
          <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
          <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
        </div>

        <!-- Forgot Password -->
        <div class="forgot-password">
          <a href="{{ route('showFormReset') }}">Lupa Kata Sandi?</a>
        </div>

        <!-- Submit Button -->
        <button type="submit" id="submitBtn" class="btn-login" disabled>
          <span>Masuk</span>
        </button>

        <!-- Powered By -->
        <div class="powered-by">
          <p>
            Powered by <a href="https://hemitech.id/" target="_blank" rel="noopener noreferrer">Hemitech ID</a>
          </p>
        </div>
      </form>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $('#loginform').on('submit', function(e) {
        const btn = $('#submitBtn');
        btn.addClass('loading');
        btn.html('<span>Loading...</span>');
        
        Swal.fire({
            text: 'Memproses login...',
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

    // Check immediately on load
    toggleSubmitButton();

    // Check again after a short delay for browser autofill
    setTimeout(toggleSubmitButton, 100);
    setTimeout(toggleSubmitButton, 500);

    // Listen for input changes
    emailInput.addEventListener('input', toggleSubmitButton);
    passwordInput.addEventListener('input', toggleSubmitButton);

    // Listen for change events (fires when autofill completes)
    emailInput.addEventListener('change', toggleSubmitButton);
    passwordInput.addEventListener('change', toggleSubmitButton);

    // Listen for autofill animation (Chrome/Edge)
    emailInput.addEventListener('animationstart', function(e) {
        if (e.animationName === 'onAutoFillStart') {
            setTimeout(toggleSubmitButton, 50);
        }
    });

    // Add smooth focus animations
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
  </script>
 
</body>
</html>
