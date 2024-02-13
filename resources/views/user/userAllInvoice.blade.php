@include('partials.layoutHead')

<div id="wrapper">

    @include('user.partials.navbar')
    @include('user.partials.sidebar')


    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                {{--============ Filter Form--}}
                                <form action="{{request()->routeIs('user-all-invoice')? route('user-all-invoice') :route('admin-all-invoice')}}" method="GET">
                                    @csrf
                                    <div class="row">

                                        <div class="col-12" >
                                            <div class="d-flex gap-2 align-items-center justify-content-start">
                                                <div class="mb-2 ">
                                                    <label for="example-date" class="form-label">Date</label>
                                                    <input class="form-control" id="example-date" type="date" name="date-form">
                                                </div>
                                                <div class="mb-2 ">
                                                    <label for="example-date" class="form-label">Date</label>
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
                            <div class="col-4 " >
                                <div class="d-flex justify-content-end align-items-end">
                                    <div>
                                        <a class=" btn btn-success" href="{{route('update-all-invoice-status')}}">Update All Status</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h3 style="font-size: 25px" class="badge badge-outline-secondary">
                                    Invoices:
                                </h3>
                                <hr>
                            </div>
                            <div class="col-8">
                                <div class="d-flex gap-2 justify-content-end">
                                    <div class="p-2"
                                         style="border-left: 3px solid #000; background: rgba(241, 196, 15, 0.3); width: 200px">

                                        <h4>{{count($invoices)}}</h4>
                                        <h5>Total Invoice</h5>
                                    </div>
                                    <div class="p-2"
                                         style="border-left: 3px solid #000; background: rgba(13,106,244,0.3);  width: 200px"
                                    >
                                        <h4>$ {{floor($totalInvoiceValue)}}</h4>
                                        <h5>Total Invoice Value</h5>
                                    </div>
                                    <div class="p-2"
                                         style="border-left: 3px solid #000; background: rgba(124,252,0,0.3);  width: 200px"
                                    >
                                        <h4>$ {{$totalPaymentValue}}</h4>
                                        <h5>Total Payment</h5>
                                    </div>
                                    <div class="p-2"
                                         style="border-left: 3px solid #000; background: rgba(0,128,0,0.3);  width: 200px"
                                    >
                                        <h4>$15151</h4>
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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoices as $invoice)
                                        <tr
                                            @if($invoice->status == 'Paid')
                                                style="

                                                    background-image: url('{{asset('images/paid.jpg')}}');
                                                    background-repeat: no-repeat;
                                                    background-position: center center;
                                                    background-size: 20%;
                                                "
                                            @endif
                                        >
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
                                                {{$invoice->status}}
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex gap-1">
                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       class="btn btn-outline-primary rounded-circle view" target="_blank"
                                                       href="{{request()->routeIs('user-all-invoice') ? route('view-invoice-pdf',[$invoice->customer_id,$invoice->id]) : route('admin-view-invoice-pdf',[$invoice->customer_id,$invoice->id])}}">
                                                        <i class="fe-eye" style="font-size: 20px; margin-top: 10px"></i>
                                                    </a>

                                                    <button style="width: 45px; height: 45px; padding: 0" type="button"
                                                            class="btn btn-outline-primary rounded-circle edit"
                                                            data-bs-toggle="modal" data-bs-target="#invoice-edit-modal-{{$invoice->id}}">
                                                        <i class="fe-edit-1" style="font-size: 20px; margin-top: 10px"></i>
                                                    </button>

                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       onclick="return confirm('Are you sure you want to delete this Invoice?')"
                                                       class="btn btn-outline-danger rounded-circle delete"
                                                       href="{{request()->routeIs('user-all-invoice') ? route('user-delete-invoice',[$invoice->customer_id, $invoice->id]) :route('admin-delete-invoice', [$invoice->customer_id, $invoice->id])}}">
                                                        <i class="fe-trash-2" style="font-size: 20px; margin-top: 10px"></i>
                                                    </a>
                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       class="btn btn-outline-secondary rounded-circle download"
                                                       href="{{request()->routeIs('user-all-invoice') ? route('user-download-invoice',[$invoice->id]) : route('admin-download-invoice',[$invoice->id])}}">
                                                        <i class="fe-download" style="font-size: 20px; margin-top: 10px"></i>
                                                    </a>

                                                </div>

                                                <div class="d-flex gap-1 mt-1">

                                                    <button
                                                        class="btn btn-outline-primary rounded-circle sms-sent"
                                                        style="width: 45px; height: 45px; padding: 0"
                                                        type="button" data-bs-toggle="modal" data-bs-target="#invice-sms-modal-{{$invoice->id}}">
                                                        <i class="fe-message-square" style="font-size: 20px; margin-top: 10px"></i>
                                                    </button>

                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       class="btn btn-outline-primary rounded-circle sent-mail"
                                                       href="{{request()->routeIs('user-all-invoice') ? route('invoice-mail',[$invoice->id]) : route('admin-invoice-mail',[$invoice->id])}}">
                                                        <i class="fe-send" style="font-size: 20px; margin-top: 10px"></i>
                                                    </a>
                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       class="btn btn-outline-primary rounded-circle challan" target="_blank"
                                                       href="{{request()->routeIs('user-all-invoice') ? route('challan',[$invoice->id]) :route('admin-challan',[$invoice->id])}}">
                                                        <i class="fe-file-text" style="font-size: 20px; margin-top: 10px"></i>
                                                    </a>
                                                    <a style="width: 45px; height: 45px; padding: 0"
                                                       class="btn btn-outline-success rounded-circle money-receipt" target="_blank"
                                                       href="{{request()->routeIs('user-all-invoice')? route('money-receipt',[$invoice->id]) :route('admin-money-receipt',[$invoice->id])}}">
                                                        <i class="fe-clipboard" style="font-size: 20px; margin-top: 10px"></i>
                                                    </a>
                                                </div>

                                                <div class="d-flex gap-1 mt-1">

                                                    <button type="button"
                                                            style="width: 45px; height: 45px; padding: 0"
                                                            class="btn btn-outline-success rounded-circle payment"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#invoice-payment-modal-{{$invoice->id}}">

                                                        <i class="fe-dollar-sign" style="font-size: 20px; margin-top: 10px"></i>
                                                    </button>

                                                    <button
                                                        style="width: 45px; height: 45px; padding: 0"
                                                        type="button"
                                                        class="btn btn-outline-warning rounded-circle expense"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#invoice-expense-modal-{{$invoice->id}}">
                                                        <i class="fe-minus-square" style="font-size: 20px; margin-top: 10px"></i>
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


