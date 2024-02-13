<div id="add-invoice-modal" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Generate New Invoice</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="route('admin-new-generator')}}">
                    {{csrf_field()}}E
                    <div class="row">
                        <div class="col-xl-6" style="border-right: 1px solid #cccccc">
                            <div class="card-body text-left" id="nav-productDetailsContainer-invoice">
                                <h3>Product Details</h3>
                                <div class="nav-product_details_invoice">
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
                                            <input required type="text" name="quantity[]" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-2 col-4">
                                            <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                            <input required type="text" name="unit_price[]" class="form-control phone-mask">
                                        </div>
                                        <div class="mb-2 col-4">
                                            <label for="defaultSelect" class="form-label">Select Unit*</label>
                                            <select required class="form-control" name="unit[]" required="">
                                                <option></option>
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

                                </div>
                                <strong><hr class="m-4"></strong>
                            </div>
                            <button class="btn btn-primary" id="nav_add_product_invoice" type="button">Add More</button>
                        </div>
                        <div class="col-xl-6">
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-2 col-6">
                                        <label class="form-label" for="basic-default-fullname">Select Logo Type*</label>
                                        <select required name="logo" id="customer" class="form-select">
                                            <option>---------</option>
                                            <option value="Esmart">Esmart</option>
                                            <option value="Conquest Impex">Conquest Impex</option>
                                        </select>
                                    </div>
                                </div>

                                <h3>Customer Information</h3>
                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-fullname">Full Name/Company Name*</label>
                                        <input required name="name" type="text" class="form-control" placeholder="Full Name/ Company Name">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-company">Contact Person Name</label>
                                        <input name="contact_name" type="text" class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-email">Email*</label>
                                        <div class="input-group input-group-merge">
                                            <input required type="email" name="email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-default-email2">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Phone No*</label>
                                        <input required type="text" name="phone" class="form-control phone-mask" placeholder="658 799 8941">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Address*</label>
                                        <textarea required name="address" class="form-control"></textarea>
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-email">City</label>
                                        <div class="input-group input-group-merge">
                                            <input name="city" type="text" class="form-control" aria-label="john.doe" aria-describedby="basic-default-email2">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-email">Country</label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" name="country" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-email">Postal Code</label>
                                        <div class="input-group input-group-merge">
                                            <input name="postal_code" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <h3>Trams And Conditions</h3>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                        <input type="text" name="offer_validity" class="form-control"  placeholder="30 days">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-company">Warranty*</label>
                                        <select required name="warranty" class="form-select">
                                            <option> </option>
                                            @foreach($warranties as $warranty)
                                                <option value="{{$warranty->warranty}}">{{$warranty->warranty}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-company">Payment Type*</label>
                                        <select required name="payment_type" class="form-select">
                                            <option></option>
                                            @foreach($paymentTypes as $paymentType)
                                                <option value="{{$paymentType->payment_type}}">{{$paymentType->payment_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">vat(7.5%) & Ait(3%)</label>
                                        <input name="vat_tax" step="any" type="text" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-company">Delivery Term*</label>
                                        <select required name="delivery_term" class="form-select">
                                            <option> </option>
                                            @foreach($deliveryTerms as $deliveryTerm)
                                                <option value="{{$deliveryTerm->delivery_term}}">{{$deliveryTerm->delivery_term}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-message">Other Condition</label>
                                        <textarea name="other_condition" id="basic-default-message" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                        <input type="text" name="delivery_charge" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Delivery Date</label>
                                        <input name="delivery_date" class="form-control" type="date" >
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Delivery Address</label>
                                        <textarea name="delivery_address" class="form-control"></textarea>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Receiver Name</label>
                                        <input name="receiver_name" class="form-control" type="text" >
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Receiver Contact Number</label>
                                        <input name="receiver_number" class="form-control" type="text" >
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Discount Amount</label>
                                        <input type="text" name="discount_amount" class="form-control phone-mask">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Extra Charge Name</label>
                                        <input type="text" name="extra_charge_name" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-phone">Extra Amount</label>
                                        <input type="text" name="extra_amount" class="form-control phone-mask">
                                    </div>
                                     @php
                                        $users = \App\Models\User::all();
                                    @endphp
                                    <div class="mb-2 col-4">
                                        <label class="form-label" for="basic-default-company">Select User</label>
                                        <select name="submitted_by" id="user-select" class="form-select">
                                            <option>Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-info" type="submit">Generate Invoice</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
