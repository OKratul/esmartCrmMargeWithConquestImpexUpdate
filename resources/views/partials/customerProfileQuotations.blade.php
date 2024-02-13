<div class="table-responsive">
    <table class="table mb-0">
        <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Quotation No</th>
            <th>Product Details</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if(empty($quotations))
            <tr>
                <td colspan="6" class="text-center">
                    ------ No Quotation Found ------
                </td>
            </tr>
        @else
            @foreach($quotations as $index => $quotation)
                <tr class="{{$quotation->status == 'Sent' ? 'table-success' : ''}}">
                    <td>
                        {{$loop->iteration}}
                    </td>
                    <td>
                        {{$quotation->created_at->format('d-M Y')}}<br>
                        {{$quotation->created_at->format('H:i a')}}
                    </td>
                    <td>
                        {{$quotation->quotation_number}}
                    </td>
                    <td>
                        <div style="height:150px; overflow: auto;scrollbar-width: thin;scrollbar-color: #999 #eee">
                            @php
                                $products = json_decode($quotation->products, true);
                            @endphp
                            @foreach($products as $product)
                                <p style="word-wrap: break-word;"><strong>Name:</strong>{{$product['product_name']}}</p>
                                <p><strong>Code:-</strong>{{$product['product_code']}}</p>
                                <p><strong>Unit Price:-</strong>{{$product['unit_price']}}</p>
                                {{--                                                                                                @if(!empty($product['product_image']))--}}
                                {{--                                                                                                    <img src="{{asset('images/quotationProduct/'.$product['product_image'])}}">--}}
                                {{--                                                                                                @endif--}}
                                <hr>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        {{$quotation->status}}
                    </td>
                    <td class="position-relative">
                        <div class="btn-group mb-2 dropstart">
                            <button type="button" class="btn text-black btn-soft-blue waves-effect waves-light" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fe-more-vertical-"></i>
                            </button>
                            <div class="dropdown-menu p-1" style="">
                                <a  target="_blank"
                                    href="{{request()->routeIs('user-customer-profile')? route('view-quotation-pdf',[$id,$quotation->id]) :route('admin-view-quotation-pdf',[$id,$quotation->id])}}"
                                    class="btn btn-soft-primary text-black waves-effect waves-light mb-2">
                                    View
                                </a>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-quotation-form-{{$quotation->id}}">
                                    Edit
                                </button>
                                <a onclick="return confirm('Are you sure you want to delete this quotation?')"
                                   href="{{request()->routeIs('user-customer-profile')? route('user-delete-quotation',[$id,$quotation->id]):route('delete-quotation',[$id,$quotation->id])}}"
                                   class="btn btn-soft-danger waves-effect text-black waves-light mb-2">
                                    Delete
                                </a>
                                <a href="{{request()->routeIs('user-customer-profile')? route('sent-quotation-mail',[$id,$quotation->id]) :route('admin-sent-quotation-mail',[$id,$quotation->id])}}"
                                   class="text-black btn btn-soft-success waves-effect waves-light mb-2">
                                    <i class="fe-send"></i>Mail
                                </a>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#invoice-from-quotation-{{$quotation->id}}">
                                    Make Invoice
                                </button>
                            </div>
                            <a
                                href="{{route('generate-pdf-download',[$id,$quotation->id])}}"
                                class="btn text-black btn-soft-dark waves-effect waves-light mb-2">
                                <i class="ti-download"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

{{--=========Quotation Edit Table===========--}}

@include('partials.customerProfileEditQuotation')

