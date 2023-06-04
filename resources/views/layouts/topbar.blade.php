  <!-- ===== Top-Navigation ===== -->
  <nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
            <i class="fa fa-bars"></i>
        </a>
        <div class="top-left-part">
            <a class="logo" href="{{ route('dashboard') }}">
                <b>
                    <img src="{{ asset('assets/plugins/images/logo.png') }}" alt="home" />
                </b>
                <span>
                    <img src="{{ asset('assets/plugins/images/logo-text.png') }}" alt="homepage" class="dark-logo" />
                </span>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-left hidden-md">
            <li>
                <a href="javascript:void(0)" class="sidebartoggler font-20 waves-effect waves-light"><i class="icon-arrow-left-circle"></i></a>
            </li>
            {{-- <div class="col-md-8">
                <marquee><p style="color:white;width: 350px;padding-top: 18px;padding-bottom: 0px;">User {{ Auth::user()->name }}been login in system</p></marquee>
            </div> --}}
        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">
            <li class="right-side-toggle">
                <a class="right-side-toggler waves-effect waves-light b-r-0 font-20" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-settings"></i>
                </a>
               
                <ul class="dropdown-menu animated flipInY">
                    <li><a href=""><i class="fa fa-user"></i> Profile</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href=""><i class="fa fa-inbox"></i> Inbox</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href=""><i class="fa fa-cog"></i> Account Settings</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- ===== Top-Navigation-End ===== -->