<div class="navbar-custom bg-transparent">
    <ul class="list-unstyled topnav-menu float-end mb-0">

        <li class="d-none d-lg-block">
            <form method="GET" class="app-search"  @if(request()->routeIs('customers'))
                action="{{route('customers')}}"
                  @elseif(request()->routeIs('conquest-all-products'))
                      action="{{route('conquest-all-products')}}"
                  @elseif(request()->routeIs('conquest-all-invoices'))
                      action="{{route('conquest-all-invoices')}}"
                @endif>
                @csrf
                <div class="app-search-box">
                    <div class="input-group">
                           <input name="search" type="text" class="form-control" placeholder="Search..." id="top-search">
                           <button class="btn input-group-text" type="submit">
                               <i class="fe-search"></i>
                           </button>
                    </div>
                </div>
            </form>
        </li>

        <li class="dropdown d-inline-block d-lg-none">
            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-search noti-icon"></i>
            </a>
            <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                <form class="p-3">
                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                </form>
            </div>
        </li>


        <li class="dropdown notification-list topbar-dropdown">
            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <span class="pro-user-name ms-1">
                                    Nowak <i class="mdi mdi-chevron-down"></i>
                                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome !</h6>
                </div>

                <!-- item-->
                <a href="contacts-profile.html" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>My Account</span>
                </a>


                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="auth-logout.html" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>

        <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                <i class="fe-settings noti-icon"></i>
            </a>
        </li>

    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="index.html" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="" height="22">
                            </span>
            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="" height="16">
                            </span>
        </a>
        <a href="index.html" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="" height="22">
                            </span>
            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="" height="16">
                            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect">
                <i class="fe-menu"></i>
            </button>
        </li>
        <li>
            <div class="rounded-pill p-2" style="background:#04022e; margin-left:20px; margin-top:15px">
                <a href="{{route('dashboard')}}" target="_blank">
                    <img src="{{asset('images/12356.png')}}" width="150px">
                </a>
            </div>
        </li>
    </ul>

    <div class="clearfix"></div>

</div>
