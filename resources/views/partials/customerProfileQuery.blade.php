<div class="table-responsive">
    <table class="table table-striped mb-0">
        <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Query Details</th>
            <th>Query Source</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($allQueries as $key=>$query)
            <tr>
                <td>
                    {{$loop->iteration}}
                </td>
                <td>
                    {{$query->submit_date}}
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
                    {{$query->status}}
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <button type="button" class="btn btn-primary mb-2 view" data-bs-toggle="modal" data-bs-target="#query-details-{{$query->id}}">
                            <i class="dripicons-preview" style="font-size: 20px"></i>
                        </button>

                        @if(\Illuminate\Support\Facades\Auth::check())
                            @if(\Illuminate\Support\Facades\Auth::user()->id == $query->user_id
                                || \Illuminate\Support\Facades\Auth::guard('admin')->check())
                                <button type="button" class="btn btn-info edit mb-2 " data-bs-toggle="modal" data-bs-target="#query-edit-{{$query->id}}">
                                    <i class="ti-pencil-alt" style="font-size: 20px;"></i>
                                </button>
                        
                                <a class="btn btn-danger delete mb-2"
                                    onclick="return confirm('Are you sure you want to delete this quotation?')"
                                    href="{{route('deleteQuery',[$query->id])}}"
                                >
                                    <i class="ti-close" style="font-size: 20px"></i>
                                </a>
                            @endif
                        @endif


                        <button type="button" class="btn btn-info mb-2 note" data-bs-toggle="modal" data-bs-target="#centermodal-{{$query->id}}">
                            <i class="dripicons-blog" style="font-size: 20px"></i>
                        </button>
                    </div>
                </td>
            </tr>
                <tr>
                    <td colspan="5">
                        <div class="timeline">
                            <article class="timeline-item alt">
                                <div class="time-show first">
                                    <a href="#" class="btn btn-primary width-lg">Notes</a>
                                </div>
                            </article>
                            @foreach($query->notes->sortBy(function ($note) {
                                              return $note->created_at;
                                          })->reverse() as $index => $note)

                                <article class="timeline-item {{$index % 2 == 0 ? '' : 'alt'}}">
                                    <div class="timeline-desk position-relative">
                                        <div class="panel" style="background: #e5e4e4">
                                            <div class="panel-body" style="margin-top: 25px">
                                                <span class="arrow-alt"></span>
                                                <span class="timeline-icon bg-danger"><i class="mdi mdi-circle"></i></span>
                                                <div class="d-flex justify-content-start position-absolute" style="top: 5px;right: 8px;">

                                                  
                                                        <button style="width: 30px; height: 30px ; padding: 0px;margin: 5px"
                                                                class="btn btn-outline-primary rounded-circle waves-effect waves-light text-center"
                                                                data-bs-toggle="modal" data-bs-target="#edit-note-{{$note->id}}"
                                                        >
                                                            <i class="ti-pencil" style=""></i>
                                                        </button>
                                                        <a  onclick="return confirm('Are you sure to delete this note')"
                                                            href="{{route('delete-note',[$note->id])}}"
                                                            style="width: 30px; height: 30px ; padding: 0px; margin: 5px" class="btn btn-outline-danger rounded-circle waves-effect waves-light text-center">
                                                            <i class="ti-close"></i>
                                                        </a>
                                                    

                                                </div>
                                                <h4>{{$note->user_name}}</h4>
                                                <h4 class="text-danger mt-0">{{$note->created_at->format('d-M-Y')}}</h4>
                                                <p class="text-blue timeline-date "><small>{{$note->created_at->format('H:i:s A')}}</small></p>
                                                <p class="text-black">{{$note->notes}} </p>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                                <div class="modal fade" id="edit-note-{{$note->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myCenterModalLabel">Update Note</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="add-note-form" method="POST"   @if(request()->routeIs('customer-profile'))
                                                        action="{{route('admin-update-note',[$note->id])}}"
                                                      @else
                                                        action="{{route('user-update-note',[$note->id])}}"
                                                @endif>
                                                    {{ csrf_field() }}
                                                    <div>
                                                        <textarea class="form-control rounded" name="notes" rows="3">
                                                            {{$note->notes}}
                                                        </textarea>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button type="submit" class="btn btn-success">
                                                            Submit
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>

                            @endforeach

                        </div>
                    </td>
                </tr>
        @endforeach
        </tbody>
    </table>

    {{--=================== Query Note Modal==============--}}
    @foreach($allQueries as $query)

