<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
    <img src="/img/logo.png" alt="Laravel Starter" class="brand-image img-circle elevation-3"
   style="opacity: .8">
<span class="brand-text font-weight-light">NSAP Tracker v1</span>
</a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/img/profile.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"> {{auth()->user()->name!=null ? auth()->user()->name : "Administrator"}} </a>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Start | Dashboard menue -->
                <li class="nav-item has-treeview {!! classActivePath(1,'dashboard') !!}">
                    <a href="{!! route('home') !!}" class="nav-link {!! classActiveSegment(1, 'dashboard') !!}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {!! classActiveSegment(2, 'home') !!}">
                    <i class="fas fa-circle"></i>
                    <p>Dashboard v1</p>
                  </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="{{ route('v2') }}" class="nav-link {!! classActiveSegment(2, 'v2') !!}">
                    <i class="fas fa-circle"></i>
                    <p>Dashboard v2</p>
                  </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a href="{{ route('v3') }}" class="nav-link {!! classActiveSegment(2, 'v3') !!}">
                    <i class="fas fa-circle"></i>
                    <p>Dashboard v3</p>
                  </a>
                        </li> -->
                    </ul>
                </li>
                <!-- End |Dashboard Menue -->

                <!-- Start | Gantt Chart -->
                <li class="nav-header">GANTT</li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope-open"></i>
                          <p>
                            Charts
                            <i class="fa fa-angle-left right"></i>
                          </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/gantt" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>Daily</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/gantt/w" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>Weekly</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/gantt/m" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>Monthly</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/gantt/q" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>Quarterly</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/gantt/y" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>Yearly</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End | Gantt Chart -->


                <!-- Start | Module Management -->
                <li class="nav-header">MODULE MANAGEMENT</li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope-open"></i>
                          <p>
                            Modules
                            <i class="fa fa-angle-left right"></i>
                          </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/main_modules" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/main_modules/create" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>New Main Module</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/mailbox/compose.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>New Sub Module</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End | Module Management -->




                <li class="nav-header">USER MANAGEMENT</li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope-open"></i>
                          <p>
                            Users
                            <i class="fa fa-angle-left right"></i>
                          </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/mailbox/mailbox.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/mailbox/compose.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>New User</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope-open"></i>
                          <p>
                            Permissions
                            <i class="fa fa-angle-left right"></i>
                          </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/roles" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/permissions" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                  <p>Grant Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>







            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
