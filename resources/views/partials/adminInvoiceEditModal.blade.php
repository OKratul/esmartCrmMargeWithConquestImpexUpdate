<div id="invoice-edit-modal-{{$invoice->id}}" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Edit Invoice #{{$invoice->invoice_no}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form method="POST"
                          action="{{request()->routeIs('user-all-invoice')? route('user-update-invoice',[$invoice->customer_id,$invoice->id])
                                    :(request()->routeIs('user-customer-profile') ? route('user-update-invoice',[$invoice->customer_id,$invoice->id]) : route('admin-update-invoice',[$invoice->customer_id,$invoice->id]))}}" >
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-xl-6" style="border-right: 1px solid #cccccc">
                                <div class="card-body text-left edit-invoice-product-details-container">
                                    <h3>Product Details</h3>
                                    @php
                                        $products = json_decode($invoice->products, true);
                                        $products = array_values(array_filter($products)); // Remove empty string element
                                    @endphp
                                    @foreach($products as $index=>$product)
                                        <div class="product-remove-button">
                                            <button type="submit" class="btn btn-danger">
                                                <a class="text-white" onclick="return confirm('Are you sure you want to delete this Product?')"  href="{{ route('remove-single-product', [$invoice->customer_id,$invoice->id,$index]) }}">Delete</a>
                                            </button>
                                        </div>
                                        <div class="edit_invoice_profile_product_details">
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
                                                        <input type="text" value="{{$product['quantity']}}" name="quantity[]" class="form-control">
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
                                                            <option {{$product['unit'] == $unit->unit ? 'selected' : ''}} value="{{$unit->unit}}">{{$unit->unit}}</option>
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
                                                    <label class="form-label" for="basic-default-phone">Product Discount</label>
                                                    <input type="number" value="{{$product['product_discount']}}" name="product_discount[]" class="form-control phone-mask">
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-default-phone">Product Source</label>
                                                    <input type="text" value="{{$product['product_source']}}" name="product_source[]" class="form-control phone-mask">
                                                </div>
                                            </div>

                                        </div>
                                        <strong><hr class="m-4"></strong>
                                    @endforeach
                                        <button class="btn btn-primary edit_invoice_profile_add-product"  type="button">Add More</button>
                                </div>

                            </div>

                            <div class="col-xl-6">
                                <div class="card-body text-left">

                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="basic-default-fullname">Select Logo Type*</label>
                                            <select required name="logo" id="customer" class="form-select">
                                                <option>---------</option>
                                                <option {{$invoice->logo == 'Esmart' ? 'selected' : ''}} value="Esmart">Esmart</option>
                                                <option {{$invoice->logo == 'Conquest Impex' ? 'selected' : ''}} value="Conquest Impex">Conquest Impex</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="basic-default-fullname">Phone Number</label>
                                            <input type="text" name="phone_number" value="{{$invoice->phone_number}}" class="form-control" placeholder="Phone number">
                                        </div>
                                    </div>
                                    <h3>Trams And Conditions</h3>
                                    <div class="row">
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                            <input type="text" value="{{$invoice->offer_validity}}" name="offer_validity" class="form-control"  placeholder="30 days">
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-company">Warranty</label>
                                            <input type="text" value="{{$invoice->warranty}}" name="warranty" class="form-control"  placeholder="30 days">
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-company">Payment Type</label>
                                            <select required name="payment_type" id="defaultSelect" class="form-select">
                                                <option> </option>
                                                @foreach($paymentTypes as $paymentType)
                                                    <option {{$invoice->payment_type == $paymentType->payment_type ? 'selected' : ''}} value="{{$paymentType->payment_type}}">{{$paymentType->payment_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-phone">vat(7.5%) & Ait(3%)</label>
                                            <input name="vat_tax" value="{{$invoice->vat_tax}}" type="text" class="form-control phone-mask">
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-company">Delivery Term</label>
                                            <select name="delivery_term" id="defaultSelect" class="form-select">
                                                <option> </option>
                                                @foreach($deliveryTerms as $deliveryTerm)
                                                    <option {{$invoice->delivery_term == $deliveryTerm->delivery_term ? 'selected' : ''}} value="{{$deliveryTerm->delivery_term}}">{{$deliveryTerm->delivery_term}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-message">Other Condition</label>
                                            <textarea name="other_condition" id="basic-default-message" class="form-control">
                                              {{$invoice->other_condition}}
                                             </textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                            <input type="text" value="{{$invoice->delivery_charge}}" name="delivery_charge" class="form-control phone-mask">
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-phone">Delivery Date</label>
                                            <input name="delivery_date" value="{{$invoice->delivery_date}}" class="form-control" type="date" >
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-phone">Discount Amount</label>
                                            <input type="text" value="{{$invoice->discount_amount}}" name="discount_amount" class="form-control phone-mask">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-phone">Extra Charge Name</label>
                                            <input type="text" value="{{$invoice->extra_charge_name}}" name="extra_charge_name" class="form-control phone-mask">
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-phone">Extra Amount</label>
                                            <input type="text" value="{{$invoice->extra_amount}}" name="extra_amount" class="form-control phone-mask">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label" for="basic-default-company">Submitted By*</label>
                                            <select required name="submitted_by" id="defaultSelect" class="form-select">
                                                <option> </option>
                                                @foreach($users as $user)
                                                    @if(!empty($invoice->users))
                                                        <option value="{{$user->id}}" {{$invoice->users['id'] == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                                                    @else
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="text-center">
                            <button class="btn btn-info" type="submit">Update Invoice</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>



