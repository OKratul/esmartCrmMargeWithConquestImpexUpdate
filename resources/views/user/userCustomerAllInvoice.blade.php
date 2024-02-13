@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="customer-profile-sidebar">
                                        <ul>
                                            <li>
                                                <a href="{{route('user-customer-profile',[$customer_id])}}"><i class='bx bx-user-circle me-1' ></i> Profile</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-query-add-form-profile',[$customer_id])}}"><i class='bx bx-notepad me-1'></i>Lead/Qurery</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-customer-all-quotations',[$customer_id])}}"><i class='bx bxs-file-pdf me-1'></i>All Quotations</a>
                                            </li>
                                            <li class="active-2">
                                                <a href="{{route('all-invoice',[$customer_id])}}"><i class='bx bx-food-menu me-1'></i> Invoices</a>
                                            </li>
                                            <li>
                                                <a href="{{route('customer-all-payment',[$customer_id])}}"><i class='bx bxs-badge-dollar me-1'></i> payments</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-customer-notes',[$customer_id])}}"><i class='bx bx-note me-1'></i>Notes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="card">
                                <div class="d-flex justify-content-between">
                                     <a class="btn btn-primary m-3 text-white" href="{{route('view-generate-new-invoice',[$customer_id])}}">Add Invoice<i class='bx bx-plus'></i></a>
                                    <h3 class="m-3">All Invoice</h3>
                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr class="text-left">
                                            <th>SL</th>
                                            <th>Invoice No</th>
                                            <th>Product details</th>
                                            <th>Warranty</th>
                                            <th>Payment Type</th>
                                            <th>Total Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach($invoices as $key=>$invoice)
                                                <tr>
                                                    <td class="align-middle">
                                                        {{$loop->iteration}}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{$invoice->invoice_no}}
                                                    </td>
                                                    <td class="text-left align-middle">
                                                        @php
                                                            $products = json_decode($invoice->products, true)
                                                        @endphp
                                                        @foreach($products as $product)
                                                            <strong style="font-size: 13px">Name:-</strong>{{$product['product_name']}}<br>
                                                            <strong style="font-size: 13px">Code:-</strong>{{$product['product_code']}}<br>
                                                            <strong style="font-size: 13px">Unite Price:-</strong>{{$product['unit_price']}}.tk<br>
                                                            <hr>
                                                        @endforeach
                                                    </td>
                                                    <td class="align-middle">
                                                        {{$invoice->warranty}}
                                                    </td>
                                                    <td class="align-middle">
                                                      {{$invoice->payment_type}}
                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td class="align-middle text-left">
                                                        <div class="mb-1">

                                                                <a class="text-white btn btn-sm btn-primary" href="{{route('user-view-edit-invoice',[$customer_id,$invoice->id])}}">
                                                                    Edit
                                                                </a>


                                                                <a onclick="return confirm('Are you sure you want to delete this quotation?')" class="text-white btn btn-sm btn-danger" href="{{route('user-delete-invoice',[$customer_id,$invoice->id])}}">delete</a>


                                                                <a class="text-white btn btn-sm btn-primary" href="{{route('view-invoice-pdf',[$customer_id,$invoice->id])}}">View</a>

                                                        </div>
                                                        <div class="mb-1">

                                                                <a class="text-white btn btn-sm btn-primary" href="{{route('user-download-invoice',[$invoice->id])}}">
                                                                    Download
                                                                </a>


                                                                <a class="text-white btn btn-sm btn-primary" href="{{route('invoice-mail',[$invoice->id])}}">Send Mail</a>


                                                        </div>
                                                        <div class="mb-1">

                                                                <a class="text-white btn btn-sm btn-primary" href="{{route('money-receipt',[$invoice->id])}}">Money R.</a>

                                                                <a href="{{route('challan',[$invoice->id])}}" class="text-white btn btn-sm btn-primary">Challan</a>
                                                            @if(\Illuminate\Support\Facades\Auth::user()->user_role == 'Accountant')
                                                                <a class="text-white btn btn-sm btn-success" href="{{route('show-add-payment-from-all-invoice',[$invoice->id])}}">Add Payment</a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>


@include('partials.layoutEnd')
