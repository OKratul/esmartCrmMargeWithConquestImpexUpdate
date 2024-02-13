@include('user.partials.layoutHeader')

<!-- body start -->
<body class="loading bg-soft-dark" data-layout-color="light"  data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>

<!-- Begin page -->
<div id="wrapper">


    <!-- Topbar Start -->
    @include('user.partials.navbar')
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->

    <!-- Left Sidebar End -->
    @include('user.partials.leftsideBar')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                @include('error')
                @include('success')

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3> <i class="fe-users"></i> Payments</h3>
                            </div>
                            <div>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#add-payment-modal">
                                    Add Payment <i class="fe-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Date</th>
                                    <th>Customer Name</th>
                                    <th>Paid Amount</th>
                                    <th>Pay Type</th>
                                    <th>Invoice No</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $index => $payment)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$payment->date}}</td>
                                        <td>{{$payment->customers['name']}}</td>
                                        <td>{{$payment->pay_amount}}</td>
                                        <td>{{$payment->pay_type}}</td>
                                        <td>{{$payment->invoice_no}}</td>
                                        <td>
                                            <a href="#" class="btn btn-outline-primary">Money.Rec</a>
                                            <button class="btn btn-outline-primary">View</button>
                                            <a class="btn btn-outline-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{$payments->links('pagination::Bootstrap-5')}}
                            </div>
                        </div>

                    </div>
                </div>

            </div> <!-- container-fluid -->

        </div> <!-- content -->

{{--        Add Payment Modal  --}}

        <div class="modal fade" id="add-payment-modal" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('add-payment')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-2 col-6">
                                    <label for="simpleinput" class="form-label">Select Customer*</label>
                                    <select required name="customer_id" class="form-select" aria-label="Default select example">
                                        <option> </option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2 col-6">
                                    <label for="simpleinput" class="form-label">Payment_Type*</label>
                                    <select required name="payment_type" class="form-select" aria-label="Default select example">
                                        <option> </option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Bank Deposit">Bank Deposit</option>
                                        <option value="Bank Cheque">Bank Cheque</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Bkash">Bkash</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-2 col-6">
                                    @php
                                        $accounts = \App\Models\Account::all();
                                    @endphp
                                    <label for="simpleinput" class="form-label">Select Account*</label>
                                    <select required name="account_no" class="form-select" aria-label="Default select example">
                                        <option> </option>
                                        @foreach($accounts as $account )
                                            <option value="{{$account->id}}">{{$account->account_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2 col-6">
                                    <label for="simpleinput" class="form-label">Pay Amount *</label>
                                    <input name="paid_amount" type="text" required id="simpleinput" class="form-control">
                                </div>

                            </div>
                            <div class="row">
                                <div class="mb-2 col-6">
                                    <label for="simpleinput" class="form-label">Invoice No*</label>
                                    <input required name="invoice_no" type="text" id="simpleinput" class="form-control">
                                </div>
                                <div class="mb-2 col-6">
                                    <label for="simpleinput" class="form-label">Date </label>
                                    <input name="date" type="date" id="simpleinput" class="form-control">
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary">
                                    Submit <i class="fe-user-plus"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    {{-- Add Customer Modal --}}

</div>
<!-- END wrapper -->

<!-- Right Sidebar -->

@include('user.partials.rightbar')

<!-- Scripts -->
@include('user.partials.layoutScripts')

</body>