{{--    ========== Query Edit Modal ========== --}}

    
            <div class="modal fade" id="query-edit-{{$query->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
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
                                    <form method="POST" action="{{ request()->routeIs('user-customer-profile')? route('user-updateQuery',[$query->id]):route('admin-updateQuery',[$query->id])}}">
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <div class="mb-3">
                                                    <label for="defaultSelect" class="form-label">Query Source*</label>
                                                    <select required name="query_source" id="defaultSelect" class="form-select">
                                                        <option> </option>
                                                        @foreach($querySources as $querySource)
                                                            <option {{$query->query_source == $querySource->query_source ? 'selected' : ''}} value="{{$querySource->query_source}}">{{$querySource->query_source}}</option>
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
                                                            <option {{$query->status == $status->query_status ? 'selected' : ''}} value="{{$status->query_status}}"> {{$status->query_status}}</option>
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

                                                    <input required type="text" value="{{$query->product_quantity}}" name="product_quantity" class="form-control" >

                                                </div>
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label" for="basic-icon-default-email">Product sku</label>
                                                <div class="input-group input-group-merge">

                                                    <input type="number" value="{{$query->product_sku}}" name="product_sku" class="form-control" >

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
                                                    <input value="{{$query->reminder_date}}" class="form-control" name="reminder_date" type="date" id="html5-date-input">
                                                </div>
                                            </div>
                                            <div class="mb-3 col-4">
                                                <div class="">
                                                    <label for="html5-date-input" class="form-label">Submit Date*</label>
                                                    <input class="form-control" value="{{$query->submit_date}}" name="submit_date" type="date" id="html5-date-input">
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
    

        {{--        Add Note Modal --}}

        <div class="modal fade" id="centermodal-{{$query->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myCenterModalLabel">Add Note</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="add-note-form" method="POST" action="{{request()->routeIs('user-customer-profile',[$customer->id])?route('add-note',[$customer->id,$query->id]) :route('admin-add-note',[$query->customer_id,$query->id])}}">
                            {{ csrf_field() }}
                            <div>
                                <textarea class="form-control" name="notes" rows="3"></textarea>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

{{--    Edit Note Modal--}}

    @endforeach
    {{--============================ View Query Modal =======================--}}
    <div class="query-modal">
        @foreach($allQueries as $query)
            <div class="modal fade" id="query-details-{{$query->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Query Details</h4>
                            <div>
                                <div class="position-relative">
                                    <button type="button" class="btn btn-info waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-chevron-left"></i> Change Status
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        @foreach($queryStatus as $status)
                                            <a class="dropdown-item"
                                               @if(request()->routeIs('user-customer-profile'))
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

                                    <button type="button" class="btn-close " style="margin-left: 10px;" data-bs-dismiss="modal" aria-label="Close">

                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>user</th>
                                        <th>Query Details</th>
                                        <th>Category</th>
                                        <th>SKU</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">
                                            {{$query->created_at->format('d-M-Y')}}<br>
                                            {{$query->created_at->format('h:i a')}}
                                        </th>
                                        <td>
                                            @if(!empty($query->users))
                                                {{$query->users['name']}}
                                            @else
                                                -------
                                            @endif
                                        </td>
                                        <td>
                                            {{$query->query_details}}
                                        </td>
                                        <td>
                                            {{$query->product_category}}
                                        </td>
                                        <td>
                                            {{$query->product_sku}}
                                        </td>
                                    </tr>
                                    @if($query->product_link)
                                        <tr>
                                            <td colspan="4">
                                                {{$query->product_link}}
                                            </td>
                                        </tr>
                                    @endif
                                    @if(!empty($quoery->notes))
                                        <tr>
                                            <td onclospan="5">
                                                User:- {{$query->notes['user_name']}}
                                                Note:- {{$query->notes['notes']}}
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
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

                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        @endforeach
    </div>

</div>
