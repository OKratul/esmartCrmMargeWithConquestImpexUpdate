<div id="add-quotation-modal" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Add Quotation Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('quotation')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-xl-6" style="border-right: 1px solid #cccccc">
                            <div class="card-body text-left" id="productDetailsContainer">
                                <h3>Product Details</h3>
                                <div class="product_details">

                                    <div class="row">
                                        <div class="mb-2 col-4">
                                            <label class="form-label">Product Name*</label>
                                            <input required type="text" name="product_name[]" class="form-control" >
                                        </div>
                                        <div class="mb-2 col-4">
                                            <label class="form-label" for="basic-default-company">Product Code*</label>
                                            <input required type="text" name="product_code[]" class="form-control" >
                                        </div>
                                        <div class="mb-2 col-4">
                                            <label class="form-label" for="basic-default-email">Quantity*</label>
                                            <div class="input-group input-group-merge">
                                                <input required type="text" name="quantity[]" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-2 col-4">
                                            <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                            <input required type="text" name="unit_price[]" class="form-control phone-mask">
                                        </div>
                                        <div class="mb-2 col-4">
                                            <label for="defaultSelect" class="form-label">Unit*</label>
                                            <select required class="form-control" name="unit[]" required="">
                                                @foreach($unites as $unit)
                                                    <option value="{{$unit->unit}}">{{$unit->unit}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-2 col-4">
                                            <label class="form-label" for="basic-default-message">Product Description</label>
                                            <textarea name="product_description[]" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-2 col-4">
                                            <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
                                            <input type="text" name="costing[]" class="form-control phone-mask">
                                        </div>
                                        <div class="mb-2 col-4">
                                            <label class="form-label" for="basic-default-phone">Product Discount</label>
                                            <input type="text" name="product_discount[]" class="form-control phone-mask">
                                        </div>
                                        <div class="mb-2 col-4">
                                            <label class="form-label" for="basic-default-phone">Product Source</label>
                                            <input type="text" name="product_source[]" class="form-control phone-mask">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-4">
                                            <label class="form-label" for="basic-default-phone">Product image</label>
                                            <input type="file" name="product_image[]" class="form-control phone-mask">
                                        </div>
                                    </div>
                                </div>
                                <strong><hr class="m-4"></strong>
                            </div>
                            <button class="btn btn-primary" id="add_product" type="button">Add More</button>
                        </div>
                        <div class="col-xl-6">
                            <div class="card-body text-left">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Select Logo Type*</label>
                                    <select required name="logo" id="customer" class="form-select">
                                        <option>---------</option>
                                        <option value="Esmart">Esmart</option>
                                        <option value="Conquest Impex">Conquest Impex</option>
                                    </select>
                                </div>
                                <h3>Select Customer/Company Details</h3>
                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-fullname">Customer/Company Name*</label>
                                        <select required name="customer_id" id="customer" class="form-select">
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" >Contact Person Name</label>
                                        <input name="contact_name" class="form-control" type="text" >
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-left">
                                <h3>Terms And Conditions</h3>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                        <input type="text" name="offer_validity" class="form-control"  placeholder="30 days">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-company">Warranty*</label>
                                        <select name="warranty" id="defaultSelect" class="form-select">
                                            <option>Select Warranty</option>
                                            @foreach($warranties as $warranty)
                                                <option value="{{$warranty->warranty}}">{{$warranty->warranty}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-company">Payment Type*</label>
                                        <select required name="payment_type" id="defaultSelect" class="form-select">
                                            <option>Select Payment</option>
                                            @foreach($paymentTypes as $paymentType)
                                                <option value="{{$paymentType->payment_type}}">{{$paymentType->payment_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">vat(7.5%) & Ait(3%)</label>
                                        <input type="text" id="basic-default-phone" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-company">Delivery Term*</label>
                                        <select required name="delivery_term" id="defaultSelect" class="form-select">
                                            <option>Select Delivery Terms</option>
                                            @foreach($deliveryTerms as $deliveryTerm)
                                                <option value="{{$deliveryTerm->delivery_term}}">{{$deliveryTerm->delivery_term}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-message">Other Condition</label>
                                        <textarea id="basic-default-message" name="other_condition" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body text-left">

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-message">Delivery Address</label>
                                        <textarea id="basic-default-message" name="delivery_address" class="form-control" placeholder="Delivery Address"></textarea>
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Delivery Time</label>
                                        <input name="delivery_date" class="form-control" type="text" >
                                    </div>
                                    <div class="form-check mb-2 col-4">
                                        <input name="delivery_check" class="form-check-input" type="checkbox" value="Delivery Charge Applicable" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1"> Delivery Charge Applicable </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                        <input type="text" name="delivery_charge" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Discount Amount</label>
                                        <input type="text" name="discount_amount" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Extra Charge Name</label>
                                        <input type="text" name="extra_charge_name" class="form-control phone-mask">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Extra Amount</label>
                                        <input type="text" name="extra_amount" class="form-control phone-mask">
                                    </div>
                                     @php
                                        $users = \App\Models\User::all();
                                    @endphp
                                                            <div class="col-4">
                                        <label class="form-label" for="basic-default-company">Submitted By*</label>
                                        <select required name="submitted_by" id="defaultSelect" class="form-select">
                                            <option> </option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="basic-default-company">Status*</label>
                                        <select required name="status" id="defaultSelect" class="form-select">
                                            <option> </option>
                                            <option value="Sent">Sent</option>
                                            <option value="Not Sent">Not Sent</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button class="btn btn-info" type="submit">Add Quotation</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


