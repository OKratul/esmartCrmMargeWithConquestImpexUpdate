@if(request()->routeIs('admin-view-new-invoice-generator'))
    @include('partials.layoutHead')
@else
    @include('user.partials.layoutHead')
@endif
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @if(request()->routeIs('admin-view-new-invoice-generator'))
            @include('partials.sidebar')
        @else
            @include('user.partials.sidebar')
        @endif
        <div class="layout-page">
            @if(request()->routeIs('admin-view-new-invoice-generator'))
                @include('partials.navbar')
            @else
                @include('user.partials.navbar')
            @endif
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-body text-left">
                                    @include('error')
                                    @include('success')
                                    <div class="card p-4">
                                        <form method="POST" action="{{request()->routeIs('admin-view-new-invoice-generator') ? route('admin-new-generator') : route('new-generator')}}">
                                            {{csrf_field()}}
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="card-body text-left" id="productDetailsContainer">
                                                        <h3>Product Details</h3>
                                                        <div class="product_details">
                                                            <div class="mb-3">
                                                                <label class="form-label">Product Name*</label>
                                                                <input required type="text" name="product_name[]" class="form-control" >
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="basic-default-company">Product Code*</label>
                                                                <input required type="text" name="product_code[]" class="form-control" >
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="basic-default-email">Quantity*</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input required type="number" name="quantity[]" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                                                <input required type="text" name="unit_price[]" class="form-control phone-mask">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="defaultSelect" class="form-label">Select Unit*</label>
                                                                <select required class="form-control" name="unit[]" required="">
                                                                    <option></option>
                                                                   @foreach($unites as $unit)
                                                                       <option value="{{$unit->unit}}">{{$unit->unit}}</option>
                                                                   @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="basic-default-message">Product Description</label>
                                                                <textarea name="product_description[]" class="form-control"></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
                                                                <input type="text" name="costing[]" class="form-control phone-mask">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="basic-default-phone">Product Discount</label>
                                                                <input type="text" name="product_discount[]" class="form-control phone-mask">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="basic-default-phone">Product Source</label>
                                                                <input type="text" name="product_source[]" class="form-control phone-mask">
                                                            </div>
                                                        </div>
                                                        <strong><hr class="m-4"></strong>
                                                    </div>
                                                    <button class="btn btn-primary" id="add_product" type="button">Add More</button>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-fullname">Select Logo Type*</label>
                                                            <select required name="logo" id="customer" class="form-select">
                                                                <option>---------</option>
                                                                <option value="Esmart">Esmart</option>
                                                                <option value="Conquest Impex">Conquest Impex</option>
                                                            </select>
                                                        </div>
                                                        <h3>Customer Information</h3>
                                                        <div>
                                                            <div class="individual text-left" id="individualCustomer">
                                                                <div class="col-md-10 mb-4">
                                                                    <div class="input-group">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Select Customer type*</label>
                                                                        <select required name="type" id="selectCustomerType">
                                                                            <option> </option>
                                                                            <option value="individual">Individual</option>
                                                                            <option value="company">Company</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-fullname">Full Name/Company Name*</label>
                                                                    <input required name="name" type="text" class="form-control" placeholder="Full Name/ Company Name">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-company">Contact Person Name</label>
                                                                    <input name="contact_name" type="text" class="form-control" placeholder="">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-email">Email*</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <input required type="email" name="email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-default-email2">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-phone">Phone No*</label>
                                                                    <input required type="number" name="phone" class="form-control phone-mask" placeholder="658 799 8941">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-phone">Address*</label>
                                                                    <textarea required name="address" class="form-control"></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-email">City</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <input name="city" type="text" class="form-control" aria-label="john.doe" aria-describedby="basic-default-email2">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-email">Country</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <input type="text" name="country" class="form-control" >
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-email">Postal Code</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <input name="postal_code" type="text" class="form-control">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body text-left">
                                                        <h3>Trams And Conditions</h3>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                                            <input type="text" name="offer_validity" class="form-control"  placeholder="30 days">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-company">Warranty*</label>
                                                            <select required name="warranty" class="form-select">
                                                                <option> </option>
                                                               @foreach($warranties as $warranty)
                                                                    <option value="{{$warranty->warranty}}">{{$warranty->warranty}}</option>
                                                               @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-company">Payment Type*</label>
                                                            <select required name="payment_type" class="form-select">
                                                                <option></option>
                                                                @foreach($paymentTypes as $paymentType)
                                                                    <option value="{{$paymentType->payment_type}}">{{$paymentType->payment_type}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-phone">vat(7.5%) & Ait(3%)</label>
                                                            <input name="vat_tax" step="any" type="number" class="form-control phone-mask">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-company">Delivery Term*</label>
                                                            <select required name="delivery_term" class="form-select">
                                                                <option> </option>
                                                                @foreach($deliveryTerms as $deliveryTerm)
                                                                    <option value="{{$deliveryTerm->delivery_term}}">{{$deliveryTerm->delivery_term}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-message">Other Condition</label>
                                                            <textarea name="other_condition" id="basic-default-message" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="card-body text-left">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                                            <input type="number" name="delivery_charge" class="form-control phone-mask">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-phone">Delivery Date</label>
                                                            <input name="delivery_date" class="form-control" type="date" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-phone">Delivery Address</label>
                                                            <textarea name="delivery_address" class="form-control"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-phone">Receiver Name</label>
                                                            <input name="receiver_name" class="form-control" type="text" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-phone">Receiver Contact Number</label>
                                                            <input name="receiver_number" class="form-control" type="text" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-phone">Discount Amount</label>
                                                            <input type="text" name="discount_amount" class="form-control phone-mask">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-phone">Extra Charge Name</label>
                                                            <input type="text" name="extra_charge_name" class="form-control phone-mask">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-phone">Extra Amount</label>
                                                            <input type="text" name="extra_amount" class="form-control phone-mask">
                                                        </div>
                                                    </div>
                                                    <div class="card-body text-left">
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
                                            <div class="text-center">
                                                <button class="btn btn-info" type="submit">Generate Invoice</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript">

    //    ======== Quotation product details =======


    let addButton = document.getElementById('add_product');

    addButton.addEventListener('click', function (){
        let productContainer = document.getElementById('productDetailsContainer');


        let addProductDiv = document.createElement('div');

        addProductDiv.classList.add('product_details');

        addProductDiv.innerHTML = `
                                        <div class="mb-3">
                                            <!-- Add remove button -->
                                            <button class="remove_product btn btn-danger">Remove</button>
                                        </div>
                                         <div class="mb-3">
                                                       <label class="form-label">Product Name</label>
                                                       <input type="text" name="product_name[]" class="form-control" >
                                                   </div>
                                                   <div class="mb-3">
                                                       <label class="form-label" for="basic-default-company">Product Code</label>
                                                       <input type="number" name="product_code[]" class="form-control" >
                                                   </div>
                                                   <div class="mb-3">
                                                       <label class="form-label" for="basic-default-email">Quantity</label>
                                                       <div class="input-group input-group-merge">
                                                           <input type="number" name="quantity[]" class="form-control">
                                                       </div>
                                                   </div>
                                                   <div class="mb-3">
                                                       <label class="form-label" for="basic-default-phone">Unit Price</label>
                                                       <input type="text" name="unit_price[]" class="form-control phone-mask">
                                                   </div>
                                                   <div class="mb-3">
                                                        <label for="defaultSelect" class="form-label">Default select</label>
                                                        <select class="form-control" name="unit[]" required="">
                                                            <option value="pc">Piece</option>
                                                            <option value="ft">Foot</option>
                                                            <option value="mt">Meter</option>
                                                            <option value="in">Inch</option>
                                                            <option value="sq.in">Square Inch</option>
                                                            <option value="sq.ft">Square Foot</option>
                                                            <option value="sq.mt">Square Meter</option>
                                                            <option value="set">Set</option>
                                                            <option value="box">Box</option>
                                                            <option value="kg">Kg</option>
                                                            <option value="gram">Gram</option>
                                                            <option value="liter">Liter</option>
                                                            <option value="carton">Carton</option>
                                                            <option value="packet">Packet</option>
                                                            <option value="pound">Pound</option>
                                                            <option value="roll">Roll</option>
                                                            <option value="RFT">RFT</option>
                                                        </select>
                                                   </div>
                                                   <div class="mb-3">
                                                       <label class="form-label" for="basic-default-message">Product Description</label>
                                                       <textarea name="product_description[]" class="form-control"></textarea>
                                                   </div>
                                                   <div class="mb-3">
                                                       <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
                                                       <input type="text" name="costing[]" class="form-control phone-mask">
                                                   </div>
                                                   <div class="mb-3">
                                                       <label class="form-label" for="basic-default-phone">Product Discount</label>
                                                       <input type="number" name="product_discount[]" class="form-control phone-mask">
                                                   </div>
                                                   <div class="mb-3">
                                                       <label class="form-label" for="basic-default-phone">Product Source</label>
                                                       <input type="text" name="product_source[]" class="form-control phone-mask">
                                                   </div>
                                                    <hr class="m-4">

`
        productContainer.appendChild(addProductDiv);
        let removeButtons = document.getElementsByClassName('remove_product');
        for (let i = 0; i < removeButtons.length; i++) {
            removeButtons[i].addEventListener('click', function () {
                // Remove the parent div when remove button is clicked
                this.parentNode.parentNode.remove();
            });
        }

    });
</script>

@include('partials.layoutEnd')
