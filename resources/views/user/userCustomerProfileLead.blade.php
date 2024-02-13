@include('user.partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-2">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="customer-profile-sidebar">
                                        <ul style="padding: 0px">
                                            <li>
                                                <a href="{{route('user-customer-profile',[$customer_id])}}"><i class='bx bx-user-circle me-1' ></i> Profile</a>
                                            </li>
                                            <li class="active-2">
                                                <a href="{{route('user-view-all-query',[$customer_id])}}"><i class='bx bx-notepad me-1'></i>Lead/Query</a>
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
                        <div class="col-xl-10">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">Add Query</h4>
                                    <h4><a class="" href="{{route('user-view-all-query',[$customer_id])}}">Go to All Query</a></h4>
                                </div>
                                <div class="card-body text-left">
                                    @include('error')
                                    @include('success')
                                    <form method="POST"
                                    @if(request()->routeIs('user-query-add-form-profile'))
                                        action="{{route('user-add-query-profile',[$customer_id])}}"
                                          @else
                                        action="{{route('add-query-profile',[$customer_id])}}"
                                    @endif
                                        >
                                        {{csrf_field()}}
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="defaultSelect" class="form-label">Query Source*</label>
                                                <select required name="query_source" id="defaultSelect" class="form-select">
                                                    <option>Default select</option>
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
                                                    <option>Default select</option>
                                                    @foreach($statuses as $status)
                                                        <option value="{{$status->query_status}}">{{$status->query_status}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-message">Query Details*</label>
                                            <div class="input-group input-group-merge">
                                                <textarea required id="basic-icon-default-message" name="query_details" class="form-control"></textarea>
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
                                            <label class="form-label" for="basic-icon-default-email">Product sku</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" name="product_sku" class="form-control" >
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
                                            <label for="html5-date-input" class="col-md-2 col-form-label">Reminder Date</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="reminder_date" type="date" value="2021-06-18" id="html5-date-input">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="html5-date-input" class="col-md-2 col-form-label">Submit Date</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="submit_date" type="date" value="2021-06-18" id="html5-date-input">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Query</button>
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

@include('partials.layoutEnd')
