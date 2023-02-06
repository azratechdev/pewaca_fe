<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
   
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/favicon.png') }}">
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
                <h3 class="box-title" align="center"><u>Login Administrator</u></h3>
                <form class="form-horizontal" id="loginform" method="post" action="{{ route('login') }}" enctype="multipart/form-data">
                    @include('layouts.elements.flash')
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-xs-12">
                           <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="g-recaptcha" data-sitekey="6Lfwf0gkAAAAAF6rAzrr7EmWKeYRz5eKl8oiFjIG"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                           <a href="#" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                    </div>
                   
                    <div class="form-group text-center">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
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
</body>

</html>
