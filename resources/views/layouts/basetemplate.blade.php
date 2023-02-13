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
     <!-- ===== jQuery ===== -->
     <script src="{{ asset('assets/plugins/components/jquery/dist/jquery.min.js') }}"></script>

    <title>Administrator Skyhawk</title>
    <!-- ===== Bootstrap CSS ===== -->
    <link href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- ===== Plugin CSS ===== -->
    <link href="{{ asset('assets/plugins/components/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">

    <!-- ===== Datatable CSS ===== -->
    <link href="{{ asset('assets/plugins/components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

    <!-- ===== Animation CSS ===== -->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <!-- ===== Custom CSS ===== -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- ===== Color CSS ===== -->
    <link href="{{ asset('assets/css/colors/default.css') }}" id="theme" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    
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
    
    <!-- ===== Datatable JS ===== -->
    <script src="{{ asset('assets/plugins/components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- ===== Style Switcher JS ===== -->
    
    <script src="{{ asset('assets/plugins/components/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>

</html>
