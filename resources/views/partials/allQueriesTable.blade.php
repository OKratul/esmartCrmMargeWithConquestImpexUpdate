<div class="card mb-4 " style="margin-top: 50px">
    <div class="card-header">

{{--   ========= Filter code ===========     --}}
        <form method="GET" action="{{ request()->routeIs('all-query') ? route('all-query') : (request()->routeIs('user-query-export-view') ? route('user-query-export-view') : '#') }}"
        >
            {{csrf_field()}}
            <div class="row">
                <div class="col-4">
                    <div class="">
                        <h3>All Queries</h3>
                        <hr>
                        <a style="font-size: 18px" href="{{request()->routeIs('all-query') ? route('user-query-export') : route('admin-query-export')}}">
                            <i class="fas fa-file-excel"></i> Export
                        </a>
                    </div>
                </div>
                <div class="col-8">
                        <div class="d-flex gap-2 justify-content-end">
                            <div class="d-flex">
                                <span class="m-2">User</span>
                                <select name="user" id="customer" class="form-select" style="width: 200px">
                                    <option>  </option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex">
                                <span class="m-2">Status</span>
                                <select name="status" id="customer" class="form-select" style="width: 200px">
                                    <option>  </option>
                                    @foreach($queryStatus as $status)
                                        <option value="{{$status->query_status}}">{{$status->query_status}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="d-flex align-items-center">
                                    <label for="example-date" class="form-label" style="margin:0">From</label>
                                    <input class="form-control" id="example-date" type="date"  name="date_from">
                                </div>
                                <div class="d-flex align-items-center">
                                    <label for="example-date" class="form-label" style="margin: 0">To</label>
                                    <input class="form-control" id="example-date" type="date" name="date_to">
                                </div>
                                <button class="btn btn-primary" type="submit">
                                    <i class="ti-filter"></i>
                                </button>
                            </div>
                        </div>
                    </div>
            </div>
        </form>
    </div>
    <div class="card-body text-left">
        <div class=" table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Date</th>
                    <th>Company Name</th>
                    <th>Address Phone & Email</th>
                    <th>Query Details</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($queries as $key => $query)
                    <tr class="">
                        <td>
                            @if(!empty($query->users))
                                @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                                    <a target="_blank" href="{{route('admin-user-profile',[$query->user_id])}}">
                                        {{$query->users['name']}}
                                    </a>
                                @else
                                    <h5>
                                        {{$query->users['name']}}
                                    </h5>
                                @endif
                            @else
                                Query Not Assigned
                            @endif

                        </td>
                        <td>
                            <div style="width: 150px">
                                {{date('d M-y',strtotime($query->submit_date))}}<br>
                                <strong>{{date('h:i A',strtotime($query->submit_date))}}</strong>
                            </div>
                        </td>
                        <td>
                            <a style="font-size: 16px" href="{{request()->routeIs('all-query') ? route('user-customer-profile',[$query->customer_id]) :route('customer-profile',[$query->customer_id])}}">
                                {{$query->customers['name']}}
                            </a>
                        </td>
                        <td>
                            {{$query->customers['address']}}, {{$query->customers['city']}},{{$query->customers['country']}}<br>
                            <strong>phone:-</strong> {{$query->customers['phone_number']}}<br>
                            <strong>email:-</strong> {{$query->customers['email']}}
                        </td>
                        <td>
                            <p>
                                {{$query->query_details}}
                            </p>
                            <span>Category:- <strong>{{$query->product_category}}</strong></span><br>
                            @if(!empty($query->product_link))
                                <span>Product link: {{$query->product_link}}</span>
                            @else
                                <span>Product link: Link Not Found</span>
                            @endif
                        </td>

                        <td>
                            {{$query->query_source}}
                        </td>
                        <td>
                            @if($query->status == 'Quotation Sent' )
                                <span class="badge bg-success rounded-pill" style="font-size: 14px">{{$query->status}}</span>
                            @elseif($query->status == 'Processing')
                                <span class="badge bg-primary rounded-pill" style="font-size: 14px">{{$query->status}}</span>
                            @elseif($query->status == 'Closed')
                                <span class="badge bg-danger rounded-pill" style="font-size: 14px">{{$query->status}}</span>
                            @elseif($query->status == 'Order Confirmed')
                                <span class="badge bg-success rounded-pill" style="font-size: 14px">{{$query->status}}</span>
                            @else
                                <span class="badge bg-warning rounded-pill" style="font-size: 14px">{{$query->status}}</span>
                            @endif
                        </td>

                        <td class="">
                            <div style="line-height: 30px" class="text-right">
                                <div class="text-left d-flex gap-1 position-relative">
                                    <button style="width: 45px; height: 45px; padding: 0"
                                        type="button"
                                            class="view btn btn-outline-primary rounded-circle d-flex justify-content-center align-items-center "
                                            data-bs-toggle="modal" data-bs-target="#query-details-modal-{{$query->id}}">
                                        <i class="ti-eye" style="font-size: 20px"></i>
                                    </button>

                                    @if(auth()->check() && $query->user_id == auth()->user()->id)
                                            <button
                                                style="width: 45px; height: 45px; padding: 0"
                                                type="button"
                                                    class=" edit btn btn-outline-dark rounded-circle"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#query-edit-{{$query->id}}">
                                                <i class="ti-pencil-alt2" style="font-size: 20px"></i>
                                            </button>
                                            <a  style="width: 45px; height: 45px; padding: 0"
                                                onclick="return confirm('Are you sure you want to delete this quotation?')"
                                                class="btn btn-outline-danger rounded-circle delete"
                                                href="{{request()->routeIs('all-query')? route('deleteQuery',[$query->id]) : route('admin-deleteQuery', [$query->id]) }}">
                                                <i class="ti-close" style="font-size: 20px"></i>
                                            </a>

                                        @elseif(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                                            <button
                                                style="width: 45px; height: 45px; padding: 0"
                                                type="button"
                                                class="btn btn-outline-dark rounded-circle"
                                                data-bs-toggle="modal"
                                                data-bs-target="#query-edit-{{$query->id}}">
                                                <i class="ti-pencil-alt2" style="font-size: 20px"></i>
                                            </button>
                                            <a  style="width: 45px; height: 45px; padding: 0"
                                                onclick="return confirm('Are you sure you want to delete this quotation?')"
                                                class="btn btn-outline-danger rounded-circle delete"
                                                href="{{request()->routeIs('all-query')? route('deleteQuery',[$query->id]) : route('admin-deleteQuery', [$query->id]) }}">
                                                <i class="ti-close" style="font-size: 20px"></i>
                                            </a>
                                        @endif

                                        <button
                                            style="width: 45px; height: 45px; padding: 0"
                                            type="button"
                                            class="btn btn-outline-dark rounded-circle make-quotation"
                                            data-bs-toggle="modal"
                                            data-bs-target="#make-quotation-{{$query->id}}">
                                            <i class="ti-write" style="font-size: 20px"></i>
                                        </button>

                                </div>


                            </div>
                        </td>
                    </tr>

                    {{--                                                /Modal Div--}}

                @endforeach
                </tbody>
            </table>

            @foreach($queries as $query)

                {{-- Query View  Modal Div--}}

                <div id="query-details-modal-{{$query->id}}" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-full-width">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="fullWidthModalLabel">Query Details</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th>date</th>
                                            <th>User</th>
                                            <th>Query Details</th>
                                            <th>quantity</th>
                                            <th>Product Code</th>
                                            <th>Category</th>
                                            <th>
                                                Source
                                            </th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                {{$query->created_at->format('d-M-Y')}}
                                            </td>
                                            <td>
                                                @if(!empty($query->users))
                                                    {{$query->users['name']}}
                                                @else
                                                    No Assigned
                                                @endif
                                            </td>
                                            <td>
                                                {{$query->query_details}}
                                            </td>
                                            <td>
                                                {{$query->product_quantity}}
                                            </td>
                                            <td>
                                                {{$query->product_sku}}
                                            </td>
                                            <td>
                                                {{$query->product_category}}
                                            </td>
                                            <td>
                                                {{$query->query_source}}
                                            </td>
                                            <td>
                                                <div class="position-relative">
                                                    <button type="button" class="btn btn-info waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-chevron-left"></i> {{$query->status}}
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        @foreach($queryStatus as $status)
                                                            <a class="dropdown-item"
                                                               @if(request()->routeIs('all-query'))
                                                                                   href="{{
                                                                     $status->query_status == 'Processing' ? route('user-status-processing', [$query->id]) :
                                                                    ($status->query_status == 'Quotation Sent' ? route('user-status-quotationSent', [$query->id]) :
                                                                   ($status->query_status == 'Order Confirmed' ? route('user-order-confirmed', [$query->id]) :
                                                                   ($status->query_status == 'Delivery On Going' ? route('user-delivery-on-going', [$query->id]) :
                                                                   ($status->query_status == 'Delivered' ? route('user-delivered', [$query->id]) :
                                                                  ($status->query_status == 'Closed' ? route('user-closed', [$query->id]) : '')))))
                                                                 }}"
                                                               @else
                                                                   href="{{
                                                                         $status->query_status == 'Processing' ? route('status-processing', [$query->id]) :
                                                                        ($status->query_status == 'Quotation Sent' ? route('status-quotationSent', [$query->id]) :
                                                                       ($status->query_status == 'Order Confirmed' ? route('order-confirmed', [$query->id]) :
                                                                       ($status->query_status == 'Delivery On Going' ? route('delivery-on-going', [$query->id]) :
                                                                       ($status->query_status == 'Delivered' ? route('delivered', [$query->id]) :
                                                                      ($status->query_status == 'Closed' ? route('closed', [$query->id]) : '')))))
                                                                     }}"
                                                                @endif
                                                            >

                                                                {{ $status->query_status }}
                                                            </a>

                                                        @endforeach
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                               @if(!empty($query->product_link))
                                                  Product Link:- <a href="{{$query->product_link}}" target="_blank"> {{$query->product_link}}  </a>
                                                @else
                                                    Product Link :- Link Not Found
                                                @endif
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan="2">

                                                @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                                                    <div class="assign-form">
                                                        <div>
                                                            <h4>Transfer Query</h4>
                                                            <form method="POST" action="{{route('assign_query',[$query->id])}}">
                                                                @csrf
                                                                <div class="d-flex">
                                                                    <select name="user" class="form-select">
                                                                        <option selected="">Select User</option>
                                                                        @foreach($users as $user)
                                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <button class="btn btn-primary" type="submit">
                                                                        Submit
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <div class="">
                                        <div class="">
                                            <div class="p-2">
                                                <h3>Add Notes</h3>
                                                <form class="add-note-form" method="POST"
                                                    @if(request()->routeIs('all-query'))
                                                        action="{{route('add-note',[$query->customers['id'],$query->id])}}"
                                                    @else
                                                      action="{{route('admin-add-note',[$query->customers['id'],$query->id])}}"
                                                    @endif
                                                     >
                                                    {{ csrf_field() }}
                                                    <div class="mb-3">
                                                        <label for="example-textarea" class="form-label">Text</label>
                                                        <textarea name="notes" class="form-control rounded" id="modal-note" rows="2" style="width: 50%;"></textarea>
                                                    </div>
                                                    <div>
                                                        <button type="submit" class="btn btn-primary" id="add-note-button">
                                                            Add Note
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                        <div class="p-2">
                                            <div class="notes">
                                                <div class="timeline">
                                                    <article class="timeline-item alt">
                                                        <div class="time-show first">
                                                            <a href="#" class="btn btn-primary width-lg">Notes</a>
                                                        </div>
                                                    </article>
                                                    @if(!empty($query->notes))
                                                        @foreach($query->notes as $index=>$note)
                                                            <article class="timeline-item {{$index % 2 == 1 ? '' : 'alt'}}">
                                                                <div class="timeline-desk position-relative">
                                                                    <div class="panel" style="background: #e5e4e4">
                                                                        <div class="panel-body" style="margin-top: 25px">
                                                                            <span class="arrow-alt"></span>
                                                                            <span class="timeline-icon bg-danger"><i class="mdi mdi-circle"></i></span>
                                                                            <div class="d-flex justify-content-start position-absolute" style="top: 5px;right: 8px;">
                                                                                <button style="width: 30px; height: 30px ; padding: 0px;margin: 5px" class="btn btn-outline-primary rounded-circle waves-effect waves-light text-center">
                                                                                    <i class="ti-pencil" style=""></i>
                                                                                </button>
                                                                                <button style="width: 30px; height: 30px ; padding: 0px; margin: 5px" class="btn btn-outline-danger rounded-circle waves-effect waves-light text-center">
                                                                                    <i class="ti-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <h4>{{$note->user_name}}</h4>
                                                                            <h4 class="text-danger mt-0">{{$note->created_at->format('d-M-Y')}}</h4>
                                                                            <p class="text-blue timeline-date "><small>{{$note->created_at->format('H:i:s A')}}</small></p>
                                                                            <p class="text-black">{{$note->notes}} </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </article>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

