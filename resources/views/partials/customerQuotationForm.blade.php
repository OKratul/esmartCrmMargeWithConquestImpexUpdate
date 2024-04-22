<div class="card">
    <div class="card-body text-left">
        @include('error')
        @include('success')
        <div class="card p-4">
            <form method="POST" action="
                                                                                    @if(request()->routeIs('admin-view-add-quotation'))
                                                                                        {{ route('admin-quotation-add-profile', [$id]) }}
                                                                                    @elseif(request()->routeIs('admin-all-query'))
                                                                                        {{ route('admin-quotation-add-profile', [$query->customer_id]) }}
                                                                                    @elseif(request()->routeIs('user-customer-profile'))
                                                                                        {{route('user-quotation-add-profile',[$id])}}
                                                                                    @else
                                                                                        {{ route('quotation-add-profile', [$id]) }}
                                                                                    @endif

                                                                                    " enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-xl-6" style="border-right: 1px solid #cccccc">
                        <div class="card-body text-left" id="profile_product_details_container">
                            <h3>Product Details</h3>
                            <div class="profile_quot_product_details">
                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Product Name*</label>
                                        <input required type="text" name="product_name[]" class="form-control" >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-company">Product Code*</label>
                                        <input type="text" required name="product_code[]" class="form-control" >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-email">Quantity*</label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" required name="quantity[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                        <input required type="text" name="unit_price[]" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="defaultSelect" class="form-label">Select Unit*</label>
                                        <select required class="form-control" name="unit[]" required="">
                                            @foreach($unites as $unit)
                                                <option value="{{$unit->unit}}">{{$unit->unit}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
                                        <input type="text" name="costing[]" class="form-control phone-mask">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-8">
                                        <label class="form-label" for="basic-default-message">Product Description</label>
                                        <textarea name="product_description[]" class="form-control"></textarea>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-phone">Product Discount</label>
                                        <input type="text" name="product_discount[]" class="form-control phone-mask">
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="basic-default-phone">Product Source</label>
                                            <input type="text" name="product_source[]" class="form-control phone-mask">
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="basic-default-phone">Product image</label>
                                            <input type="file" name="product_image[]" class="form-control phone-mask">
                                        </div>
                                </div>
                            </div>
                            <strong><hr class="m-4"></strong>
                        </div>
                        <button class="btn btn-primary" id="profile_quot_add_product" type="button">Add More</button>
                    </div>
                    <div class="col-xl-6">
                        <div class="card-body text-left">

                            <div class="row">
                                <div class="mb-3 col-6">
                                    @php
                                        $pdfs = \App\Models\PDFsetup::all();
                                    @endphp
                                    <label class="form-label" for="basic-default-fullname">Select Logo Type*</label>
                                    <select required name="logo" id="customer" class="form-select">
                                        <option> </option>
                                        @foreach($pdfs as $pdf)
                                            <option value="{{$pdf->name}}">{{$pdf->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="basic-default-fullname">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control"  placeholder="Phone number">
                                </div>
                            </div>

                            <h3>Trams And Conditions</h3>

                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                    <input type="text" name="offer_validity" class="form-control"  placeholder="30 days">
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="basic-default-company">Warranty*</label>
                                    <select required name="warranty" id="defaultSelect" class="form-select">
                                        <option> </option>
                                        @foreach($warranties as $warranty)
                                            <option value="{{$warranty->warranty}}">{{$warranty->warranty}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="basic-default-company">Payment Type*</label>
                                    <select required name="payment_type" id="defaultSelect" class="form-select">
                                        <option> </option>
                                        @foreach($paymentTypes as $paymentType)
                                            <option value="{{$paymentType->payment_type}}">{{$paymentType->payment_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="basic-default-phone">vat(7.5%) & Ait(3%)</label>
                                    <input name="vat_tax" type="text" class="form-control phone-mask">
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="basic-default-company">Delivery Term*</label>
                                    <select name="delivery_term" id="defaultSelect" class="form-select">
                                        <option> </option>
                                        @foreach($deliveryTerms as $deliveryTerm)
                                            <option required value="{{$deliveryTerm->delivery_term}}">{{$deliveryTerm->delivery_term}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="basic-default-phone">Delivery Time</label>
                                    <input name="delivery_date" class="form-control" type="text" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="basic-default-message">Other Condition</label>
                                    <textarea name="other_condition" id="basic-default-message" class="form-control"></textarea>
                                </div>
                                <div class="form-check mb-3 col-3">
                                    <input name="delivery_check" class="form-check-input" type="checkbox" value="Delivery Charge Applicable" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1"> Delivery Charge Applicable </label>
                                </div>
                                <div class="mb-3 col-3">
                                    <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                    <input type="text" name="delivery_charge" class="form-control phone-mask">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="basic-default-phone">Discount Amount</label>
                                    <input type="number" name="discount_amount" class="form-control phone-mask">
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="basic-default-phone">Extra Charge Name</label>
                                    <input type="text" name="extra_charge_name" class="form-control phone-mask">
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="basic-default-phone">Extra Amount</label>
                                    <input type="text" name="extra_amount" class="form-control phone-mask">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label" for="basic-default-company">Submitted By*</label>
                                    <select name="submitted_by" required id="defaultSelect" class="form-select">
                                        <option> </option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="basic-default-company">Status*</label>
                                    <select name="status" id="defaultSelect" class="form-select">
                                        <option> </option>
                                        <option value="Sent">Sent</option>
                                        <option value="Not Sent">Not Sent</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-info" type="submit">Add Quotation</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">

    //    ======== Quotation product details =======

    document.addEventListener('DOMContentLoaded', function () {
        // Your existing code here
        let addButton = document.getElementById('profile_quot_add_product');

        addButton.addEventListener('click', function (){
            let productContainer = document.getElementById('profile_product_details_container');

            let addProductDiv = document.createElement('div');

            addProductDiv.classList.add('profile_quot_product_details');

            addProductDiv.innerHTML = `
            <div class="mb-3">
                <!-- Add remove button -->
                <button class="profile_quot_remove_product btn btn-danger">Remove</button>
            </div>
            <div class="row">
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Product Name*</label>
                                        <input required type="text" name="product_name[]" class="form-control" >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-company">Product Code*</label>
                                        <input type="text" required name="product_code[]" class="form-control" >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-email">Quantity*</label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" required name="quantity[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                        <input required type="text" name="unit_price[]" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="defaultSelect" class="form-label">Select Unit*</label>
                                        <select required class="form-control" name="unit[]" required="">
                                            @foreach($unites as $unit)
            <option value="{{$unit->unit}}">{{$unit->unit}} </option>
                                            @endforeach
            </select>
        </div>
        <div class="mb-3 col-4">
            <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
            <input type="text" name="costing[]" class="form-control phone-mask">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-8">
            <label class="form-label" for="basic-default-message">Product Description</label>
            <textarea name="product_description[]" class="form-control"></textarea>
        </div>
        <div class="mb-3 col-4">
            <label class="form-label" for="basic-default-phone">Product Discount</label>
            <input type="text" name="product_discount[]" class="form-control phone-mask">
        </div>
    </div>
    <div class="row">
            <div class="mb-3 col-6">
                <label class="form-label" for="basic-default-phone">Product Source</label>
                <input type="text" name="product_source[]" class="form-control phone-mask">
            </div>
            <div class="mb-3 col-6">
                <label class="form-label" for="basic-default-phone">Product image</label>
                <input type="file" name="product_image[]" class="form-control phone-mask">
            </div>
    </div>
`;

            productContainer.appendChild(addProductDiv);
            let removeButtons = document.getElementsByClassName('profile_quot_remove_product');
            for (let i = 0; i < removeButtons.length; i++) {
                removeButtons[i].addEventListener('click', function () {
                    // Remove the parent div when remove button is clicked
                    this.parentNode.parentNode.remove();
                });
            }
        });
    });

</script>


