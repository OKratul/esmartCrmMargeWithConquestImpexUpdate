@include('conquest.user.partials.layoutHeader')

<!-- body start -->
<body class="loading bg-soft-dark" data-layout-color="light"  data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>

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
            <div class="container-fluid">
                @include('error')
                @include('success')

                        <div class="bg-white mt-4">
                            <div class="row ">
                                <div class="col-12">
                                    <h2 style="padding-left: 10px">
                                        Customer Info ({{$customer->name}})
                                    </h2>
                                    <div class="d-flex p-3 gap-3" >
                                        <div class="p-3" style="background: rgba(168,255,5,0.4)">
                                            @php
                                                $totalValue = 0;
                                                foreach ($customer->invoices as $invoice){
                                                    $totalValue += $invoice->all_total_price;
                                                }
                                            @endphp
                                            <h3>Total Invoice <span class="badge bg-secondary">{{count($customer->invoices)}}</span></h3>
                                            <h4>
                                                ${{$totalValue}}
                                            </h4>
                                        </div>
                                        <div class="p-3" style="background: rgba(5,255,68,0.4)">
                                            @php
                                                $totalPay = 0;
                                                foreach ($customer->invoices as $invoice){
                                                    $totalPay += (float)$invoice->paid;
                                                }
                                            @endphp
                                            <h3>Total Paid <span class="badge bg-secondary">{{count($customer->invoices)}}</span></h3>
                                            <h4>
                                                ${{$totalPay}}
                                            </h4>
                                        </div>
                                        <div class="p-3" style="background: rgba(247, 81, 69,0.4)">
                                            @php
                                                $totalDue = 0;
                                                foreach ($customer->invoices as $invoice){
                                                    $totalDue += (float) $invoice->due;
                                                }
                                            @endphp

                                            <h3>Total Due <span class="badge bg-secondary">{{count($customer->invoices)}}</span></h3>
                                            <h4>
                                                ${{$totalDue}}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="dropdown float-end">
                                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Another action</a>
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Something else</a>
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
                                                </div>
                                            </div>
                                            <h4 class="mt-0 header-title">Customer Invoice Info</h4>

                                            <div class="table-responsive">
                                                <table class="table table-striped mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th># Invo. Number</th>
                                                        <th>Customer Info</th>
                                                        <th>Product Info</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($customer->invoices as $invoice)
                                                        <tr>
                                                            <td>{{$invoice->invoice_number}}</td>
                                                            <td>
                                                                Name:- {{$customer->name}}
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $productCodes = explode('+', $invoice->product_id);
                                                                    $productNames =[];
                                                                        foreach ($productCodes as $productCode){
                                                                            $productNames[] = \App\Models\conquest\ConquestProduct::where('product_code',$productCode)->first();
                                                                        }
                                                                @endphp

                                                                @foreach($productNames as $productName)
                                                                    {{$productName->name}}<br>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                $ {{$invoice->all_total_price}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">

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