{{--========= Invoice From Quotation ============--}}
@if(!empty($quotations))
    @foreach($quotations as $quotation)
        <div id="invoice-from-quotation-{{$quotation->id}}" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-full-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="fullWidthModalLabel">Make Invoice From Quotation({{$quotation->quotation_number}})</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{request()->routeIs('admin-view-invoice-generator') ? route('admin-generate-new-invoice',[$id]) : route('generate-new-invoice',[$id])}}">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card-body text-left" id="productDetailsContainerInvoice">
                                        <h3>Product Details</h3>
                                        @php
                                            $products = json_decode($quotation->products, true);
                                            $products = array_values(array_filter($products)); // Remove empty string element
                                        @endphp
                                        @foreach($products as $product)
                                            @if(!empty($product))
                                                <div class="quotation_invoice_product_details">
                                                    <a
                                                        href="{{request()->routeIs('user-customer-profile')? route('delete-single-product',[$id,$quotation->id,$index]) :route('admin-delete-single-product',[$id,$quotation->id,$index])}}"
                                                        class="btn btn-danger">Remove</a>
                                                    <div class="row">
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label">Product Name *</label>
                                                            <input required type="text" value="{{$product['product_name']}}" name="product_name[]" class="form-control" >
                                                        </div>
                                                        <div class="mb-3 col-4" >
                                                            <label class="form-label" for="basic-default-company">Product Code*</label>
                                                            <input type="number" value="{{$product['product_code']}}" required name="product_code[]" class="form-control" >
                                                        </div>
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-email">Quantity*</label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="text" value="{{$product['quantity']}}" required name="quantity[]" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                                            <input value="{{$product['unit_price']}}" required type="text" name="unit_price[]" class="form-control phone-mask">
                                                        </div>
                                                        <div class="mb-3 col-4">
                                                            <label for="defaultSelect" class="form-label">Select Unit*</label>
                                                            <select class="form-control" name="unit[]" required>
                                                                @foreach($unites as $unit)
                                                                    <option {{$product['unit'] == $unit->unit ? 'selected' : ''}}>{{$unit->unit}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
                                                            <input value="{{$product['our_coasting']}}" type="text" name="costing[]" class="form-control phone-mask">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-message">Product Description</label>
                                                            <textarea name="product_description[]" class="form-control">{{$product['description']}}</textarea>
                                                        </div>

                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-phone">Product Discount</label>
                                                            <input type="text" value="{{$product['product_discount']}}" name="product_discount[]" class="form-control phone-mask">
                                                        </div>
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-phone">Product Source</label>
                                                            <input type="text" value="{{$product['product_source']}}" name="product_source[]" class="form-control phone-mask">
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif
                                            <strong><hr class="m-4"></strong>
                                        @endforeach
                                    </div>
                                    <button class="btn btn-primary quotation_invoice_add_product" type="button">Add More</button>
                                </div>

                                <div class="col-xl-6">
                                    <div class="card-body text-left">

                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="basic-default-fullname">Select Logo Type *</label>
                                                <select required name="logo" id="customer" class="form-select">
                                                    <option> </option>
                                                    <option value="Esmart">Esmart</option>
                                                    <option value="Conquest Impex">Conquest Impex</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="basic-default-phone">Phone No</label>
                                                <input type="number" name="phone" class="form-control phone-mask" >
                                            </div>
                                        </div>

                                        <h3>Trams And Conditions</h3>

                                        <div class="row">
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                                <input type="text" name="offer_validity" class="form-control"  placeholder="30 days">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-company">Warranty *</label>
                                                <select name="warranty" class="form-select" required>
                                                    <option> </option>
                                                    @foreach($warranties as $warranty)
                                                        <option value="{{$warranty->warranty}}" >{{$warranty->warranty}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-company">Payment Type *</label>
                                                <select name="payment_type" class="form-select" required>
                                                    <option> </option>
                                                    @foreach($paymentTypes as $paymentType)
                                                        <option {{$quotation->payment_type == $paymentType->payment_type ? 'selected' : ''}}>{{$paymentType->payment_type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-company">Delivery Term </label>
                                                <select name="delivery_term" class="form-select">
                                                    <option> </option>
                                                    @foreach($deliveryTerms as $deliveryTerm)
                                                        <option value="{{$deliveryTerm->delivery_term}}" >{{$deliveryTerm->delivery_term}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-phone">vat(7.5%) & Ait(3%)</label>
                                                <input name="vat_tax" type="text" class="form-control phone-mask">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-message">Other Condition</label>
                                                <textarea name="other_condition" id="basic-default-message" class="form-control">
                                             </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-left">
                                        <div class="row">
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                                <input type="number" name="delivery_charge" class="form-control phone-mask">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-phone">Delivery Date</label>
                                                <input name="delivery_date" class="form-control" type="date" >
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-phone">Discount Amount</label>
                                                <input type="number" name="discount_amount" class="form-control phone-mask">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-phone">Extra Charge Name</label>
                                                <input type="text" name="extra_charge_name" class="form-control phone-mask">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-default-phone">Extra Amount</label>
                                                <input type="text" name="extra_amount" class="form-control phone-mask">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="basic-default-company">Select User</label>
                                                <select name="created_by" id="user-select" class="form-select">
                                                    <option>Select User</option>
                                                    @foreach($users as $user)
                                                        <option>{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit">Generate Invoice</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endforeach
@endif

@if(!empty($quotations))
    @if($products)
        <script type="text/javascript">


            document.addEventListener('DOMContentLoaded', function () {
                let addButtons = document.querySelectorAll('.quotation_invoice_add_product');

                addButtons.forEach(function (addButton) {
                    addButton.addEventListener('click', function () {
                        let productContainer = this.previousElementSibling; // Assuming the button is placed just before the product details container

                        let addProductDiv = document.createElement('div');
                        addProductDiv.classList.add('quotation_invoice_product_details');

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

    @endif
@endif

