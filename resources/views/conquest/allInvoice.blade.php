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
            @include('error')
            @include('success')
            <!-- Start Content-->
            <div class="container-fluid">

                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3> <i class="fe-users"></i> Invoices</h3>
                            </div>
                            <div>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#add-invoice-modal">
                                    Add Invoice <i class="fe-user-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Date</th>
                                    <th>Invoice No</th>
                                    <th>Customer Name</th>
                                    <th>Product Name</th>
                                    <th>Paid Amount</th>
                                    <th>Due Amount</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $index=>$invoice)
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{$invoice->created_at->format('dM Y ')}}</td>
                                        <td>#{{$invoice->invoice_number}}</td>
                                        <td>
                                            @if(!empty($invoice->customers))
                                                {{$invoice->customers['name']}}
                                            @endif
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
                                           $ {{$invoice->paid ??'0'}}
                                        </td>
                                        <td>
                                            $ {{$invoice->due ?? '0'}}
                                        </td>
                                        <td>
                                            $ {{$invoice->all_total_price}}
                                        </td>

                                        <td>
                                            <a target="_blank" class="btn btn-sm btn-outline-primary mb-2"
                                               href="{{route('conquest-view-invoice',[$invoice->id])}}">
                                                View
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-info mb-2" data-bs-toggle="modal"
                                                    data-bs-target="#edit-invoice-modal-{{$invoice->id}}">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-success mb-2" data-bs-toggle="modal"
                                                    data-bs-target="#add-payment-modal-{{$invoice->id}}">
                                                add payment
                                            </button>
                                            <br>
                                            <a onclick="return confirm('Are you sure you want to delete this invoice?')"
                                               href="{{ route('conquest-delete-invoice', [$invoice->id]) }}"
                                               class="btn btn-sm btn-outline-danger mb-2">
                                                Delete
                                            </a>
                                            <a target="_blank"
                                                href="{{route('conquest-challan',[$invoice->id])}}" class="btn btn-sm btn-outline-primary mb-2">
                                                Challan
                                            </a>

                                        </td>
                                    </tr>

