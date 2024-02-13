@include('conquest.user.partials.layoutHeader')

<!-- body start -->
<body class="loading" data-layout-color="light"  data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>

<!-- Begin page -->
<div id="wrapper">


    <!-- Topbar Start -->
    @include('conquest.user.partials.navbar')
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->

    <!-- Left Sidebar End -->
    @include('conquest.user.partials.leftsideBar')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3> <i class="fe-users"></i> Transections</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Date</th>
                                    <th>Account Info</th>
                                    <th>Invoice Info</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($transections as $index => $transection)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{$transection->created_at->format('dM Y')}}<br>
                                                {{$transection->created_at->format('h:i A')}}
                                            </td>
                                            <td>
                                                {{$transection->accounts['account_name']}}<br>
                                                {{$transection->accounts['account_number']}}<br>
                                            </td>
                                            <td>
                                                Customer Name:-{{$transection->invoices->customers['name']}}<br>
                                                Invo No:- #{{$transection->invoices['invoice_number']}}<br>
                                            </td>
                                            <td>
                                                {{$transection->amount}} /-
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">

                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- container-fluid -->

        </div> <!-- content -->


    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Right Sidebar -->

@include('conquest.user.partials.rightbar')

<!-- Scripts -->
@include('conquest.user.partials.layoutScripts')

</body>
