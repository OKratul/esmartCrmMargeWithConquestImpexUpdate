@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-3 position-fixed">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="customer-profile-sidebar">
                                        <ul>
                                            <li>
                                                <a href="{{route('user-customer-profile',[$customer_id])}}"><i class='bx bx-user-circle me-1' ></i> Profile</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-query-add-form-profile',[$customer_id])}}"><i class='bx bx-notepad me-1'></i>Lead/Qurery</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-customer-all-quotations',[$customer_id])}}"><i class='bx bxs-file-pdf me-1'></i>All Quotations</a>
                                            </li>
                                            <li>
                                                <a href="{{route('all-invoice',[$customer_id])}}"><i class='bx bx-food-menu me-1'></i> Invoices</a>
                                            </li>
                                            <li>
                                                <a href="{{route('customer-all-payment',[$customer_id])}}"><i class='bx bxs-badge-dollar me-1'></i> payments</a>
                                            </li>
                                            <li>
                                                <a href=""><i class='bx bx-note me-1'></i>Notes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">

                                <div class="card mb-4">
                                    @foreach($quotations as $quotation)
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0"><strong>{{$quotation->customers['name']}}'s</strong> Edit Quotation</h4>
                                    </div>
                                    <div class="card-body text-left">
                                        @include('error')
                                        @include('success')
                                        <div class="card p-4">
                                            <form method="POST" action="{{route('user-update-quotation',[$quotation->id])}}">
                                                {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="card-body text-left" id="productDetailsContainer">
                                                                <h3>Product Details</h3>

                                                                @php
                                                                    $products = json_decode($quotation->products, true);
                                                                    $products = array_values(array_filter($products)); // Remove empty string element
                                                                @endphp
                                                                @foreach($products as $index=>$product)
                                                                    <a href="{{route('delete-single-product',[$quotation->customer_id,$quotation->id,$index])}}" class="btn btn-danger">Remove</a>

                                                                    <div class="product_details">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Product Name</label>
                                                                            <input type="text" value="{{$product['product_name']}}" name="product_name[]" class="form-control" >
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="basic-default-company">Product Code</label>
                                                                            <input type="text" value="{{$product['product_code']}}" name="product_code[]" class="form-control" >
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="basic-default-email">Quantity</label>
                                                                            <div class="input-group input-group-merge">
                                                                                <input type="text" value="{{$product['quantity']}}" name="quantity[]" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="basic-default-phone">Unit Price</label>
                                                                            <input type="text" value="{{$product['unit_price']}}" name="unit_price[]" class="form-control phone-mask">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="defaultSelect" class="form-label">Select Unit</label>
                                                                            <select class="form-control" name="unit[]" required="">
                                                                                @foreach($unites as $unit)
                                                                                    <option value="{{$unit->unit}}" {{$product['unit'] == $unit->unit ? 'selected' : ''}}>{{$unit->unit}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="basic-default-message">Product Description</label>
                                                                            <textarea name="product_description[]" class="form-control">{{$product['description']}}</textarea>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
                                                                            <input type="text" value="{{$product['our_coasting']}}" name="costing[]" class="form-control phone-mask">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="basic-default-phone">Product Discount</label>
                                                                            <input type="number" value="{{$product['product_discount']}}" name="product_discount[]" class="form-control phone-mask">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="basic-default-phone">Product Source</label>
                                                                            <input type="text" value="{{$product['product_source']}}" name="product_source[]" class="form-control phone-mask">
                                                                        </div>
                                                                        @if(!empty($product['product_image']))
                                                                            <img src="{{ asset('images/quotationProduct/'. $product['product_image']) }}" width="120px">
                                                                            <input type="file" name="product_image[{{ $index }}]">
                                                                        @else
                                                                            <input type="file" name="product_image[{{ $index }}]" id="product_image_{{ $index }}" class="form-control phone-mask">
                                                                        @endif
                                                                    </div>
                                                                    <strong><hr class="m-4"></strong>
                                                                @endforeach
                                                            </div>
                                                            <button class="btn btn-primary" id="add_product" type="button">Add More</button>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="card-body text-left">
                                                                <h3>Trams And Conditions</h3>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-company">Logo</label>
                                                                    <select required name="logo" class="form-select">
                                                                        <option> </option>
                                                                        <option value="Esmart" {{$quotation->logo == 'Esmart' ? 'selected' : ''}}>Esmart</option>
                                                                        <option value="Conquest Impex" {{$quotation->logo == 'Conquest Impex' ? 'selected' : ''}}>Conquest Impex</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                                                    <input type="text" value="{{$quotation->offer_validity}}" name="offer_validity" class="form-control"  placeholder="30 days">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-company">Warranty</label>
                                                                    <select name="warranty" class="form-select">
                                                                        <option>Select Warranty</option>
                                                                        @foreach($warranties as $warranty)
                                                                            <option value="{{$warranty->warranty}}" {{$quotation->warranty == $warranty->warranty ? 'selected' : ''}}>{{$warranty->warranty}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-company">Payment Type</label>
                                                                    <select name="payment_type" class="form-select">
                                                                        <option>Select Payment</option>
                                                                        @foreach($paymentTypes as $paymentType)
                                                                            <option value="{{$paymentType->payment_type}}" {{$quotation->payment_type == $paymentType->payment_type ? 'selected' : ''}}>{{$paymentType->payment_type}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-phone">
                                                                        vat(7.5%) & Ait(3%)<br>
                                                                             <span>Input Allows (3,7.5,10.5) Pleas Don't Use (%)</span>
                                                                    </label>
                                                                    <input name="vat_tax" value="{{$quotation->vat_tax}}" type="text" class="form-control phone-mask">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-company">Delivery Term</label>
                                                                    <select name="delivery_term" class="form-select">
                                                                        <option>Select Payment</option>
                                                                        @foreach($deliveryTerms as $deliveryTerm)
                                                                            <option value="{{$deliveryTerm->delivery_term}}" {{$quotation->delivery_term == $deliveryTerm->delivery_term ? 'selected' : ''}}>{{$deliveryTerm->delivery_term}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-message">Other Condition</label>
                                                                    <textarea name="other_condition" id="basic-default-message" class="form-control">
                                                                    {{$quotation->other_condition}}
                                                                </textarea>
                                                                </div>
                                                            </div>
                                                            <div class="card-body text-left">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-phone">Delivery Time</label>
                                                                    <input name="delivery_date" value="{{$quotation->delivery_date}}" class="form-control" type="text" >
                                                                </div>
                                                                <div class="form-check mb-3">
                                                                    <input {{$quotation->delivery_check ? 'checked' : ''}} name="delivery_check" class="form-check-input" type="checkbox" value="Delivery Charge Applicable" id="defaultCheck1">
                                                                    <label class="form-check-label" for="defaultCheck1"> Delivery Charge Applicable </label>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                                                    <input type="text" value="{{$quotation->delivery_charge}}" name="delivery_charge" class="form-control phone-mask">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-phone">Discount Amount</label>
                                                                    <input type="number" value="{{$quotation->discount_amount}}" name="discount_amount" class="form-control phone-mask">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-phone">Extra Charge Name</label>
                                                                    <input type="text" value="{{$quotation->extra_charge_name}}" name="extra_charge_name" class="form-control phone-mask">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basic-default-phone">Extra Amount</label>
                                                                    <input type="text" value="{{$quotation->extra_amount}}" name="extra_amount" class="form-control phone-mask">
                                                                </div>
                                                            </div>
                                                            <div class="card-body text-left">
                                                                <label class="form-label" for="basic-default-company">Submitted By</label>
                                                                <select name="submitted_by" id="defaultSelect" class="form-select">
                                                                    <option>Select User</option>
                                                                    @foreach($users as $user)
                                                                        <option value="{{$user->id}}" {{$quotation->user_id == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                                                                    @endforeach
                                                                </select>

                                                                <label class="form-label" for="basic-default-company">Status*</label>
                                                                <select required name="status" id="defaultSelect" class="form-select">
                                                                    <option>Select Status</option>
                                                                    <option value="Sent" {{$quotation->status == 'Sent' ? 'selected' : ''}}>Sent</option>
                                                                    <option value="Not Sent" {{$quotation->status == 'Not Sent' ? 'selected' : ''}}>Not Sent</option>
                                                                </select>

                                                                <input name="customer_id" hidden value="{{$customer_id}}">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="text-center">
                                                        <button class="btn btn-info" type="submit">Update Quotation</button>
                                                    </div>
                                                </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>




{{--Add new product field and remove--}}
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

@include('partials.layoutEnd')
