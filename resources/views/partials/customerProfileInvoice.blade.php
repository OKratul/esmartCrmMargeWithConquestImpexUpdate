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
                    <div style="height: 100px; overflow: auto;">
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
                    <div class="invoice-products">
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

                        total: {{ $totalInvoicePrice }} /-<br>
                        paid: {{ $invoice->payments->sum('amount') }} /-<br>
                        Due: {{ $totalInvoicePrice - $invoice->payments->sum('amount') }} /-
                    </div>
                </td>
                <td class="align-middle text-left">
                    <div class="">
                        <div class="btn-group mb-2 dropstart">
                            <button type="button" class="btn btn-info waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fe-more-vertical-"></i>
                            </button>
                            <div class="dropdown-menu p-2 border" style="">
                               @if(request()->routeIs('user-customer-profile'))
                                    <div class="mb-2">
                                        <a class="btn btn-soft-primary waves-effect waves-light"
                                           target="_blank"
                                           href="{{route('view-invoice-pdf',[$id,$invoice->id])}}">
                                            View
                                        </a>
                                        <button type="button"
                                                class="btn btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#invoice-edit-modal-{{$invoice->id}}">
                                           Edit
                                        </button>
                                        <a
                                            onclick="return confirm('Are you sure you want to delete this quotation?')"
                                            class="btn btn-soft-danger waves-effect waves-light"
                                            href="{{route('user-delete-invoice',[$id,$invoice->id])}}">
                                            Delete
                                        </a>
                                    </div>

                                    <div class="mb-2">
                                        <a class="text-black btn btn-soft-info btn-primary"
                                           href="{{route('invoice-mail',[$invoice->id])}}">
                                            <i class="fe-send"></i>  Mail                                                                        </a>
                                        <a href="{{route('challan',[$invoice->id])}}" target="_blank" class="text-black btn btn-soft-secondary btn-primary">
                                            <i class="fas fa-file-alt"></i>Challan
                                        </a>
                                        <a class="text-black btn btn-soft-secondary btn-primary"
                                           target="_blank" href="{{route('money-receipt',[$invoice->id])}}">
                                            <i class="fas fa-receipt"></i> Receipt
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <button type="button"
                                                style="width: 45px; height: 45px; padding: 0"
                                                class="btn btn-outline-success rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                data-bs-toggle="modal"
                                                data-bs-target="#invoice-payment-modal-{{$invoice->id}}">

                                            <i class="fe-dollar-sign" style="font-size: 20px"></i>
                                        </button>
                                    </div>

                                @else
                                    <div class="mb-2">
                                        <a class="btn btn-soft-primary waves-effect waves-light" target="_blank" href="{{route('admin-view-invoice-pdf',[$id,$invoice->id])}}">
                                            View
                                        </a>
                                        <a class="btn btn-soft-warning waves-effect waves-light" href="{{route('admin-view-edit-invoice',[$id,$invoice->id])}}">
                                            Edit
                                        </a>
                                        <a  onclick="return confirm('Are you sure you want to delete this quotation?')" class="btn btn-soft-danger waves-effect waves-light" href="{{route('admin-delete-invoice',[$id,$invoice->id])}}">
                                            Delete
                                        </a>
                                    </div>

                                    <div class="mb-2">
                                        <a class="text-black btn btn-soft-info btn-primary" href="{{route('admin-invoice-mail',[$invoice->id])}}">
                                            <i class="fe-send"></i>  Mail                                                                        </a>
                                        <a href="{{route('admin-challan',[$invoice->id])}}" target="_blank" class="text-black btn btn-soft-secondary btn-primary">
                                            <i class="fas fa-file-alt"></i>Challan
                                        </a>
                                        <a class="text-black btn btn-soft-secondary btn-primary" target="_blank" href="{{route('admin-money-receipt',[$invoice->id])}}">
                                            <i class="fas fa-receipt"></i> Receipt
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <a class="text-black btn btn-sm btn-success" href="{{route('admin-show-add-payment-from-all-invoice',[$invoice->id])}}">
                                            <i class="fe-dollar-sign"></i>Payment
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <a style="margin-left: 10px" class="text-white btn btn-soft-dark btn-primary"
                               href="{{request()->routeIs('user-customer-profile')? route('user-download-invoice',[$invoice->id]) : route('admin-download-invoice',[$invoice->id])}}">
                                <i class="ti-download"></i>
                            </a>
                        </div>

                    </div>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@foreach($invoices as $invoice)
    <div>
        @include('partials.adminInvoiceEditModal')

        @include('partials.adminInvoicePaymentModal')
        @include('partials.invoiceAddExpenseModal')
    </div>
@endforeach


<script type="text/javascript">

    // ======== Quotation product details =======
    document.addEventListener('DOMContentLoaded', function () {
        let addButtons = document.querySelectorAll('.edit_invoice_profile_add-product');

        addButtons.forEach(function (addButton) {
            addButton.addEventListener('click', function () {
                let productContainer = this.previousElementSibling; // Assuming the button is placed just before the product details container

                let addProductDiv = document.createElement('div');
                addProductDiv.classList.add('edit_invoice_profile_product_details');

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
                                                    <textarea name="product_description[]" class="form-control"></textarea>
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
