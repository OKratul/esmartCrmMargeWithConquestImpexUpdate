@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @if(request()->routeIs('user-showUpdateQuery'))
            @include('user.partials.sidebar')
        @else
            @include('partials.sidebar')
        @endif
        <div class="layout-page">
            @if(request()->routeIs('admin-showUpdateQuery'))
                @include('partials.navbar')
            @else
            @include('user.partials.navbar')
            @endif
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    @include('error')
                    @include('success')
                    <div class="customers">
                        <div class="card p-4">
                            <div class="d-flex justify-content-end">
                                @if(request()->routeIs('user-showUpdateQuery'))
                                <a class="btn btn-primary mr-5" href="{{route('all-query')}}">all query</a>
                                <a class="btn btn-primary"  href="{{route('my-queries')}}">my query</a>
                                @else
                                    <a class="btn btn-primary mr-5" href="{{route('admin-all-query')}}">all query</a>
                                @endif
                            </div>
                            <form method="POST" action="@if(request()->routeIs('admin-showUpdateQuery'))
                                {{route('admin-updateQuery',[$query['id']])}}
                                @else
                                {{route('user-updateQuery',[$query['id']])}}
                                @endif
                                ">
                                {{csrf_field()}}
                                <div class="row p-4">
                                    <div class="col-xl-6 text-left">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="defaultSelect" class="form-label">Query Source</label>
                                                <select name="query_source" id="defaultSelect" class="form-select">
                                                    <option>Default select</option>
                                                    @foreach($querySources as $querySource)
                                                        <option value="{{$querySource->query_source}}" {{$query->query_source == $querySource->query_source ? 'selected' : ''}}>{{$querySource->query_source}}</option>
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
                                                        <option value="{{$status->query_status}}" {{$query->status == $status->query_status ? 'selected' : ''}}>{{$status->query_status}}</option>
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
                                            <label class="form-label" for="basic-icon-default-email">Product SKU</label>
                                            <div class="input-group input-group-merge">
                                                <input type="number" name="product_sku" value="{{$query['product_sku']}}" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product Name*</label>
                                            <div class="input-group input-group-merge">

                                                <input required value="{{$query['product_name']}}" type="text" name="product_name" class="form-control" >

                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product Quantity*</label>
                                            <div class="input-group input-group-merge">
                                                <input required value="{{$query['product_quantity']}}" type="text" name="product_quantity" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-icon-default-email">Product Category*</label>
                                            <div class="input-group input-group-merge">
                                                <input required value="{{$query['product_category']}}" type="text" name="product_category" class="form-control" >
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
                                                <input class="form-control" name="reminder_date" type="date" value="{{$query['reminder_date']}}" id="html5-date-input">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="html5-date-input" class="col-md-2 col-form-label">Submit Date</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="submit_date" type="date" value="{{$query['submit_date']}}" id="html5-date-input">
                                            </div>
                                        </div>
                                       <div class="text-center">
                                           <button type="submit" class="btn btn-primary">
                                               Update
                                           </button>
                                       </div>
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