{{--                                    Add Payment Modal--}}

                                    <div class="modal fade" id="add-payment-modal-{{$invoice->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Add Payment</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('conquest-add-payment-invoice') }}" method="POST">
                                                        @csrf
                                                        <div class="row" >
                                                            <div class="mb-2 col-6">
                                                                <label for="simpleinput" class="form-label">Invoice No</label>
                                                                <input value="{{$invoice->invoice_number}}" name="invoice_no" type="text" id="simpleinput" class="form-control">
                                                            </div>
                                                            <div class="mb-2 col-6">
                                                                 <label for="simpleinput" class="form-label">Pay Amount*</label>
                                                                 <input value="00" name="pay_amount" type="text" id="simpleinput" class="form-control">
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
                                                                    <option value="Redex">Redex</option>
                                                                </select>
                                                            </div>
                                                            @php
                                                                $accounts = \App\Models\conquest\ConquestAccount::all();
                                                            @endphp
                                                            <div class="mb-2 col-6">
                                                                <label for="simpleinput" class="form-label">Select Account*</label>
                                                                <select required name="account_id" class="form-select" aria-label="Default select example">
                                                                    <option> </option>
                                                                    @foreach($accounts as $account)
                                                                        <option value="{{$account->id}}">{{$account->account_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-2 col-6">
                                                                <label for="simpleinput" class="form-label">Payment Date*</label>
                                                                <input required name="date" type="date" id="simpleinput" class="form-control">
                                                            </div>
                                                        </div>
                                                        <!-- Other input fields... -->

                                                        <div class="text-center mt-2">
                                                            <button type="submit" class="btn btn-success">
                                                                Add Payment
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

{{--                                    Invoice Edit Modal--}}

                                    <div class="modal fade" id="edit-invoice-modal-{{$invoice->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Make Invoice</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('conquest-edit-invoice',[$invoice->id]) }}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="mb-2 col-12">
                                                                <label for="simpleinput" class="form-label">Select Customer*</label>
                                                                <select name="customer" class="form-select" aria-label="Default select example">
                                                                    <option> </option>
                                                                    @foreach($customers as $customer)
                                                                        <option {{$invoice->customers['id'] == $customer->id ? 'selected' : ''}} value="{{$customer->id}}">{{$customer->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row" >
                                                            <div class="col-6" style="border-right: 1px solid #ccc">
                                                                <div class="row add-product-div">

                                                                    @php
                                                                        $productId = explode('+', $invoice->product_id);
                                                                        $quantity = explode('+', $invoice->quantity);
                                                                        $unitPrice = explode('+', $invoice->unit_price);
                                                                        $productCodes = [];

                                                                        foreach ($productId as $i => $productIdItem) {
                                                                            $productCodes[] = [
                                                                                'productCode' => $productIdItem,
                                                                                'quantity' => $quantity[$i],
                                                                                'unitPrice' => $unitPrice[$i],
                                                                            ];
                                                                        }
                                                                    @endphp

                                                                    <div>
                                                                        @foreach($productCodes as $productCode)
                                                                            <div class="mb-2 col-12">
                                                                                <label for="simpleinput" class="form-label">Select Product*</label>
                                                                                <select name="product_name[]" class="form-select" aria-label="Default select example">
                                                                                    <option> </option>
                                                                                    @foreach($products as $product)
                                                                                        <option {{ $productCode['productCode'] == $product->product_code ? 'selected' : '' }} value="{{ $product->product_code }}">
                                                                                            {{ $product->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-2 col-12">
                                                                                <label for="simpleinput" class="form-label">Quantity</label>
                                                                                <input value="{{$productCode['quantity']}}" name="quantity[]" type="text" id="simpleinput" class="form-control">
                                                                            </div>
                                                                            <div class="mb-2 col-12">
                                                                                <label for="simpleinput" class="form-label">Unit Price</label>
                                                                                <input value="{{$productCode['unitPrice']}}" name="unit_price[]" type="text" id="simpleinput" class="form-control">
                                                                            </div>
                                                                            <hr>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="btn btn-sm btn-soft-dark add-more-make-invoice" id="add-more-make-invoice">Add More</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="row">
                                                                    <div class="mb-2 col-12">
                                                                        <label for="simpleinput" class="form-label">Delivery Charge</label>
                                                                        <input value="{{$invoice->delivery_charge}}" name="delivery_charge" type="text" id="simpleinput" class="form-control">
                                                                    </div>
                                                                    <div class="mb-2 col-12">
                                                                        <label for="simpleinput" class="form-label">Discount Amount</label>
                                                                        <input value="{{$invoice->discount}}" name="discount_amount" type="text" id="simpleinput" class="form-control">
                                                                    </div>
                                                                    <div class="mb-2 col-12">
                                                                        <label for="simpleinput" class="form-label">Paid Amount</label>
                                                                        <input value="{{$invoice->paid}}" name="paid_amount" type="text" id="simpleinput" class="form-control">
                                                                    </div>
                                                                    <div class="mb-2 col-12">
                                                                        <label for="simpleinput" class="form-label">Date</label>
                                                                        <input value="{{$invoice->date}}" name="date" type="date" required id="simpleinput" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Other input fields... -->

                                                        <div class="text-center mt-2">
                                                            <button type="submit" class="btn btn-primary">
                                                                Submit <i class="fe-user-plus"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{$invoices->links('pagination::bootstrap-5')}}
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

    {{-- Make Invoice Modal --}}
    <div class="modal fade" id="add-invoice-modal" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Make Invoice</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('conquest-make-invoice') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-2 col-12">
                                <label for="simpleinput" class="form-label">Select Customer*</label>
                                <select name="customer" class="form-select" aria-label="Default select example">
                                    <option> </option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-6" style="border-right: 1px solid #ccc">
                                <div class="row add-product-make-invoice">
                                    <div>
                                        <div class="mb-2 col-12" >
                                            <label for="simpleinput" class="form-label">Select Product*</label>
                                            <select name="product_name[]" class="form-select" aria-label="Default select example">
                                                <option> </option>
                                                @foreach($products as $product)
                                                    <option value="{{$product->product_code}}">{{$product->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-2 col-12">
                                            <label for="simpleinput" class="form-label">Quantity</label>
                                            <input multiple name="quantity[]" type="text" id="simpleinput" class="form-control">
                                        </div>
                                        <div class="mb-2 col-12">
                                            <label for="simpleinput" class="form-label">Unit Price</label>
                                            <input multiple name="unit_price[]" type="text" id="simpleinput" class="form-control">
                                        </div>
                                    </div>
                                </div>
                               <div>
                                   <button type="button" class="btn btn-sm btn-soft-dark" id="add-more-make-invoice">Add More</button>
                               </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="mb-2 col-12">
                                        <label for="simpleinput" class="form-label">Delivery Charge</label>
                                        <input name="delivery_charge" type="text" id="simpleinput" class="form-control">
                                    </div>
                                    <div class="mb-2 col-12">
                                        <label for="simpleinput" class="form-label">Discount Amount</label>
                                        <input name="discount_amount" type="text" id="simpleinput" class="form-control">
                                    </div>
                                    <div class="mb-2 col-12">
                                        <label for="simpleinput" class="form-label">Paid Amount</label>
                                        <input name="paid_amount" type="text" id="simpleinput" class="form-control">
                                    </div>
                                    <div class="mb-2 col-12">
                                        <label for="simpleinput" class="form-label">Date*</label>
                                        <input name="date" type="date" required id="simpleinput" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Other input fields... -->

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
<!-- END wrapper -->

<!-- Right Sidebar -->

@include('conquest.user.partials.rightbar')

<!-- Scripts -->
@include('conquest.user.partials.layoutScripts')

<script type="text/javascript">
    // ======== Quotation product details =======

    let addButton = document.getElementById('add-more');

    addButton.addEventListener('click', function () {
        let productContainer = document.querySelector('.add-product-div')

        let addProductDiv = document.createElement('div');

        addProductDiv.innerHTML = `
                                    <div class="mb-2 col-12">
                                        <!-- Add remove button -->
                                        <button class="remove_product btn btn-danger">Remove</button>
                                    </div>
                                    <div class="mb-2 col-12">
                                        <label for="simpleinput" class="form-label">Select Product*</label>
                                        <select name="product_name[]" class="form-select" aria-label="Default select example">
                                            <option> </option>
                                            @foreach($products as $product)
                                <option value="{{$product->product_code}}">{{$product->name}}</option>
                                            @endforeach
                                </select>
                            </div>
                            <div class="mb-2 col-12">
                                <label for="simpleinput" class="form-label">Quantity</label>
                                <input multiple name="quantity[]" type="text" id="simpleinput" class="form-control">
                            </div>
                            <div class="mb-2 col-12">
                                <label for="simpleinput" class="form-label">Unit Price</label>
                                <input multiple name="unit_price[]" type="text" id="simpleinput" class="form-control">
                            </div>
                            <hr>
                        `;

        productContainer.appendChild(addProductDiv);

        // Attach the event listener to the newly created remove button
        let removeButton = addProductDiv.querySelector('.remove_product');
        removeButton.addEventListener('click', function () {
            // Remove the parent div when the remove button is clicked
            this.parentNode.parentNode.remove();
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        let addButtons = document.querySelectorAll('.add-more-make-invoice');

        addButtons.forEach(function (addButton) {
            addButton.addEventListener('click', function () {
                let productContainer = this.closest('.modal-content').querySelector('.add-product-make-invoice');

                let addProductDiv = document.createElement('div');

                addProductDiv.innerHTML = `
                <div class="mb-2 col-12">
                    <!-- Add remove button -->
                    <button class="remove_product_make_invoice btn btn-danger">Remove</button>
                </div>
                <div class="mb-2 col-12">
                    <label for="simpleinput" class="form-label">Select Product*</label>
                    <select name="product_name[]" class="form-select" aria-label="Default select example">
                        <option> </option>
                        @foreach($products as $product)
                <option value="{{$product->product_code}}">{{$product->name}}</option>
                        @endforeach
                </select>
            </div>
            <div class="mb-2 col-12">
                <label for="simpleinput" class="form-label">Quantity</label>
                <input multiple name="quantity[]" type="text" class="form-control">
            </div>
            <div class="mb-2 col-12">
                <label for="simpleinput" class="form-label">Unit Price</label>
                <input multiple name="unit_price[]" type="text" class="form-control">
            </div>
            <hr>
`;

                productContainer.appendChild(addProductDiv);

                // Attach the event listener to the newly created remove button
                let removeButton = addProductDiv.querySelector('.remove_product_make_invoice');
                removeButton.addEventListener('click', function () {
                    // Remove the parent div when the remove button is clicked
                    this.parentNode.parentNode.remove();
                });
            });
        });
    });
</script>




</body>
