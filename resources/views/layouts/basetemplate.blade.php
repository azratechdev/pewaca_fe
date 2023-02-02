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
    <!-- ===== Plugin CSS ===== -->
    <link href="{{ asset('assets/plugins/components/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <!-- ===== Animation CSS ===== -->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <!-- ===== Custom CSS ===== -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- ===== Color CSS ===== -->
    <link href="{{ asset('assets/css/colors/default.css') }}" id="theme" rel="stylesheet">
    
</head>

<body class="fix-header mini-sidebar">
    <!-- ===== Main-Wrapper ===== -->
    <div id="wrapper">
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        
        @include('layouts.topbar')
        
        @include('layouts.sidebar')
      
        <!-- ===== Page-Content ===== -->
        <div class="page-wrapper">
            
            @yield('content')

            <footer class="footer t-a-c">
                © 2023 Cubic Admin
            </footer>
        </div>
        <!-- ===== Page-Content-End ===== -->
    </div>
    <!-- ===== Main-Wrapper-End ===== -->
    <!-- ==============================
        Required JS Files
    =============================== -->
    <!-- ===== jQuery ===== -->
    <script src="{{ asset('assets/plugins/components/jquery/dist/jquery.min.js') }}"></script>
    <!-- ===== Bootstrap JavaScript ===== -->
    <script src="{{ asset('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- ===== Slimscroll JavaScript ===== -->
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <!-- ===== Wave Effects JavaScript ===== -->
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <!-- ===== Menu Plugin JavaScript ===== -->
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <!-- ===== Custom JavaScript ===== -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- ===== Plugin JS ===== -->
    <script src="{{ asset('assets/plugins/components/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/components/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/components/sparkline/jquery.charts-sparkline.js') }}"></script>
    <script src="{{ asset('assets/plugins/components/knob/jquery.knob.js') }}"></script>
    <script src="{{ asset('assets/plugins/components/easypiechart/dist/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('assets/js/db1.js"') }}"></script>
    <!-- ===== Style Switcher JS ===== -->
    <script src="{{ asset('assets/plugins/components/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>

</html>
