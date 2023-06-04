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
                    <a href="{{ route('dashboard') }}" aria-expanded="false"><i class="fa fa-dashboard fa-fw"></i> <span class="hide-menu">Dashboard</span></a>
                </li>
                <li>
                    <a class="active waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="fa fa-briefcase fa-fw"></i> <span class="hide-menu"> Master</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('users') }}"><i class="fa fa-users" aria-hidden="true"></i> User</i></a></li>
                        <li><a href="{{ route('members') }}"><i class="fa fa-id-card" aria-hidden="true"> Member</i></a></li>
                        <li><a href="#"><i class="fa fa-coffee" aria-hidden="true"> Activity</i></a></li>
                        <li><a href="#"><i class="fa fa-cubes" aria-hidden="true"> Equipment</i></a></li>
                        <li><a href="#"><i class="fa fa-money" aria-hidden="true"> Finance</i></a></li>
                    </ul>
                </li>
                <li>
                    <a class="active waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="fa fa-cogs fa-fw"></i> <span class="hide-menu"> CMS</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#"><i class="fa fa-server" aria-hidden="true"> Section</i></a></li>
                        <li><a href="#"><i class="fa fa-newspaper-o" aria-hidden="true"> Content</i></a></li>
                        <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"> Inquiry</i></a></li>
                    </ul>
                </li>
                <li>
                    <a class="active waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="fa fa-wrench fa-fw"></i> <span class="hide-menu"> Setting</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#"><i class="fa fa-user-secret" aria-hidden="true"></i> User Setting</i></a></li>
                        <li><a href="#"><i class="fa fa-exchange" aria-hidden="true"></i> Api Setting</i></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- ===== Left-Sidebar-End ===== -->