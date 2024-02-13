@include('user.partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    @include('error')
                    @include('success')
                    <div class="customers">
                        <div class="card mb-3">
                            <div class="card-body">
                                <a href="{{route('user-view-all-quotation')}}" class="btn btn-primary d-flex justify-content-center">
                                    See All
                                </a>
                            </div>
                        </div>
                        <div class="card p-4">
                            <form method="POST" action="{{route('user-quotation')}}" enctype="multipart/form-data">
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
                                                        <input required type="text" name="quantity[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                                    <input required type="text" name="unit_price[]" class="form-control phone-mask">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="defaultSelect" class="form-label">Unit*</label>
                                                    <select required class="form-control" name="unit[]" required="">
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
                                                    <input type="number" name="product_discount[]" class="form-control phone-mask">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-default-phone">Product Source</label>
                                                    <input type="text" name="product_source[]" class="form-control phone-mask">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-default-phone">Product image</label>
                                                    <input type="file" name="product_image[]" class="form-control phone-mask">
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
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Customer/Company Name*</label>
                                                <select required name="customer_id" id="customer" class="form-select">
                                                    @foreach($customers as $customer)
                                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" >Contact Person Name</label>
                                                <input name="contact_name" class="form-control" type="text" >
                                            </div>
                                            <div class="mb-3">
                                                 <label class="form-label">Phone Number</label>
                                                <input type="number" name="phone_number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="card-body text-left">
                                            <h3>Terms And Conditions</h3>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                                <input type="text" name="offer_validity" class="form-control"  placeholder="30 days">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-company">Warranty*</label>
                                                <select name="warranty" id="defaultSelect" class="form-select">
                                                    <option>Select Warranty</option>
                                                    @foreach($warranties as $warranty)
                                                        <option value="{{$warranty->warranty}}">{{$warranty->warranty}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-company">Payment Type*</label>
                                                <select required name="payment_type" id="defaultSelect" class="form-select">
                                                    <option>Select Payment</option>
                                                    @foreach($paymentTypes as $paymentType)
                                                         <option value="{{$paymentType->payment_type}}">{{$paymentType->payment_type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-phone">vat(7.5%) & Ait(3%)</label>
                                                <input type="text" id="basic-default-phone" class="form-control phone-mask">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-company">Delivery Term*</label>
                                                <select required name="delivery_term" id="defaultSelect" class="form-select">
                                                    <option>Select Delivery Terms</option>
                                                    @foreach($deliveryTerms as $deliveryTerm)
                                                        <option value="{{$deliveryTerm->delivery_term}}">{{$deliveryTerm->delivery_term}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-message">Other Condition</label>
                                                <textarea id="basic-default-message" name="other_condition" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?"></textarea>
                                            </div>
                                        </div>
                                        <div class="card-body text-left">
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-message">Delivery Address</label>
                                                <textarea id="basic-default-message" name="delivery_address" class="form-control" placeholder="Delivery Address"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-phone">Delivery Time</label>
                                                <input name="delivery_date" class="form-control" type="text" >
                                            </div>
                                            <div class="form-check mb-3">
                                                <input name="delivery_check" class="form-check-input" type="checkbox" value="Delivery Charge Applicable" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1"> Delivery Charge Applicable </label>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                                <input type="text" name="delivery_charge" class="form-control phone-mask">
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
                                            <div>
                                                <label class="form-label" for="basic-default-company">Submitted By*</label>
                                                <select required name="submitted_by" id="defaultSelect" class="form-select">
                                                    <option> </option>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
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
                                <button class="btn btn-info" type="submit">Add Quotation</button>
                            </form>
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
                                                       <input type="text" name="product_code[]" class="form-control" >
                                                   </div>
                                                   <div class="mb-3">
                                                       <label class="form-label" for="basic-default-email">Quantity</label>
                                                       <div class="input-group input-group-merge">
                                                           <input type="text" name="quantity[]" class="form-control">
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
                                                            <option value="yard">Yard</option>
                                                            <option value="rft">RFT</option>
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
                                                     <div class="mb-3">
                                                       <label class="form-label" for="basic-default-phone">Product image</label>
                                                       <input type="file" name="product_image[]" class="form-control phone-mask">
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
@include('user.partials.layoutEnd')
