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
    <title>Cubic Admin Template</title>
    <!-- ===== Bootstrap CSS ===== -->
    <link href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
   
    <!-- ===== Animation CSS ===== -->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <!-- ===== Custom CSS ===== -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- ===== Color CSS ===== -->
    <link href="{{ asset('assets/css/colors/default.css') }}" id="theme" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    {{-- <script src="https://www.google.com/recaptcha/api.js?render=reCAPTCHA_site_key"></script> --}}
    <style>
        .login-register {
            background: url(../assets/plugins/images/login-register.jpg) center center/cover no-repeat!important;
            height: 100%; 
            position: fixed;
        }
        .login-box {
            background: #fff;
            width: 400px;
            margin: 3% auto 3%
        }

        .login-box .footer {
            width: 100%;
            left: 0;
            right: 0
        }
        .g-recaptcha {
            transform:scale(0.77) !important;
            -webkit-transform:scale(0.77) !important;
            transform-origin:0 0 !important;
            -webkit-transform-origin:0 0 !important;
        }

        .election-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }

        .election-banner h4 {
            margin: 0 0 10px 0;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .election-banner p {
            margin: 5px 0;
            font-size: 0.9rem;
        }

        .countdown {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 10px 0;
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

<body class="mini-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box">
                <div class="election-banner">
                    <h4><i class="fa fa-bullhorn"></i> PEMILIHAN KETUA PAGUYUBAN</h4>
                    <p>Teras Country Periode 2025 - 2029</p>
                    <div class="countdown" id="countdown">
                        <i class="fa fa-clock-o"></i> Menghitung waktu...
                    </div>
                    <p style="font-size: 0.85rem; margin-top: 5px;">Gunakan hak pilih Anda untuk masa depan yang lebih baik!</p>
                    <a href="{{ route('voting.index') }}" class="btn-vote">
                        <i class="fa fa-vote-yea"></i> Vote Sekarang
                    </a>
                </div>
                
                <h3 class="box-title" align="center"><u>Login Pengurus / Warga</u></h3>
                <form class="form-horizontal" id="loginform" method="post" action="{{ route('postlogin') }}" enctype="multipart/form-data">
                    @include('layouts.elements.flash')
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-xs-12">
                           <input type="email" class="form-control" name="email" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        </div>
                    </div>
                    @if(env('APP_ENV') === 'production')
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.sitekey') }}"></div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <div class="col-xs-12">
                           <a href="#" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot Password?</a> </div>
                    </div>
                   
                    <div class="form-group text-center">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                    <div class="form-group text-center mt-3">
                        <div class="col-xs-12">
                            <a href="{{ route('register') }}" class="btn btn-warning btn-lg btn-block text-uppercase waves-effect waves-light">
                                <i class="fa fa-user-plus"></i> Daftar Akun Baru
                            </a>
                        </div>
                    </div>
                    <div class="form-group text-center mt-3">
                        <div class="col-xs-12">
                            <a href="{{ route('companyProfile') }}" class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" style="background-color: #5FA782; border-color: #5FA782;">
                                <i class="fa fa-globe"></i> Go to Pewaca Web
                            </a>
                        </div>
                    </div>
                </form>

                {{-- <form class="form-horizontal" id="recoverform" action="index.html">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
                </form> --}}
            </div>
        </div>
    </section>
   
     <!-- ===== jQuery ===== -->
     <script src="{{ asset('assets/plugins/components/jquery/dist/jquery.min.js') }}"></script>
     <!-- ===== Bootstrap JavaScript ===== -->
     <script src="{{ asset('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
     <!-- ===== Slimscroll JavaScript ===== -->
     <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
     <!-- ===== Wave Effects JavaScript ===== -->
     <script src="{{ asset('assets/js/waves.js') }}"></script>
   
     <!-- ===== Custom JavaScript ===== -->
     <script src="{{ asset('assets/js/custom.js') }}"></script>
    
     <!-- ===== Style Switcher JS ===== -->
     <script src="{{ asset('assets/plugins/components/styleswitcher/jQuery.style.switcher.js') }}"></script>

     <!-- ===== Election Countdown Timer ===== -->
     <script>
        function updateCountdown() {
            const electionDate = new Date('2025-12-31 23:59:59').getTime();
            const now = new Date().getTime();
            const distance = electionDate - now;

            if (distance < 0) {
                document.getElementById('countdown').innerHTML = '<i class="fa fa-check-circle"></i> Pemilihan Sedang Berlangsung!';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

            let countdownText = '<i class="fa fa-clock-o"></i> ';
            
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
