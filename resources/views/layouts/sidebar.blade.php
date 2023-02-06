  <!-- ===== Left-Sidebar ===== -->
  <aside class="sidebar">
    <div class="scroll-sidebar">
        <div class="user-profile">
            <div class="dropdown user-pro-body">
                <div class="profile-image">
                    <img src="{{ asset('assets/plugins/images/users/hanna.jpg') }}" alt="user-img" class="img-circle">
                    {{-- <a href="javascript:void(0);" class="dropdown-toggle u-dropdown text-blue" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="badge badge-danger">
                            <i class="fa fa-angle-down"></i>
                        </span>
                    </a> --}}
                    {{-- <ul class="dropdown-menu animated flipInY">
                        <li><a href="javascript:void(0);"><i class="fa fa-user"></i> Profile</a></li>
                        <li><a href="javascript:void(0);"><i class="fa fa-inbox"></i> Inbox</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="javascript:void(0);"><i class="fa fa-cog"></i> Account Settings</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href=""><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul> --}}
                </div>
                <p class="profile-text m-t-15 font-16"><a href="javascript:void(0);">{{ Auth::user()->name }}</a></p>
            </div>
            <hr>
        </div>
        
        <nav class="sidebar-nav">
            <ul id="side-menu">
                <li>
                    <a href="" aria-expanded="false"><i class="icon-home fa-fw"></i> <span class="hide-menu">Home</span></a>
                </li>
                <li>
                    <a class="active waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-briefcase fa-fw"></i> <span class="hide-menu"> Master</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('users') }}"><i class="icon-user" aria-hidden="true"> User</i></a></li>
                        <li><a href="#"><i class="icon-people" aria-hidden="true"> Member</i></a></li>
                        <li><a href="#"><i class="icon-cup" aria-hidden="true"> Activity</i></a></li>
                        <li><a href="#"><i class="icon-fire" aria-hidden="true"> Equipment</i></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- ===== Left-Sidebar-End ===== -->