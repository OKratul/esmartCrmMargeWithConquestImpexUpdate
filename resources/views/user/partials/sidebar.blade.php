<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('images/pdf/pdf_logo2.png')}}" style="width: 150px" class="m-2 rounded">
            <img src="" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
            <div class="dropdown">
                <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown"  aria-expanded="false">
                    @if(auth()->guard('web')->check())
                        {{ auth()->user()->name }}
                    @else(auth()->guard('admin')->check())
                        {{ auth()->guard('admin')->user()->username }}
                    @endif
                </a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>

            <p class="text-muted left-user-info">Admin Head</p>

            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="#" class="text-muted left-user-info">
                        <i class="mdi mdi-cog"></i>
                    </a>
                </li>

                <li class="list-inline-item">
                    <a href="#">
                        <i class="mdi mdi-power"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="{{route('user-dashboard')}}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Apps</li>

                <li>
                    <a href="">
                        <i class="mdi mdi-calendar-blank-outline"></i>
                        <span> Calendar </span>
                    </a>
                </li>


                <li>
                    <a href="{{route('user-customers')}}">
                        <i class="mdi mdi-account-group"></i>
                        <span> Customers </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('user-woocommerce-products')}}">
                        <i class="dripicons-shopping-bag"></i>
                        <span> Products </span>
                    </a>
                </li>

                <li>
                    <a href="#contacts" data-bs-toggle="collapse">
                        <i class="mdi mdi-clipboard-outline"></i>
                        <span> Sales </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="contacts">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('all-query')}}">Queries</a>
                            </li>
                            <li>
                                <a href="{{route('user-view-all-quotation')}}">Quotations</a>
                            </li>
                            <li>
                                <a href="{{route('user-all-invoice')}}">Invoices</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title mt-2">Custom</li>

                <li>
                    <a href="#sidebarAuth" data-bs-toggle="collapse">
                        <i class="mdi mdi-book-open-page-variant-outline"></i>
                        <span> Accounts </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAuth">
                        <ul class="nav-second-level">
                            <li>
                                <a href="auth-login.html">All Account</a>
                            </li>
                            <li>
                                <a href="auth-register.html">Payments</a>
                            </li>
                            <li>
                                <a href="auth-recoverpw.html">Expenses</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarExpages" data-bs-toggle="collapse">
                        <i class="mdi mdi-file-multiple-outline"></i>
                        <span> PhoneBook </span>
                    </a>
                </li>

                <li>
                    <a href="#sidebarLayouts" data-bs-toggle="collapse">
                        <i class="mdi mdi-dock-window"></i>
                        <span> Documents </span>
                    </a>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
