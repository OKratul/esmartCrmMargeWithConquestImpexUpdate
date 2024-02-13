@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @if(request()->routeIs('user-view-query-form'))
            @include('user.partials.sidebar')
        @else
            @include('partials.sidebar')
        @endif
        <div class="layout-page">
             @if(request()->routeIs('user-view-query-form'))
                    @include('user.partials.navbar')
                @else
                    @include('partials.navbar')
                @endif
            
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    @include('error')
                    @include('success')
                    <div class="customers">
                        <div class="card p-4">
                            <form method="POST"
                            @if(request()->routeIs('user-view-query-form'))
                                action="{{route('user-add-query')}}"
                                @else
                                action="{{route('admin-add-query-with-customer')}}"
                                @endif
                            >
                                {{csrf_field()}}
                                <div class="row p-4">
                                    <div class="col-xl-6 text-left">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="defaultSelect" class="form-label">Query Source*</label>
                                                <select required name="query_source" id="defaultSelect" class="form-select">
                                                    <option> </option>
                                                    @foreach($querySources as $querySource)
                                                        <option value="{{$querySource->query_source}}">{{$querySource->query_source}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="defaultSelect" class="form-label">Status*</label>
                                                <select required name="status" id="defaultSelect" class="form-select">
                                                    <option> </option>
                                                    @foreach($statuses as $status)
                                                        <option value="{{$status->query_status}}">{{$status->query_status}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-message">Query Details*</label>
                                            <div class="input-group input-group-merge">
                                                <textarea required name="query_details" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product SKU</label>
                                            <div class="input-group input-group-merge">
                                                <input type="number" name="product_sku" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product Name*</label>
                                            <div class="input-group input-group-merge">
                                                <input required type="text" name="product_name" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product Quantity*</label>
                                            <div class="input-group input-group-merge">
                                                <input required type="text" name="product_quantity" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product Category*</label>
                                            <div class="input-group input-group-merge">
                                                <input required type="text" name="product_category" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product Link</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" name="product_link" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="html5-date-input" class="form-label">Reminder Date</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" name="reminder_date" type="date" id="html5-date-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 text-left">
                                        <h4>Customer Information</h4>
                                        <div class="mb-4">
                                            <div class="input-group">
                                                <label class="input-group-text" for="inputGroupSelect01">Select Customer type</label>
                                                <select name="type" id="selectCustomerType">
                                                    <option selected="">Choose Type</option>
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
                                            <label class="form-label" for="basic-default-email">Email</label>
                                            <div class="input-group input-group-merge">
                                                <input type="email" name="email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-default-email2">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-phone">Phone No*</label>
                                            <input type="number" name="phone" required class="form-control phone-mask" placeholder="658 799 8941">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-message">Address*</label>
                                            <textarea required name="address" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-email">City</label>
                                            <div class="input-group input-group-merge">
                                                <input name="city" type="text" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-default-email2">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-email">Country</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" name="country" class="form-control" placeholder="john.doe">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-email">Postal Code</label>
                                            <div class="input-group input-group-merge">
                                                <input name="postal_code" type="number" class="form-control">
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@include('partials.layoutEnd')


