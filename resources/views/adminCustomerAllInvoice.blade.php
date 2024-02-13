@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-2">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="customer-profile-sidebar">
                                        <ul style="padding: 0px">
                                            <li>
                                                <a href="{{route('customer-profile',[$customer_id])}}"><i class='bx bx-user-circle me-1' ></i> Profile</a>
                                            </li>
                                            <li>
                                                <a href="{{route('view-all-query',[$customer_id])}}"><i class='bx bx-notepad me-1'></i>Lead/Query</a>
                                            </li>
                                            <li>
                                                <a href="{{route('customer-all-quotations',[$customer_id])}}"><i class='bx bxs-file-pdf me-1'></i>All Quotations</a>
                                            </li>
                                            <li class="active-2">
                                                <a href="{{route('admin-customer-all-invoice',[$customer_id])}}"><i class='bx bx-food-menu me-1'></i> Invoices</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin-customer-all-payment',[$customer_id])}}"><i class='bx bxs-badge-dollar me-1'></i> payments</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin-customer-notes',[$customer_id])}}"><i class='bx bx-note me-1'></i>Notes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <div class="card">
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary m-3">
                                        <a class="text-white" href="{{route('admin-view-generate-new-invoice',[$customer_id])}}">Add Invoice<i class='bx bx-plus'></i></a>
                                    </button>
                                    <h3 class="m-3">All Invoice</h3>
                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr class="text-left">
                                            <th>SL</th>
                                            <th>Created At</th>
                                            <th>Invoice No</th>
                                            <th>Product details</th>
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
                                                    {{$invoice->created_at->format('m/d/Y')}}<br>
                                                    {{$invoice->created_at->format('h:i:s A')}}
                                                </td>
                                                <td class="align-middle">
                                                    {{$invoice->invoice_no}}
                                                </td>
                                                <td class="text-left align-middle">
                                                   <div style="height: 200px; overflow: scroll;">
                                                       @php
                                                           $products = json_decode($invoice->products, true);
                                                       @endphp
                                                       @foreach($products as $product)
                                                           @php
                                                               $priceWithVat = $product['unit_price'] + $product['unit_price'] * $invoice->vat_tax / 100;
                                                           $totalPrice = $priceWithVat * $product['quantity'];
                                                           @endphp
                                                           <strong style="font-size: 13px">Name:-</strong>{{$product['product_name']}}<br>
                                                           <strong style="font-size: 13px">Code:-</strong>{{$product['product_code']}}<br>
                                                           <strong style="font-size: 13px">Unite Price:-</strong>{{$product['unit_price']}}.tk<br>
                                                           <hr>
                                                       @endforeach
                                                   </div>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="invoice-products" style="height: 100px;overflow: scroll">
                                                        @php
                                                            $totalInvoicePrice = 0;

                                                            foreach ($products as $product) {
                                                                if (!empty($invoice->vat_tax)) {
                                                                    $totalInvoice = $product['unit_price'] + $product['unit_price'] * $invoice->vat_tax / 100;
                                                                    $totalInvoicePrice += $totalInvoice * $product['quantity'];
                                                                } else {
                                                                    $totalInvoicePrice += $product['unit_price'] * $product['quantity'] + floatval($invoice->delivery_charge);
                                                                }
                                                            }
                                                        @endphp

                                                        total: {{ $totalInvoicePrice }}<br>
                                                        paid: {{ $invoice->payments->sum('amount') }}<br>
                                                        Due: {{ $totalInvoicePrice - $invoice->payments->sum('amount') }}
                                                    </div>
                                                </td>
                                                <td class="align-middle text-left">
                                                    <div class="mb-1">
                                                        <a class="text-white btn btn-sm btn-primary" href="{{route('admin-view-edit-invoice',[$customer_id,$invoice->id])}}">
                                                            Edit
                                                        </a>
                                                        <a  onclick="return confirm('Are you sure you want to delete this quotation?')" class="text-white btn btn-sm btn-danger" href="{{route('admin-delete-invoice',[$customer_id,$invoice->id])}}">
                                                            delete
                                                        </a>
                                                        <a class="text-white btn btn-sm btn-primary" href="{{route('admin-view-invoice-pdf',[$customer_id,$invoice->id])}}">
                                                            View
                                                        </a>
                                                    </div>
                                                    <div class="mb-1">
                                                        <a class="text-white btn btn-sm btn-primary" href="{{route('admin-download-invoice',[$invoice->id])}}">
                                                           Download
                                                        </a>
                                                        <a class="text-white btn btn-sm btn-primary" href="{{route('admin-invoice-mail',[$invoice->id])}}">
                                                            Send Mail
                                                        </a>
                                                        <a href="{{route('admin-challan',[$invoice->id])}}" class="text-white btn btn-sm btn-primary">
                                                            Challan
                                                        </a>

                                                    </div>
                                                    <div class="mb-1">
                                                        <a class="text-white btn btn-sm btn-primary" href="{{route('admin-money-receipt',[$invoice->id])}}">
                                                            Money R.
                                                        </a>
                                                        <a class="text-white btn btn-sm btn-success" href="{{route('admin-show-add-payment-from-all-invoice',[$invoice->id])}}">Add Payment</a>
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
