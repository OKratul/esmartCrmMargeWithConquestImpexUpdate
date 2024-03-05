<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">

            <div class="dropdown">
                @php
                    $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user();
                @endphp
                @if($admin)
                    <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown" aria-expanded="false">
                        {{$admin->username}}
                    </a>
                @endif
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
                    <a href="{{route('conquest-dashboard')}}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('conquest-all-customer')}}">
                        <i class="fe-users"></i>
                        <span> Customers </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('conquest-all-products')}}">
                        <i class="fe-archive"></i>
                        <span>Products </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('conquest-all-invoices')}}">
                        <i class="fe-file-plus"></i>
                        <span>Invoices</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('conquest-payments')}}">
                        <i class="fe-file-plus"></i>
                        <span>Payments</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('conquest-all-expense')}}">
                        <i class="fe-file-plus"></i>
                        <span>Expense</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('conquest-accounts')}}">
                        <i class="fe-file-plus"></i>
                        <span>Accounts</span>
                    </a>
                </li>


            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
