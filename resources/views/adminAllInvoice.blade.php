@include('partials.layoutHead')

<div id="wrapper">

    @include('partials.navbar')
    @include('partials.sidebar')


    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
{{--                                Filter Form--}}
                                <form action="{{route('admin-all-invoice')}}" method="GET">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">

                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex gap-2 align-items-center justify-content-end">
                                                <div class="mb-2 ">
                                                    <label for="example-date" class="form-label">Date form</label>
                                                    <input class="form-control" id="example-date" type="date" name="date-form">
                                                </div>
                                                <div class="mb-2 ">
                                                    <label for="example-date" class="form-label">Date To</label>
                                                    <input class="form-control" id="example-date" type="date" name="date-to">
                                                </div>
                                                <div class="mb-2 " style="width: 200px">
                                                    <label for="inputState" class="form-label">User</label>
                                                    <select id="inputState" name="user" class="form-select">
                                                        <option></option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2" style="width: 200px">
                                                    <label for="inputState" class="form-label">Status</label>
                                                    <select name="status" id="inputState" class="form-select">
                                                        <option></option>
                                                        <option value="Paid">Paid</option>
                                                        <option value="Due">Due</option>
                                                    </select>
                                                </div>

                                                <div class="mb-0" style="margin-top: 20px">
                                                    <button type="submit"
                                                            class="btn btn-outline-primary waves-effect waves-light">
                                                        <i class="fe-filter"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="d-flex align-items-center gap-2">
                                    <h3 style="font-size: 25px" class="badge badge-outline-secondary">
                                        Invoices:
                                    </h3>
                                    <a href="{{route('admin-invoice-export')}}" style="font-size: 18px">
                                        <i class="fas fa-file-excel"></i>
                                        Export Invoice Report
                                    </a>
                                </div>

                                    <hr>

                            </div>
                            <div class="col-8">
                                <div class="d-flex gap-2 justify-content-end">
                                    <div class="p-2"
                                         style="border-left: 3px solid #000; background: rgba(241, 196, 15, 0.3); width: 200px">
                                        <h4>{{$totalInvoice}}</h4>
                                        <h5>Total Invoice</h5>
                                    </div>
                                    <div class="p-2"
                                         style="border-left: 3px solid #000; background: rgba(13,106,244,0.3);  width: 200px"
                                    >
                                        <h4>${{$totalInvoiceValue}}</h4>
                                        <h5>Total Invoice Value</h5>
                                    </div>
                                    <div class="p-2"
                                         style="border-left: 3px solid #000; background: rgba(124,252,0,0.3);  width: 200px"
                                    >
                                        <h4>${{$totalPayment}}</h4>
                                        <h5>Total Payment</h5>
                                    </div>
                                    <div class="p-2"
                                         style="border-left: 3px solid #000; background: rgba(0,128,0,0.3);  width: 200px"
                                    >
                                        <h4>${{$totalDue}}</h4>
                                        <h5>Total Invoice Due</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Invoice No</th>
                                            <th>
                                                User
                                            </th>
                                            <th>Customer Info</th>
                                            <th>Contact Person</th>
                                            <th>Product Details</th>
                                            <th>Total Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoices as $invoice)
                                        <tr style=" {{ $invoice->status == 'Paid' ? 'background-image: url('.asset('images/paid.jpg').')' : '' }};
                                        background-position: center ;
                                        background-repeat: no-repeat;

                                        ">
                                            <td class="align-middle">
                                                {{$invoice->created_at->format('d-M-Y')}}<br>
                                                {{$invoice->created_at->format('H:i:s A')}}
                                            </td>
                                            <td class="align-middle">
                                                <strong>
                                                    #{{$invoice->invoice_no}}
                                                </strong>
                                            </td>
                                            <td class="align-middle">
                                                <strong>
                                                    @if($invoice->users == !null)
                                                        {{$invoice->users['name']}}
                                                    @endif
                                                </strong>
                                            </td>
                                            <td class="align-middle">
                                                {{$invoice->customers['name']}}<br>
                                                @if(!empty($invoice->customers['email']))
                                                    {{$invoice->customers['email']}}<br>
                                                @endif
                                                {{$invoice->customers['phone_number']}}
                                            </td>
                                            <td class="align-middle">
                                                @if(!empty($invoice->customers['contact_name']))
                                                    {{$invoice->customers['contact_name']}}<br>
                                                    {{$invoice->phone_number}}
                                                @endif
                                            </td>
                                            <td>
                                                <div style="height: 140px; overflow: auto">
                                                    <?php
                                                    $totalPrice = 0;
                                                    $products = json_decode($invoice->products, true);
                                                    ?>
                                                    @foreach($products as $product)
                                                        @php
                                                            $priceWithVat = $product['unit_price'] + $product['unit_price'] * $invoice->vat_tax / 100;
                                                            $totalPrice = $priceWithVat * $product['quantity'];
                                                            $productNameArray = explode(',', $product['product_name']);
                                                            $productNameWithBreaks = implode('<br>', $productNameArray);
                                                        @endphp
                                                        <strong style="font-size: 13px">Name:-</strong>{!! $productNameWithBreaks !!}<br>
                                                        <strong style="font-size: 13px">Code:-</strong>{{$product['product_code']}}<br>
                                                        <strong style="font-size: 13px">Unit Price:-</strong>{{$product['unit_price']}}.tk<br>
                                                        <hr>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                total: {{$totalPrice}}<br>
                                                paid: {{ $invoice->payments->sum('amount') }}<br>
                                                Due: {{ $totalPrice - $invoice->payments->sum('amount') }}
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex gap-1">
                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       class="btn btn-outline-primary rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center" target="_blank"
                                                       href="{{route('admin-view-invoice-pdf',[$invoice->customer_id,$invoice->id])}}">
                                                        <i class="fe-eye" style="font-size: 20px"></i>
                                                    </a>

                                                    <button style="width: 45px; height: 45px; padding: 0" type="button" class="btn btn-outline-primary rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#invoice-edit-modal-{{$invoice->id}}">
                                                        <i class="fe-edit-1" style="font-size: 20px"></i>
                                                    </button>

                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       onclick="return confirm('Are you sure you want to delete this Invoice?')"
                                                       class="btn btn-outline-danger rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                       href="{{route('admin-delete-invoice', [$invoice->customer_id, $invoice->id])}}">
                                                        <i class="fe-trash-2" style="font-size: 20px"></i>
                                                    </a>
                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       class="btn btn-outline-secondary rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                       href="{{route('admin-download-invoice',[$invoice->id])}}">
                                                        <i class="fe-download" style="font-size: 20px"></i>
                                                    </a>

                                                </div>
                                                <div class="d-flex gap-1 mt-1">

                                                    <button
                                                        class="btn btn-outline-primary rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                        style="width: 45px; height: 45px; padding: 0"
                                                        type="button" data-bs-toggle="modal" data-bs-target="#invice-sms-modal-{{$invoice->id}}">
                                                        <i class="fe-message-square" style="font-size: 20px"></i>
                                                    </button>

                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       class="btn btn-outline-primary rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                       href="{{route('admin-invoice-mail',[$invoice->id])}}">
                                                        <i class="fe-send" style="font-size: 20px"></i>
                                                    </a>
                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       class="btn btn-outline-primary rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center" target="_blank"
                                                       href="{{route('admin-challan',[$invoice->id])}}">
                                                        <i class="fe-file-text" style="font-size: 20px"></i>
                                                    </a>
                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       class="btn btn-outline-success rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center" target="_blank"
                                                       href="{{route('admin-money-receipt',[$invoice->id])}}">
                                                        <i class="fe-clipboard" style="font-size: 20px"></i>
                                                    </a>
                                                </div>

                                                <div class="d-flex gap-1 mt-1">

                                                    <button type="button"
                                                            style="width: 45px; height: 45px; padding: 0"
                                                            class="btn btn-outline-success rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#invoice-payment-modal-{{$invoice->id}}">

                                                        <i class="fe-dollar-sign" style="font-size: 20px"></i>
                                                    </button>

                                                    <button
                                                        style="width: 45px; height: 45px; padding: 0"
                                                        type="button"
                                                        class="btn btn-outline-warning rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#invoice-expense-modal-{{$invoice->id}}">
                                                        <i class="fe-minus-square" style="font-size: 20px"></i>
                                                    </button>

                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{$invoices->links('pagination::bootstrap-5')}}
                                </div>
                            </div>
                        </div>
                    </div>



{{--                    edit invoice Modal  --}}

                    <div>
                      @foreach($invoices as $invoice)
                          @include('partials.adminInvoiceEditModal')
                      @endforeach

                      @foreach($invoices as $invoice)
                          @include('partials.invoiceSmSForm')
                      @endforeach

                      @foreach($invoices as $invoice)
                          @include('partials.adminInvoicePaymentModal')
                          @include('partials.invoiceAddExpenseModal')
                      @endforeach
                    </div>

                </div>

            </div>
            </div>

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>


@include('partials.rightbar')


@include('partials.layoutEnd')

<!-- Include the diff-match-patch library -->

