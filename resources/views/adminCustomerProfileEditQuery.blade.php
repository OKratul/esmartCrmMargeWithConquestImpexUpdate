@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @if(request()->routeIs('admin-customer-show-edit-query'))
            @include('partials.sidebar')
        @else
            @include('user.partials.sidebar')
        @endif

        <div class="layout-page">

            @if(request()->routeIs('admin-customer-show-edit-query'))
                @include('partials.navbar')
            @else
                @include('user.partials.navbar')
            @endif

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="customer-profile-sidebar">
                                        <ul>
                                            <li>
                                                <a href="{{route('customer-profile',[$customer_id])}}"><i class='bx bx-user-circle me-1' ></i> Profile</a>
                                            </li>
                                            <li>
                                                <a href="{{route('view-all-query',[$customer_id])}}"><i class='bx bx-notepad me-1'></i>Lead/Query</a>
                                            </li>
                                            <li>
                                                <a href="{{route('customer-all-quotations',[$customer_id])}}"><i class='bx bxs-file-pdf me-1'></i>All Quotations</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin-customer-all-invoice',[$customer_id])}}"><i class='bx bx-food-menu me-1'></i> Invoices</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin-customer-all-payment',[$customer_id])}}"><i class='bx bxs-badge-dollar me-1'></i> payments</a>
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
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">Add Query</h4>
                                    <h4><a class="" href="{{route('user-view-all-query',[$customer_id])}}">Go to All Query</a></h4>
                                </div>
                                <div class="card-body text-left">
                                    @include('error')
                                    @include('success')
                                    <form method="POST" action="{{ request()->routeIs('admin-customer-show-edit-query') ? route('admin-updateQuery',[$query->id]) : route('user-updateQuery',[$query['id']])}}">
                                        {{csrf_field()}}
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="defaultSelect" class="form-label">Query Source</label>
                                                <select name="query_source" id="defaultSelect" class="form-select">
                                                    <option>Default select</option>
                                                    @foreach($querySources as $querySource)
                                                        <option value="{{$querySource->query_source}}" {{$query['query_source'] == $querySource->query_source ? 'selected' : ''}}>{{$querySource->query_source}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="defaultSelect" class="form-label">Status</label>
                                                <select name="status" id="defaultSelect" class="form-select">
                                                    <option>Default select</option>
                                                    @foreach($statuses as $status)
                                                        <option value="{{$status->query_status}}" {{$query['status'] == $status->query_status ? 'selected' : ''}}>
                                                            {{$status->query_status}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-message">Query Details</label>
                                            <div class="input-group input-group-merge">
                                                <textarea id="basic-icon-default-message" name="query_details" class="form-control">
                                                    {{$query['query_details']}}
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product Name</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" name="product_name" value="{{$query['product_name']}}" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product Quantity</label>
                                            <div class="input-group input-group-merge">
                                                <input type="number" value="{{$query['product_quantity']}}" name="product_quantity" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product sku</label>
                                            <div class="input-group input-group-merge">
                                                <input type="number" name="product_sku" value="{{$query['product_sku']}}" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product Category</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" value="{{$query['product_category']}}" name="product_category" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="html5-date-input" class="col-md-2 col-form-label">Reminder Date</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="reminder_date" type="date" value="{{$query['reminder_date']}}" id="html5-date-input">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="html5-date-input" class="col-md-2 col-form-label">Submit Date</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="submit_date" type="date" value="{{$query['submit_date']}}" id="html5-date-input">
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