@include('user.partials.rightbar')


@include('partials.layoutEnd')

<!-- Include the diff-match-patch library -->

<script type="text/javascript">

    // ======== Quotation product details =======
    document.addEventListener('DOMContentLoaded', function () {
        let addButtons = document.querySelectorAll('.edit_invoice_profile_add-product');

        addButtons.forEach(function (addButton) {
            addButton.addEventListener('click', function () {
                let productContainer = this.previousElementSibling; // Assuming the button is placed just before the product details container

                let addProductDiv = document.createElement('div');
                addProductDiv.classList.add('edit-invoice-product-details-container');

                addProductDiv.innerHTML = `
                                                            <div class="mb-3">
                                                                <!-- Add remove button -->
                                                                <button class="query_quot_remove_product btn btn-danger">Remove</button>
                                                            </div>

                                                            <div class="row">
                                                <div class="mb-3 col-4">
                                                    <label class="form-label">Product Name</label>
                                                    <input type="text" name="product_name[]" class="form-control" >
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-default-company">Product Code</label>
                                                    <input type="text" name="product_code[]" class="form-control" >
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-default-email">Quantity</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" name="quantity[]" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-default-phone">Unit Price</label>
                                                    <input type="text" name="unit_price[]" class="form-control phone-mask">
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label for="defaultSelect" class="form-label">Select Unit</label>
                                                    <select class="form-control" name="unit[]" required="">
                                                        @foreach($unites as $unit)
                <option value="{{$unit->unit}}">{{$unit->unit}}</option>
                                                        @endforeach
                </select>
            </div>
            <div class="mb-3 col-4">
                <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
                <input type="text" name="costing[]" class="form-control phone-mask">
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-default-message">Product Description</label>
                                                    <textarea name="product_description[]" class="form-control"> </textarea>
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-default-phone">Product Discount</label>
                                                    <input type="number" name="product_discount[]" class="form-control phone-mask">
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-default-phone">Product Source</label>
                                                    <input type="text" name="product_source[]" class="form-control phone-mask">
                                                </div>
                                            </div>
                                                    <!-- ... (rest of your product details HTML) ... -->
                                                    <hr class="m-4">
`;

                productContainer.appendChild(addProductDiv);

                let removeButtons = document.getElementsByClassName('query_quot_remove_product');
                for (let i = 0; i < removeButtons.length; i++) {
                    removeButtons[i].addEventListener('click', function () {
                        // Remove the parent div when remove button is clicked
                        this.parentNode.parentNode.remove();
                    });
                }
            });
        });
    });

</script>


