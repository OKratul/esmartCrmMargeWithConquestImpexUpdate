<div class="card p-4">
    <form method="POST"  @if(request()->routeIs('customer-profile'))
              action="{{route('admin-generate-new-invoice',[$id])}}"
          @else
            action="{{route('generate-new-invoice',[$id])}}
          @endif">
        {{csrf_field()}}
        <div class="row">
            <div class="col-xl-6">
                <div class="card-body text-left" id="productDetailsContainer">
                    <h3>Product Details</h3>
                    <div class="make-invoice-profile_product_details">
                        <div class="row">
                            <div class="mb-2 col-4">
                                <label class="form-label">Product Name*</label>
                                <input required type="text" name="product_name[]" class="form-control" >
                            </div>
                            <div class="mb-2 col-4">
                                <label class="form-label" for="basic-default-company">Product Code*</label>
                                <input type="text" required name="product_code[]" class="form-control" >
                            </div>
                            <div class="mb-2 col-4">
                                <label class="form-label" for="basic-default-email">Quantity*</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" required name="quantity[]" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-2 col-4">
                                <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                <input type="text" required name="unit_price[]" class="form-control phone-mask">
                            </div>
                            <div class="mb-2 col-4">
                                <label for="defaultSelect" class="form-label">Select Unit*</label>
                                <select class="form-control" name="unit[]" required >
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
                <button class="btn btn-primary make-invoice-from-profile" type="button">Add More</button>
            </div>
            <div class="col-xl-6">
                <div class="card-body text-left">
                    <div class="row">
                        <div class="mb-2 col-6">
                            @php
                                $pdfs = \App\Models\PDFsetup::all();
                            @endphp
                            <label class="form-label" for="basic-default-fullname">Select Logo Type*</label>
                            <select required name="logo" id="customer" class="form-select">
                                <option>---------</option>
                                @foreach($pdfs as $pdf)
                                    <option value="{{$pdf->name}}">{{$pdf->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2 col-6">
                            <label class="form-label" for="basic-default-fullname">Phone Number*</label>
                            <input type="text" required name="phone_number" class="form-control"  placeholder="Phone number">
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
                                <option>Select Warranty</option>
                                @foreach($warranties as $warranty)
                                    <option value="{{$warranty->warranty}}">{{$warranty->warranty}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2 col-4">
                            <label class="form-label" for="basic-default-company">Payment Type*</label>
                            <select required name="payment_type" class="form-select">
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
                            <input name="vat_tax" step="any" type="text" class="form-control phone-mask">
                        </div>
                        <div class="mb-2 col-4">
                            <label class="form-label" for="basic-default-company">Delivery Term*</label>
                            <select required name="delivery_term" class="form-select">
                                <option>Select Payment</option>
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


                </div>
                <div class="card-body text-left">

                    <div class="row">
                        <div class="mb-2 col-4">
                            <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                            <input type="number" name="delivery_charge" class="form-control phone-mask">
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
                            <input name="receiver_number" class="form-control" type="text">
                        </div>
                        <div class="mb-2 col-4">
                            <label class="form-label" for="basic-default-phone">Discount Amount</label>
                            <input type="number" name="discount_amount" class="form-control phone-mask">
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
                        <div class="card-body text-left">
                            <label class="form-label" for="basic-default-company">Select User</label>
                            <select id="user-select" class="form-select" name="created_by">
                                <option>Select User</option>
                                @foreach($users as $user)
                                    <option value="{{$user->name}}">{{$user->name}}</option>
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
<!-- Your HTML code remains unchanged -->

<script type="text/javascript">

    // ======== Quotation product details =======
    document.addEventListener('DOMContentLoaded', function () {
        let addButtons = document.querySelectorAll('.make-invoice-from-profile');

        addButtons.forEach(function (addButton) {
            addButton.addEventListener('click', function () {
                let productContainer = this.previousElementSibling; // Assuming the button is placed just before the product details container

                let addProductDiv = document.createElement('div');
                addProductDiv.classList.add('make-invoice-profile_product_details');

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
                                                        <option> </option>
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

