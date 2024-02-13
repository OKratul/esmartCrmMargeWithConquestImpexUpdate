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
            <div class="container-fluid">

                <div class="row" style="margin-top: 25px">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="values-container d-flex gap-2">
                                    <div class="p-3 rounded" style="background: rgba(168,255,5,0.4)">
                                        <h3>Total Invoice <span class="badge badge bg-secondary" style="font-size: 20px">{{count($invoices)}}</span></h3>
                                        <h4>${{$totalInvoiceValue}}</h4>
                                    </div>
                                    <div class="p-3 rounded" style="background: rgba(5,255,68,0.4)">
                                        <h3>Total Paid</h3>
                                        <h4>${{$totalInvoiceValue}}</h4>
                                    </div>
                                    <div class="p-3 rounded" style="background: rgba(247, 81, 69,0.4)">
                                        <h3>Total Due</h3>
                                        <h4>${{$totalInvoiceValue}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6" style="margin-top: 25px">
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
                                <h2 class="mt-0 header-title">Products</h2>

                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Product Code</th>
                                            <th>Stock</th>
                                            <th>Total Sell Qty</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($products as $index => $product)
                                               <tr class="{{$product->quantity <= 25 ? 'table-danger' : ''}}">
                                                   <td>{{$loop->iteration}}</td>
                                                   <td>{{$product->product_code}}</td>
                                                   <td>{{$product->name}}</td>
                                                   <td>{{$product->quantity}}</td>
                                                   <td>{{$product->stocks['add_qty'] - $product->quantity}}</td>
                                               </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                    <div style="margin-top: 15px">
                                        {{ $products->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-6" style="margin-top: 25px">
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
                                <h4 class="mt-0 header-title">Top Customers</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                                <th>Invoice Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($customers as $index=>$customer)
                                               <tr>
                                                   <td>{{$loop->iteration}}</td>
                                                   <td>{{$customer->name}}</td>
                                                   <td>{{$customer->address}}</td>
                                                   <td>{{$customer->phone}}</td>
                                                   <td>
                                                       @php
                                                            $invoiceValue = 0;

                                                            foreach ($customer->invoices as $invoice){
                                                                $invoiceValue += $invoice->all_total_price;
                                                            }

                                                       @endphp
                                                       Count:- {{count($customer->invoices)}}<br>
                                                       $ {{$invoiceValue}}
                                                   </td>
                                               </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                    <div>
                                        {{$customers->links('pagination::bootstrap-5')}}
                                    </div>
                                </div>
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
