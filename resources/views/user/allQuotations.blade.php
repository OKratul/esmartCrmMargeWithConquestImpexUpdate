@include('partials.layoutHead')

<div id="wrapper">

    @include('user.partials.navbar')
    @include('user.partials.sidebar')


    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="customers">
                    <div class="card p-4">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card ">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="date-filter ">
                                            <form method="GET" action="{{request()->routeIs('user-view-all-quotation')? route('user-view-all-quotation') : route('admin-all-quotation')}}">
                                                {{csrf_field()}}
                                                <div class="mb-3 row">
                                                    <div class="col-md-10 d-flex align-items-end gap-2">
                                                        <div class="" style="width: 300px">
                                                            <label for="inputState" class="form-label">User</label>
                                                            <select id="inputState" name="by_user" class="form-select">
                                                                <option> </option>
                                                                @foreach($users as $user)
                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="" style="width: 300px">
                                                            <label for="inputState" class="form-label">Status</label>
                                                            <select id="inputState" name="by_status" class="form-select">
                                                                <option>   </option>
                                                                <option value="Sent">Sent</option>
                                                                <option value="Not Sent ">Not Sent</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <span class="m-2">From</span><input name="date_from" class="form-control" type="date" id="html5-date-input">
                                                        </div>
                                                        <div>
                                                            <span class="m-2">to</span><input name="date_to" class="form-control" type="date" id="html5-date-input">
                                                        </div>
                                                        <div>
                                                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light">
                                                                <i style="font-size: 18px" class="fe-filter "></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <h4 class="p-2">All Quotation</h4>
                                            <hr>
                                        </div>
                                        <div class="col-8">
                                            <div class="d-flex justify-content-end gap-2 mb-3">
                                                <div class="p-2"
                                                     style="border-left: 3px solid #000;
                                             background: rgba(241, 196, 15, 0.3);
                                             width: 200px">
                                                    <h4>{{$totalQuotation}}</h4>
                                                    <h5 class="">Total Quotations </h5>
                                                </div>
                                                <div class="p-2" style="border-left: 3px solid #000; background: rgba(13,106,244,0.3);  width: 200px">
                                                    <h4>$ {{floor($totalQuotationValue)}}</h4>
                                                    <h5>Total Quotation Value</h5>
                                                </div>
                                                <div class="p-2" style="border-left: 3px solid #000; background: rgba(124,252,0,0.3);  width: 200px">
                                                    <h4>$ {{floor($totalSentValue)}}</h4>
                                                    <h5>Sent Quotation</h5>
                                                    <h4>{{count($quotationSents)}}</h4>
                                                </div>
                                                <div class="p-2" style="border-left: 3px solid #000; background: rgba(0,128,0,0.3);  width: 200px">
                                                    <h4>$ {{floor($totalQuotationNotSentValue)}}</h4>
                                                    <h5>Quotation Not Sent</h5>
                                                    <h4>{{count($quotationNotSents)}}</h4>
                                                </div>
                                                <div class="p-2" style="border-left: 3px solid #000; background: rgba(255,0,0,0.3);  width: 200px">
                                                    <h4>{{count($closedQueries)}}</h4>
                                                    <h5>Closed Queries </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                            <tr>
                                                <th>
                                                    Created At
                                                </th>
                                                <th>
                                                    User
                                                </th>
                                                <th>
                                                    Quot Num
                                                </th>
                                                <th>
                                                    Client
                                                </th>
                                                <th>
                                                    Products
                                                </th>
                                                <th>
                                                    Status
                                                </th>
                                                <th>
                                                    Delivery Time
                                                </th>
                                                <th>
                                                    Actions
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            @foreach($quotations as $key => $quotation)
                                                <tr class="{{$quotation->status == 'Sent' ? 'bg-label-success': ''}}">
                                                    <td>
                                                        {{ date('Y-m-d', strtotime($quotation->created_at)) }}<br>
                                                        {{ $quotation->created_at->format('h:i A') }}
                                                    </td>
                                                    <td>
                                                        {{$quotation->users['name']}}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            {{$quotation->quotation_number}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            Name:  <a target="_blank" href="{{request()->routeIs('user-view-all-quotation')?route('user-customer-profile',[$quotation->customer_id]) :route('customer-profile',[$quotation->customer_id])}}">
                                                                {{$quotation->customers['name']}}
                                                            </a><br>
                                                            Phone: {{$quotation->customers['phone_number']}}<br>
                                                            Email: {{$quotation->customers['email']}}<br>
                                                        </div>
                                                    </td>
                                                    <td class="text-left" >
                                                        <div style="height: 150px; overflow-y: scroll; width: 300px; overflow-x: auto">
                                                            @php
                                                                $products = json_decode($quotation->products, true);
                                                            @endphp
                                                            @foreach($products as $product)
                                                                <p style="word-wrap: break-word;"><strong>Name:</strong>{{$product['product_name']}}</p>
                                                                <p><strong>Code:-</strong>{{$product['product_code']}}</p>
                                                                <p><strong>Unit Price:-</strong>{{$product['unit_price']}}</p>
                                                                @if(!empty($product['product_image']))
                                                                    <img style="width: 150px" src="{{asset('images/quotationProduct/'.$product['product_image'])}}">
                                                                @endif
                                                                <hr>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span style="font-size:16px;" class="badge rounded-pill {{$quotation->status == 'Sent' ? 'bg-success' : 'bg-warning'}}">
                                                            {{$quotation->status}}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{$quotation->delivery_date}}
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <div class="d-flex gap-1">
                                                                <a style="width: 45px; height: 45px; padding: 0"
                                                                   class="btn btn-outline-primary rounded-circle view" target="_blank"
                                                                   href="{{request()->routeIs('user-view-all-quotation') ? route('view-quotation-pdf',[$quotation->customer_id,$quotation->id]) :route('admin-view-quotation-pdf',[$quotation->customer_id,$quotation->id])}}">
                                                                    <i class="fe-eye" style="font-size: 20px; margin-top: 10px;"></i>
                                                                </a>
                                                                <button style="width: 45px; height: 45px; padding: 0" type="button"
                                                                        class="btn btn-outline-info rounded-circle edit"
                                                                        data-bs-toggle="modal" data-bs-target="#edit-quotation-form-{{$quotation->id}}">
                                                                    <i class="fe-edit-1" style="font-size: 20px"></i>
                                                                </button>

                                                                <a style="width: 45px; height: 45px; padding: 0"
                                                                   onclick="return confirm('Are you sure you want to delete this quotation?')"
                                                                   class="btn btn-outline-danger rounded-circle delete"
                                                                   href="{{request()->routeIs('user-view-all-quotation')? route('user-delete-quotation',[$quotation->customer_id, $quotation->id]) : route('delete-quotation', [$quotation->customer_id, $quotation->id]) }}">
                                                                    <i class="fe-trash-2" style="font-size: 20px; margin-top: 10px"></i>
                                                                </a>
                                                            </div>

                                                            <div class="d-flex gap-1 mt-1">
                                                                <button style="width: 45px; height: 45px; padding: 0" type="button"
                                                                        class="make-invoice btn btn-outline-secondary rounded-circle "
                                                                        data-bs-toggle="modal" data-bs-target="#invoice-from-quotation-{{$quotation->id}}">
                                                                    <i class="fe-file-text" style="font-size: 20px;margin-top: 10px;"></i>
                                                                </button>

                                                                <a style="width: 45px; height: 45px; padding: 0"
                                                                   class="btn btn-outline-success rounded-circle sent-mail"
                                                                   href="{{request()->routeIs('user-view-all-quotation')? route('sent-quotation-mail',[$quotation->customer_id,$quotation->id]) :route('admin-sent-quotation-mail',[$quotation->customer_id,$quotation->id])}}">
                                                                    <i class="fe-send" style="font-size: 20px;margin-top: 10px"></i>
                                                                </a>
                                                                <a style="width: 45px; height: 45px; padding: 0"
                                                                   class="btn btn-outline-dark rounded-circle download"
                                                                   href="{{route('generate-pdf-download',[$quotation->customer_id,$quotation->id])}}">
                                                                    <i class="fe-download" style="font-size: 20px;margin-top: 10px"></i>
                                                                </a>
                                                            </div>

                                                            <div class=" mt-1">
                                                                <button style="width: 45px; height: 45px; padding: 0" type="button"
                                                                        class="btn btn-outline-warning rounded-circle history"
                                                                        data-bs-toggle="modal" data-bs-target="#quotation-history-{{$quotation->id}}">
                                                                    <i class="fe-watch" style="font-size: 20px;margin-top: 10px;"></i>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="text-center">
                                    {{$quotations->links('pagination::bootstrap-5')}}
                                </div>
                            </div>
                            {{--             Edit Quotation               --}}
                            <div>
                                @include('partials.customerProfileEditQuotation')
                            </div>
                            {{--======= Invoice From Quoptation ========--}}


                            {{--========= Invoice From Quotation ============--}}
                            @if(!empty($quotations))
                                @foreach($quotations as $quotation)
                                    <div id="invoice-from-quotation-{{$quotation->id}}" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-full-width">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="fullWidthModalLabel">Make Invoice From Quotation (#{{$quotation->quotation_number}})</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{request()->routeIs('user-view-all-quotation') ? route('generate-new-invoice',[$quotation->customer_id]) : route('generate-new-invoice',[$quotation->customer_id])}}">
                                                        {{csrf_field()}}
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="card-body text-left" id="productDetailsContainerInvoice">
                                                                    <h3>Product Details</h3>
                                                                    @php
                                                                        $products = json_decode($quotation->products, true);
                                                                        $products = array_values(array_filter($products)); // Remove empty string element
                                                                    @endphp
                                                                    @foreach($products as $index => $product)
                                                                        @if(!empty($product))
                                                                            <div class="quot_invoice_product_details">
                                                                                <a
                                                                                    href="{{request()->routeIs('user-view-all-quotation')? route('delete-single-product',[$quotation->customer_id,$quotation->id,$index]) : route('admin-delete-single-product',[$quotation->customer_id,$quotation->id,$index])}}"
                                                                                    class="btn btn-danger">Remove</a>

                                                                                <div class="row">
                                                                                    <div class="mb-3 col-4">
                                                                                        <label class="form-label">Product Name*</label>
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
                                                                                        <input required type="text" value="{{$product['unit_price']}}" name="unit_price[]" class="form-control phone-mask">
                                                                                    </div>
                                                                                    <div class="mb-3 col-4">
                                                                                        <label for="defaultSelect" class="form-label">Select Unit*</label>
                                                                                        <select class="form-control" name="unit[]" required>
                                                                                            @foreach($unites as $unit)
                                                                                                <option value="{{$unit->unit}}" {{$product['unit'] == $unit->unit ? 'selected' : ''}}>{{$unit->unit}}</option>
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
                                                                <button class="btn btn-primary quot_invoice_add-product" type="button">Add More</button>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="card-body text-left">

                                                                    <div class="row">
                                                                        <div class="mb-3 col-6">
                                                                            <label class="form-label" for="basic-default-fullname">Select Logo Type*</label>
                                                                            <select required="" name="logo" id="customer" class="form-select">
                                                                                <option>---------</option>
                                                                                <option {{$quotation->logo == 'Esmart' ? 'selected' : ''}} value="Esmart">Esmart</option>
                                                                                <option {{$quotation->logo == 'Conquest Impex' ? 'selected' : ''}} value="Conquest Impex">Conquest Impex</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3 col-6">
                                                                            <label class="form-label" for="basic-default-phone">Phone No</label>
                                                                            <input type="text" name="phone" class="form-control phone-mask" placeholder="658 799 8941">
                                                                        </div>
                                                                    </div>

                                                                    <h3>Trams And Conditions</h3>

                                                                    <div class="row">
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                                                            <input type="text" value="{{$quotation->offer_validity}}" name="offer_validity" class="form-control"  placeholder="30 days">
                                                                        </div>
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-company">Warranty</label>
                                                                            <select name="warranty" class="form-select">
                                                                                <option>Select Warranty</option>
                                                                                @foreach($warranties as $warranty)
                                                                                    <option value="{{$warranty->warranty}}" {{$quotation->warranty == $warranty->warranty ? 'selected' : ''}}>{{$warranty->warranty}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-company">Payment Type</label>
                                                                            <select name="payment_type" class="form-select">
                                                                                <option>Select Payment</option>
                                                                                @foreach($paymentTypes as $paymentType)
                                                                                    <option value="{{$paymentType->payment_type}}" {{$quotation->payment_type == $paymentType->payment_type ? 'selected' : ''}}>{{$paymentType->payment_type}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-company">Delivery Term </label>
                                                                            <select name="delivery_term" class="form-select">
                                                                                <option>Select delivery Term</option>
                                                                                @foreach($deliveryTerms as $deliveryTerm)
                                                                                    <option {{$quotation->delivery_term == $deliveryTerm->delivery_term ? 'selected' : ''}} value="{{$deliveryTerm->delivery_term}}" >{{$deliveryTerm->delivery_term}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-phone">vat(7.5%) & Ait(3%)</label>
                                                                            <input name="vat_tax" step="any" value="{{$quotation->vat_tax}}" type="text" class="form-control phone-mask">
                                                                        </div>
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-message">Other Condition</label>
                                                                            <textarea name="other_condition" id="basic-default-message" class="form-control">
                                                                                {{$quotation->other_condition}}
                                                                             </textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-left">
                                                                    <div class="row">
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                                                            <input type="number" value="{{$quotation->delivery_charge}}" name="delivery_charge" class="form-control phone-mask">
                                                                        </div>
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-phone">Delivery Date</label>
                                                                            <input name="delivery_date" value="{{$quotation->delivery_date}}" class="form-control" type="date" >
                                                                        </div>
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-phone">Discount Amount</label>
                                                                            <input type="text" value="{{$quotation->discount_amount}}" name="discount_amount" class="form-control phone-mask">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-phone">Extra Charge Name</label>
                                                                            <input type="text" value="{{$quotation->extra_charge_name}}" name="extra_charge_name" class="form-control phone-mask">
                                                                        </div>
                                                                        <div class="mb-3 col-4">
                                                                            <label class="form-label" for="basic-default-phone">Extra Amount</label>
                                                                            <input type="text" value="{{$quotation->extra_amount}}" name="extra_amount" class="form-control phone-mask">
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label class="form-label" for="basic-default-company">Select User</label>
                                                                            <select name="created_by" id="user-select" class="form-select">
                                                                                <option>Select User</option>
                                                                                @foreach($users as $user)
                                                                                    <option {{$quotation->user_id == $user->id ? 'selected' : ''}} value="{{$user->name}}">{{$user->name}}</option>
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

                                    <div id="quotation-history-{{$quotation->id}}" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-full-width">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="fullWidthModalLabel">Quotation History of {{$quotation->quotation_number}}</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped mb-0 table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>User Name</th>
                                                            <th>Old Data</th>
                                                            <th>Edited Data</th>
                                                            <th>Updated At</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="table-border-bottom-0">
                                                        @foreach($quotation->histories()->orderByDesc('updated_at')->get() as $key => $history)
                                                            @php
                                                                $oldData = json_decode($history->old_data, true);
                                                                $oldProducts = json_decode($oldData['products'], true);
                                                                $newData = json_decode($history->new_data, true);
                                                                $newProducts = json_decode($newData['products'], true);
                                                            @endphp
                                                            <tr class="text-left">
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>
                                                                    @if(!empty($history->users['name']))
                                                                        {{$history->users['name']}}
                                                                    @else
                                                                        Admin
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="old-data">
                                                                        @foreach($oldProducts as $oldProduct)
                                                                            <strong>Product Info:-</strong>{{$oldProduct['product_name']}}<br>
                                                                            Code:- {{$oldProduct['product_code']}}<br>
                                                                            Quantity:-{{$oldProduct['quantity']}}.{{$oldProduct['unit']}}<br>
                                                                            Unit Price:-{{$oldProduct['unit_price']}}<br>
                                                                            Description:-{{$oldProduct['description']}}<br>
                                                                            Our Coasting:-{{$oldProduct['our_coasting']}}<br>
                                                                            Source:-{{$oldProduct['product_source']}}<br>
                                                                            Discount:-{{$oldProduct['product_discount']}}<br>
                                                                        @endforeach
                                                                        <strong>Offer Validity:-</strong>{{$oldData['offer_validity']}}<br>
                                                                        <strong>Warranty:-</strong>{{$oldData['warranty']}}<br>
                                                                        <strong>Payment Type:-</strong>{{$oldData['payment_type']}}<br>
                                                                        <strong>Vat & AIT:-</strong>{{$oldData['vat_tax']}}<br>
                                                                        <strong>Delivery Term:-</strong>{{$oldData['delivery_term']}}<br>
                                                                        <strong>Other Condition:-</strong>{{$oldData['other_condition']}}<br>
                                                                        <strong>Delivery Date:-</strong>{{$oldData['delivery_date']}}<br>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="old-data">
                                                                        @foreach($newProducts as $newProduct)
                                                                            <strong>Product Info:-</strong>{{$newProduct['product_name']}}<br>
                                                                            Code:- {{$newProduct['product_code']}}<br>
                                                                            Quantity:-{{$newProduct['quantity']}}.{{$newProduct['unit']}}<br>
                                                                            Unit Price:-{{$newProduct['unit_price']}}<br>
                                                                            Description:-{{$newProduct['description']}}<br>
                                                                            Our Coasting:-{{$newProduct['our_coasting']}}<br>
                                                                            Source:-{{$newProduct['product_source']}}<br>
                                                                            Discount:-{{$newProduct['product_discount']}}<br>
                                                                        @endforeach
                                                                        <strong>Offer Validity:-</strong>{{$newData['offer_validity']}}<br>
                                                                        <strong>Warranty:-</strong>{{$newData['warranty']}}<br>
                                                                        <strong>Payment Type:-</strong>{{$newData['payment_type']}}<br>
                                                                        <strong>Vat & AIT:-</strong>{{$newData['vat_tax']}}<br>
                                                                        <strong>Delivery Term:-</strong>{{$newData['delivery_term']}}<br>
                                                                        <strong>Other Condition:-</strong>{{$newData['other_condition']}}<br>
                                                                        <strong>Delivery Date:-</strong>{{$newData['delivery_date']}}<br>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $date = new DateTime($newData['updated_at']);
                                                                        $formattedDate = $date->format('Y-m-d h:i:s A');
                                                                    @endphp
                                                                    {{$formattedDate}}
                                                                </td>
                                                            </tr>


                                                        @endforeach
                                                        </tbody>
                                                    </table>
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
                                @if(!empty($products))
                                    <script type="text/javascript">

                                        // ======== Quotation product details =======
                                        document.addEventListener('DOMContentLoaded', function () {
                                            let addButtons = document.querySelectorAll('.quot_invoice_add-product');

                                            addButtons.forEach(function (addButton) {
                                                addButton.addEventListener('click', function () {
                                                    let productContainer = this.previousElementSibling; // Assuming the button is placed just before the product details container

                                                    let addProductDiv = document.createElement('div');
                                                    addProductDiv.classList.add('quot_invoice_product_details');

                                                    addProductDiv.innerHTML = `
                                                            <div class="mb-3">
                                                                <!-- Add remove button -->
                                                                <button class="query_quot_remove_product btn btn-danger">Remove</button>
                                                            </div>

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
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>


@include('user.partials.rightbar')


@include('partials.layoutEnd')

<!-- Include the diff-match-patch library -->
{{--<script src="path/to/diff_match_patch.js"></script>--}}


<script>
    $(document).ready(function () {
        // Function to highlight differences between two strings
        function highlightDifferences(oldText, newText) {
            var dmp = new diff_match_patch();
            var diffs = dmp.diff_main(oldText, newText);
            dmp.diff_cleanupSemantic(diffs);

            var highlightedText = '';
            for (var i = 0; i < diffs.length; i++) {
                var diffType = diffs[i][0]; // 0: equal, 1: insert, -1: delete
                var diffText = diffs[i][1];

                if (diffType === 1) {
                    highlightedText += '<ins style="background-color: #aaffaa;">' + diffText + '</ins>';
                } else if (diffType === -1) {
                    highlightedText += '<del style="background-color: #ffaaaa;">' + diffText + '</del>';
                } else {
                    highlightedText += diffText;
                }
            }

            return highlightedText;
        }

        // Iterate through each pair of old and new data
        $(".old-data").each(function () {
            var oldText = $(this).html();
            var newText = $(this).next(".new-data").html();
            var highlightedText = highlightDifferences(oldText, newText);
            $(this).html(highlightedText);
        });
    });
</script>

