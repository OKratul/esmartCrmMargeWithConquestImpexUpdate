<div>
    {{-- ========================= Add Query Modal--}}
    <div class="modal fade" id="query" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Add Query</h4>
                        </div>
                        <div class="card-body text-left">
                            @include('error')
                            @include('success')
                            <form method="POST" action="{{ request()->routeIs('user-customer-profile')? route('user-add-query-profile',[$id]):route('add-query-profile',[$id])}}">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-6 mb-3">
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
                                    <div class="mb-3 col-6">
                                        <div class="mb-3">
                                            <label for="defaultSelect" class="form-label">Status*</label>
                                            <select required name="status" id="defaultSelect" class="form-select">
                                                <option></option>
                                                @foreach($statuses as $status)
                                                    <option value="{{$status->query_status}}"> {{$status->query_status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label class="form-label" for="basic-icon-default-message">Query Details*</label>
                                        <div  class="input-group input-group-merge">
                                            <textarea required id="basic-icon-default-message" name="query_details" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-icon-default-email">Product Name*</label>
                                        <div class="input-group input-group-merge">

                                            <input type="text" name="product_name" class="form-control" required >

                                        </div>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-icon-default-email">Product Quantity*</label>
                                        <div class="input-group input-group-merge">

                                            <input required type="text" name="product_quantity" class="form-control" >

                                        </div>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-icon-default-email">Product sku</label>
                                        <div class="input-group input-group-merge">

                                            <input type="number" name="product_sku" class="form-control" >

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-icon-default-email">Product Category*</label>
                                        <div class="input-group input-group-merge">
                                            <input required type="text" id="category-input" name="product_category" class="form-control" >
                                            <div id="category-dropdown"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <div class="">
                                            <label for="html5-date-input" class="form-label">Reminder Date</label>
                                            <input class="form-control" name="reminder_date" type="date" id="html5-date-input">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <div class="">
                                            <label for="html5-date-input" class="form-label">Submit Date*</label>
                                            <input class="form-control" name="submit_date" type="date" id="html5-date-input">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Query</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    {{-- ==================== Add Quotation Modal--}}
    <div id="quotation" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-full-width">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="fullWidthModalLabel">Add New Quotation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('partials.customerQuotationForm')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    {{-- =================== Add Invoice Modal--}}
    <div id="invoice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-full-width">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="fullWidthModalLabel">Generate New Invoice</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('partials.customerProfileInvoiceForm')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>