{{--                Query Edit Modal--}}

                <div class="modal fade" id="query-edit-{{$query->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0">Update Query</h4>
                                    </div>
                                    <div class="card-body text-left">
                                        @include('error')
                                        @include('success')
                                        <form method="POST" action="{{request()->routeIs('all-query')? route('user-updateQuery',[$query->id]) :route('admin-updateQuery',[$query->id])}}">
                                            {{csrf_field()}}
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <div class="mb-3">
                                                        <label for="defaultSelect" class="form-label">Query Source*</label>
                                                        <select required name="query_source" id="defaultSelect" class="form-select">
                                                            <option> </option>
                                                            @foreach($querySources as $querySource)
                                                                <option value="{{$querySource->query_source}}" {{$query->query_source == $querySource->query_source ? 'selected' : ''}} >{{$querySource->query_source}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-6">
                                                    <div class="mb-3">
                                                        <label for="defaultSelect" class="form-label">Status*</label>
                                                        <select required name="status" id="defaultSelect" class="form-select">
                                                            <option></option>
                                                            @foreach($queryStatus as $status)
                                                                <option value="{{$status->query_status}}" {{$status->query_status == $query->status ? 'selected' : ''}} > {{$status->query_status}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-12">
                                                    <label class="form-label" for="basic-icon-default-message">Query Details*</label>
                                                    <div  class="input-group input-group-merge">
                                                        <textarea required id="basic-icon-default-message" name="query_details" class="form-control">
                                                            {{$query->query_details}}
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-icon-default-email">Product Name*</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" value="{{$query->product_name}}" name="product_name" class="form-control" required >
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-icon-default-email">Product Quantity*</label>
                                                    <div class="input-group input-group-merge">
                                                        <input value="{{$query->product_quantity}}" required type="text" name="product_quantity" class="form-control" >
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-icon-default-email">Product sku</label>
                                                    <div class="input-group input-group-merge">
                                                        <input value="{{$query->product_sku}}" type="number" name="product_sku" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="basic-icon-default-email">Product Category*</label>
                                                    <div class="input-group input-group-merge">
                                                        <input value="{{$query->product_category}}" required type="text" id="category-input" name="product_category" class="form-control" >
                                                        <div id="category-dropdown"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <div class="">
                                                        <label for="html5-date-input" class="form-label">Reminder Date</label>
                                                        <input @if($query->reminer_date) {{$query->reminder_date}}@endif class="form-control" name="reminder_date" type="date" id="html5-date-input">
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <div class="">
                                                        <label for="html5-date-input" class="form-label">Submit Date*</label>
                                                        <input value="@if($query->submit_date) {{$query->submit_date}} @endif" class="form-control" name="submit_date" type="date" id="html5-date-input" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update Query</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

{{--           Make Quotaion Modal     --}}
                <div id="make-quotation-{{$query->id}}" class="modal fade" tabindex="-1" aria-labelledby="fullWidthModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-full-width">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="fullWidthModalLabel">Make New Quotation</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="">
                                    <form method="POST" action="
                                                                                    @if(request()->routeIs('admin-view-add-quotation'))
                                                                                        {{ route('admin-quotation-add-profile', [$id]) }}
                                                                                    @elseif(request()->routeIs('admin-all-query'))
                                                                                        {{ route('admin-quotation-add-profile', [$query->customer_id]) }}
                                                                                    @else
                                                                                        {{ route('user-quotation-add-profile', [$query->customer_id]) }}
                                                                                    @endif

                                                                                    " enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="col-xl-6" style="border-right: 1px solid #cccccc">
                                                <div class="card-body text-left query_quot_queryToQuotationGenerator" >
                                                    <h3>Product Details</h3>
                                                    <div class="query_quot_product-details">
                                                        <div class="row">
                                                            <div class="mb-3 col-4">
                                                                <label class="form-label">Product Name*</label>
                                                                <input required type="text" name="product_name[]" class="form-control" >
                                                            </div>
                                                            <div class="mb-3 col-4">
                                                                <label class="form-label" for="basic-default-company">Product Code*</label>
                                                                <input type="text" required name="product_code[]" class="form-control" >
                                                            </div>
                                                            <div class="mb-3 col-4">
                                                                <label class="form-label" for="basic-default-email">Quantity*</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input type="text" required name="quantity[]" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-4">
                                                                <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                                                <input required type="text" name="unit_price[]" class="form-control phone-mask">
                                                            </div>
                                                            <div class="mb-3 col-4">
                                                                <label for="defaultSelect" class="form-label">Select Unit*</label>
                                                                <select required class="form-control" name="unit[]" required="">
                                                                    @foreach($unites as $unit)
                                                                        <option value="{{$unit->unit}}">{{$unit->unit}} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-4">
                                                                <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
                                                                <input type="text" name="costing[]" class="form-control phone-mask">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="mb-3 col-8">
                                                                <label class="form-label" for="basic-default-message">Product Description</label>
                                                                <textarea name="product_description[]" class="form-control"></textarea>
                                                            </div>
                                                            <div class="mb-3 col-4">
                                                                <label class="form-label" for="basic-default-phone">Product Discount</label>
                                                                <input type="text" name="product_discount[]" class="form-control phone-mask">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-6">
                                                                <label class="form-label" for="basic-default-phone">Product Source</label>
                                                                <input type="text" name="product_source[]" class="form-control phone-mask">
                                                            </div>
                                                            <div class="mb-3 col-6">
                                                                <label class="form-label" for="basic-default-phone">Product image</label>
                                                                <input type="file" name="product_image[]" class="form-control phone-mask">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <strong><hr class="m-4"></strong>
                                                </div>
                                                <button class="btn btn-primary query_quot_add-product" id="" type="button">Add More</button>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="card-body text-left">

                                                    <div class="row">
                                                        <div class="mb-3 col-6">
                                                            <label class="form-label" for="basic-default-fullname">Select Logo Type*</label>
                                                            <select required name="logo" id="customer" class="form-select">
                                                                <option> </option>
                                                                <option value="Esmart">Esmart</option>
                                                                <option value="Conquest Impex">Conquest Impex</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-6">
                                                            <label class="form-label" for="basic-default-fullname">Phone Number</label>
                                                            <input type="text" name="phone_number" class="form-control"  placeholder="Phone number">
                                                        </div>
                                                    </div>

                                                    <h3>Trams And Conditions</h3>

                                                    <div class="row">
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-fullname">Offer Validity</label>
                                                            <input type="text" name="offer_validity" class="form-control"  placeholder="30 days">
                                                        </div>
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-company">Warranty*</label>
                                                            <select required name="warranty" id="defaultSelect" class="form-select">
                                                                <option> </option>
                                                                @foreach($warranties as $warranty)
                                                                    <option value="{{$warranty->warranty}}">{{$warranty->warranty}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-company">Payment Type*</label>
                                                            <select required name="payment_type" id="defaultSelect" class="form-select">
                                                                <option> </option>
                                                                @foreach($paymentTypes as $paymentType)
                                                                    <option value="{{$paymentType->payment_type}}">{{$paymentType->payment_type}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-phone">vat(7.5%) & Ait(3%)</label>
                                                            <input name="vat_tax" type="text" class="form-control phone-mask">
                                                        </div>
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-company">Delivery Term*</label>
                                                            <select name="delivery_term" id="defaultSelect" class="form-select">
                                                                <option> </option>
                                                                @foreach($deliveryTerms as $deliveryTerm)
                                                                    <option required value="{{$deliveryTerm->delivery_term}}">{{$deliveryTerm->delivery_term}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-phone">Delivery Time</label>
                                                            <input name="delivery_date" class="form-control" type="text" >
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mb-3 col-6">
                                                            <label class="form-label" for="basic-default-message">Other Condition</label>
                                                            <textarea name="other_condition" id="basic-default-message" class="form-control"></textarea>
                                                        </div>
                                                        <div class="form-check mb-3 col-3">
                                                            <input name="delivery_check" class="form-check-input" type="checkbox" value="Delivery Charge Applicable" id="defaultCheck1">
                                                            <label class="form-check-label" for="defaultCheck1"> Delivery Charge Applicable </label>
                                                        </div>
                                                        <div class="mb-3 col-3">
                                                            <label class="form-label" for="basic-default-phone">Delivery Charge</label>
                                                            <input type="text" name="delivery_charge" class="form-control phone-mask">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-phone">Discount Amount</label>
                                                            <input type="number" name="discount_amount" class="form-control phone-mask">
                                                        </div>
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-phone">Extra Charge Name</label>
                                                            <input type="text" name="extra_charge_name" class="form-control phone-mask">
                                                        </div>
                                                        <div class="mb-3 col-4">
                                                            <label class="form-label" for="basic-default-phone">Extra Amount</label>
                                                            <input type="text" name="extra_amount" class="form-control phone-mask">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-label" for="basic-default-company">Submitted By*</label>
                                                            <select name="submitted_by" required id="defaultSelect" class="form-select">
                                                                <option> </option>
                                                                @foreach($users as $user)
                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label" for="basic-default-company">Status*</label>
                                                            <select name="status" id="defaultSelect" class="form-select">
                                                                <option> </option>
                                                                <option value="Sent">Sent</option>
                                                                <option value="Not Sent">Not Sent</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-info" type="submit">Add Quotation</button>
                                        </div>
                                    </form>


                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>


            @endforeach

        </div>
    </div>
</div>
{{ $queries->links('pagination::bootstrap-5') }}


<script type="text/javascript">

    // ======== Quotation product details =======
    document.addEventListener('DOMContentLoaded', function () {
        let addButtons = document.querySelectorAll('.query_quot_add-product');

        addButtons.forEach(function (addButton) {
            addButton.addEventListener('click', function () {
                let productContainer = this.previousElementSibling; // Assuming the button is placed just before the product details container

                let addProductDiv = document.createElement('div');
                addProductDiv.classList.add('query_quot_product-details');

                addProductDiv.innerHTML = `
                    <div class="mb-3">
                        <!-- Add remove button -->
                        <button class="query_quot_remove_product btn btn-danger">Remove</button>
                    </div>
                    <div class="row">
                                                            <div class="mb-3 col-4">
                                                                <label class="form-label">Product Name*</label>
                                                                <input required type="text" name="product_name[]" class="form-control" >
                                                            </div>
                                                            <div class="mb-3 col-4">
                                                                <label class="form-label" for="basic-default-company">Product Code*</label>
                                                                <input type="text" required name="product_code[]" class="form-control" >
                                                            </div>
                                                            <div class="mb-3 col-4">
                                                                <label class="form-label" for="basic-default-email">Quantity*</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input type="text" required name="quantity[]" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-4">
                                                                <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                                                <input required type="text" name="unit_price[]" class="form-control phone-mask">
                                                            </div>
                                                            <div class="mb-3 col-4">
                                                                <label for="defaultSelect" class="form-label">Select Unit*</label>
                                                                <select required class="form-control" name="unit[]" required="">
                                                                    @foreach($unites as $unit)
                <option value="{{$unit->unit}}">{{$unit->unit}} </option>
                                                                    @endforeach
                </select>
            </div>
            <div class="mb-3 col-4">
                <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
                <input type="text" name="costing[]" class="form-control phone-mask">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-8">
                <label class="form-label" for="basic-default-message">Product Description</label>
                <textarea name="product_description[]" class="form-control"></textarea>
            </div>
            <div class="mb-3 col-4">
                <label class="form-label" for="basic-default-phone">Product Discount</label>
                <input type="text" name="product_discount[]" class="form-control phone-mask">
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-6">
                <label class="form-label" for="basic-default-phone">Product Source</label>
                <input type="text" name="product_source[]" class="form-control phone-mask">
            </div>
            <div class="mb-3 col-6">
                <label class="form-label" for="basic-default-phone">Product image</label>
                <input type="file" name="product_image[]" class="form-control phone-mask">
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
