@foreach($quotations as $quotation)
    <div id="edit-quotation-form-{{$quotation->id}}" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-full-width">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="fullWidthModalLabel">Edit Quotation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="@if(request()->routeIs('customer-profile'))
                    {{route('edit-quotation',[$quotation->customer_id,$quotation->id])}}
                      @elseif(request()->routeIs('admin-all-quotation'))
                    {{route('edit-quotation',[$quotation->customer_id,$quotation->id])}}  
                    @elseif(request()->routeIs('user-customer-profile'))
                        {{route('user-customer-edit-quotation',[$id,$quotation->id])}}
                    @elseif(request()->routeIs('user-view-all-quotation'))
                        {{route('user-update-quotation',[$quotation->id])}}
                    @endif
                    " enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-xl-6"  style="border-right: 1px solid #ccc">
                                <div class="card-body text-left" id="productDetailsContainerQuotation">
                                    <h3>Product Details</h3>
                                    @php
                                        $products = json_decode($quotation->products, true)
                                    @endphp
                                    @foreach($products as $index => $product)

                                            <div class="quotation_edit_product_details">
                                                <a href="@if(request()->routeIs('admin-all-quotation'))
                                               {{route('admin-delete-single-product',[$quotation->customer_id,$quotation->id,$index])}}"
                                                  @elseif(request()->routeIs('user-view-all-quotation') || request()->routeIs('user-customer-profile'))
                                                    {{route('delete-single-product',[$quotation->customer_id,$quotation->id,$index])}}"
                                                    @else
                                                    {{route('admin-delete-single-product',[$quotation->customer_id,$quotation->id,$index])}}"
                                                 @endif
                                                   class="btn btn-danger">Remove</a>

                                                <div class="row">
                                                    <div class="mb-3 col-4">
                                                        <label class="form-label">Product Name</label>
                                                        <input type="text" value="{{$product['product_name']}}" name="product_name[]" class="form-control" >
                                                    </div>
                                                    <div class="mb-3 col-4">
                                                        <label class="form-label" for="basic-default-company">Product Code</label>
                                                        <input type="text" value="{{$product['product_code']}}" name="product_code[]" class="form-control" >
                                                    </div>
                                                    <div class="mb-3 col-4">
                                                        <label class="form-label" for="basic-default-email">Quantity</label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="number" value="{{$product['quantity']}}" name="quantity[]" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-4">
                                                        <label class="form-label" for="basic-default-phone">Unit Price</label>
                                                        <input type="text" value="{{$product['unit_price']}}" name="unit_price[]" class="form-control phone-mask">
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
                                                        <input type="text" value="{{$product['our_coasting']}}" name="costing[]" class="form-control phone-mask">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-4">
                                                        <label class="form-label" for="basic-default-message">Product Description</label>
                                                        <textarea name="product_description[]" class="form-control">{{$product['description']}}</textarea>
                                                    </div>
                                                    <div class="mb-3 col-4">
                                                        <label class="form-label" for="basic-default-phone">Product Source</label>
                                                        <input type="text" value="{{$product['product_source']}}" name="product_source[]" class="form-control phone-mask">
                                                    </div>
                                                    <div class="mb-3 col-4">
                                                        <label class="form-label" for="basic-default-phone">Product Discount</label>
                                                        <input type="number" value="{{$product['product_discount']}}" name="product_discount[]" class="form-control phone-mask">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-4">
                                                        <label class="form-label" for="product_image_{{ $index }}">Product Image For {{ $product['product_name'] }}:</label>

                                                        <!-- Display the current product image if it exists -->
                                                        @if(!empty($product['product_image']))
                                                            <img src="{{ asset('images/quotationProduct/'. $product['product_image']) }}" width="120px">
                                                            <input class="form-control" type="file" name="product_image[{{ $index }}]" value="{{ $product['product_image'] }}">
                                                        @else
                                                            <input type="file" name="product_image[{{ $index }}]" id="product_image_{{ $index }}" class="form-control phone-mask">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                        <strong><hr class="m-4"></strong>
                                    @endforeach
                                </div>
                                <button class="btn btn-primary quotation_edit_add-product" id="" type="button">Add More</button>
                            </div>

                            <div class="col-xl-6">

                                <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="basic-default-fullname">Select Logo Type*</label>
                                            <select required name="logo" id="customer" class="form-select">
                                                <option> </option>
                                                <option {{$quotation->logo == 'Esmart' ? 'selected' : ''}} value="Esmart">Esmart</option>
                                                <option {{$quotation->logo == 'Conquest Impex' ? 'selected' : ''}} value="Conquest Impex">Conquest Impex</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="basic-default-fullname">Phone Number</label>
                                            <input type="text" value="{{$quotation->phone_number}}" name="phone_number" class="form-control" placeholder="Phone number">
                                        </div>
                                    </div>
                                <h3>Trams And Conditions</h3>

                                <div class="row">
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                            <input type="text" value="{{$quotation->offer_validity}}" name="offer_validity" class="form-control"  placeholder="30 days">
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-company">Warranty *</label>
                                            <select name="warranty" class="form-select" required>
                                                <option> </option>
                                                @foreach($warranties as $warranty)
                                                    <option {{$quotation->warranty == $warranty->warranty ? 'selected' : ''}} value="{{$warranty->warranty}}">{{$warranty->warranty}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-company">Payment Type *</label>
                                            <select name="payment_type" class="form-select" required>
                                                <option> </option>
                                                @foreach($paymentTypes as $paymentType)
                                                    <option {{$quotation->payment_type == $paymentType->payment_type ? 'selected' : ''}} value="{{$paymentType->payment_type}}">{{$paymentType->payment_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                <div class="row">
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-phone">vat(7.5%) & Ait(3%)</label>
                                            <input name="vat_tax" value="{{$quotation->vat_tax}}" type="text" class="form-control phone-mask">
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-company">Delivery Term</label>
                                            <select name="delivery_term" class="form-select">
                                                <option> </option>
                                                @foreach($deliveryTerms as $deliveryTerm)
                                                    <option {{$quotation->delivery_term == $deliveryTerm->delivery_term ? 'selected' : ''}} value="{{$deliveryTerm->delivery_term}}">{{$deliveryTerm->delivery_term}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-message">Other Condition</label>
                                            <textarea name="other_condition" id="basic-default-message" class="form-control">
                                             {{$quotation->other_condition}}
                                        </textarea>
                                        </div>
                                    </div>

                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-phone">Delivery Time</label>
                                        <input name="delivery_date" value="{{$quotation->delivery_date}}" class="form-control" type="text">
                                    </div>
                                    <div class="form-check mb-3 col-4">
                                        <input {{$quotation->delivery_charge ? 'checked' : ''}} name="delivery_check" class="form-check-input" type="checkbox" value="Delivery Charge Applicable" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1"> Delivery Charge Applicable </label>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                        <input type="text" value="{{$quotation->delivery_charge}}" name="delivery_charge" class="form-control phone-mask">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-phone">Discount Amount</label>
                                        <input type="number" value="{{$quotation->discount_amount}}" name="discount_amount" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-phone">Extra Charge Name</label>
                                        <input type="text" value="{{$quotation->extra_charge_name}}" name="extra_charge_name" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-phone">Extra Amount</label>
                                        <input type="text" value="{{$quotation->extra_amount}}" name="extra_amount" class="form-control phone-mask">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="basic-default-company">Submitted By *</label>
                                        <select name="submitted_by" id="defaultSelect" class="form-select" required>
                                            <option> </option>
                                            @foreach($users as $user)
                                                <option {{$user->id == $quotation->user_id ? 'selected' : ''}} value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="basic-default-company">Status *</label>
                                        <select name="status" id="defaultSelect" class="form-select">
                                            <option> </option>
                                            <option value="Sent" {{$quotation->status == 'Sent' ? 'selected' : ''}}>Sent</option>
                                            <option value="Not Sent" {{$quotation->status == 'Not Sent' ? 'selected' : ''}}>Not Sent</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-info" type="submit">Update Quotation</button>
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


@if(!empty($quotations))
    @if(!empty($products))
        <script type="text/javascript">

            // ======== Quotation product details =======
            document.addEventListener('DOMContentLoaded', function () {
                let addButtons = document.querySelectorAll('.quotation_edit_add-product');

                addButtons.forEach(function (addButton) {
                    addButton.addEventListener('click', function () {
                        let productContainer = this.previousElementSibling; // Assuming the button is placed just before the product details container

                        let addProductDiv = document.createElement('div');
                        addProductDiv.classList.add('quotation_edit_product_details');

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
                                                            <input type="number" name="quantity[]" class="form-control">
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
                                                        <label class="form-label" for="basic-default-phone">Product Source</label>
                                                        <input type="text" name="product_source[]" class="form-control phone-mask">
                                                     </div>
                                                    <div class="mb-3 col-4">
                                                        <label class="form-label" for="basic-default-phone">Product Discount</label>
                                                        <input type="number" name="product_discount[]" class="form-control phone-mask">
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="mb-3 col-4">
                                                        <label class="form-label" for="product_image_{{ $index }}">Product Image For {{ $product['product_name'] }}:</label>

                                                        <!-- Display the current product image if it exists -->

                                                     <input type="file" name="product_image[{{ $index }}]" id="product_image_{{ $index }}" class="form-control phone-mask">

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
