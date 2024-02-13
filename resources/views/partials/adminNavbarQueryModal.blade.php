<div id="add-query-modal" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Add Query With Customer Information </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{route('admin-add-query-with-customer')}}">
                    @csrf
                    <div class="row p-4">
                        <div class="col-6 text-left" style="border-right: 1px solid #ccc">
                            <h4>Customer Information</h4>
                            <div class="row">
                                <div class="mb-2 col-4">
                                    <div class="input-group">
                                        <label class="input-group-text" for="inputGroupSelect01">Select Product Type*</label>
                                        <select required="" name="type" id="selectCustomerType">
                                            <option selected="">Choose Type</option>
                                            <option value="individual">Individual</option>
                                            <option value="company">Company</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 col-4">
                                    <label class="form-label" for="basic-default-fullname">Full Name/Company Name*</label>
                                    <input required="" name="name" type="text" class="form-control" placeholder="Full Name/ Company Name" wfd-id="id8">
                                </div>
                                <div class="mb-2 col-4">
                                    <label class="form-label" for="basic-default-company">Contact Person Name</label>
                                    <input name="contact_name" type="text" class="form-control" placeholder="" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-2 col-4">
                                    <label class="form-label" for="basic-default-email">Email</label>
                                    <div class="input-group input-group-merge">
                                        <input type="email" name="email" class="form-control" placeholder="john@gmail.com" wfd-id="id10">
                                    </div>
                                </div>
                                <div class="mb-2 col-4">
                                    <label class="form-label" for="basic-default-phone">Phone No*</label>
                                    <input required="" type="text" name="phone" class="form-control phone-mask" placeholder="658 799 8941" wfd-id="id11">
                                </div>
                                <div class="mb-2 col-4">
                                    <label class="form-label" for="basic-default-message">Address*</label>
                                    <textarea required="" name="address" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-2 col-4">
                                    <label class="form-label" for="basic-default-email">City</label>
                                    <div class="input-group input-group-merge">
                                        <input name="city" type="text" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-default-email2" wfd-id="id12">
                                    </div>
                                </div>
                                <div class="mb-2 col-4">
                                    <label class="form-label" for="basic-default-email">Country</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" name="country" class="form-control" placeholder="john.doe" wfd-id="id13">
                                    </div>
                                </div>
                                <div class="mb-2 col-4">
                                    <label class="form-label" for="basic-default-email">Postal Code</label>
                                    <div class="input-group input-group-merge">
                                        <input name="postal_code" type="text" class="form-control" wfd-id="id14">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-left">
                            <h4>Query Information</h4>
                            <div class="row">
                                <div class="col-4 mb-2">
                                    <div class="">
                                        <label for="defaultSelect" class="form-label">Query Source*</label>
                                        <select required="" name="query_source" id="defaultSelect" class="form-select">
                                            <option>Default select</option>
                                            @foreach($querySources as $querySource)
                                                <option value="{{$querySource->query_source}}">{{$querySource->query_source}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 mb-2">
                                    <div class="mb-3">
                                        <label for="defaultSelect" class="form-label">Status*</label>
                                        <select required="" name="status" id="defaultSelect" class="form-select">
                                            <option>Default select</option>
                                            @foreach($statuses as $status)
                                                <option value="{{$status->query_status}}">{{$status->query_status}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="form-label" for="basic-icon-default-message">Query Details*</label>
                                    <div class="input-group input-group-merge">
                                        <textarea required="" id="basic-icon-default-message" name="query_details" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4 mb-2">
                                    <label class="form-label" for="basic-icon-default-email">Product SKU</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" name="product_sku" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="form-label" for="basic-icon-default-email">Product Name*</label>
                                    <div class="input-group input-group-merge">
                                        <input required="" type="text" name="product_name" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="form-label" for="basic-icon-default-email">Product Quantity*</label>
                                    <div class="input-group input-group-merge">
                                        <input required="" type="text" name="product_quantity" class="form-control" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="form-label" for="basic-icon-default-email">Product Category*</label>
                                    <div class="input-group input-group-merge">
                                        <input required="" type="text" name="product_category" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <label for="html5-date-input" class="form-label">Reminder Date</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" name="reminder_date" type="date" id="html5-date-input">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-12 text-center mt-3">
                            <button style="font-size: 18px" class="btn btn-primary" type="submit">Submit</button>
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
