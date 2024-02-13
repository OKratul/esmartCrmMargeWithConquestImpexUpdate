@include('user.partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    @include('error')
                    @include('success')
                    <div class="customers">
                        <div class="card p-4">
                            <div class="row">
                                <div class="col-xl-12">
                                    @include('error')
                                    @include('success')
                                    <div class="card mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">

                                            <a href="{{route('user-view-query-form')}}" class="text-white btn btn-primary">Add New <i class='bx bx-plus'></i></a>
                                            <h4 class="mb-0">Total Query:- {{$totalQuery}}</h4>
                                            <div class="status-filter">


                                            </div>
                                            <div class="date-filter p-2">
                                                <form method="GET" action="{{route('my-queries')}}">
                                                    {{csrf_field()}}
                                                    <div class="mb-3 row">
                                                        <div class="col-md-10 d-flex">
                                                            <span class="m-2">Status</span>
                                                            <select name="status" id="customer" class="form-select" style="width: 200px">
                                                                <option> </option>
                                                                @foreach($statuses as $status)
                                                                    <option value="{{$status->query_status}}">{{$status->query_status}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="m-2">From</span><input name="date_from" class="form-control" type="date" id="html5-date-input">
                                                            <span class="m-2">to</span><input name="date_to" class="form-control" type="date" id="html5-date-input">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class='bx bx-filter-alt' ></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-body text-left">
                                            <table class="table table-responsive table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>submit date</th>
                                                    <th>Client</th>
                                                    <th>Query Details</th>
                                                    <th>Source</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($queries as $key => $query)
                                                    <tr>
                                                        <td>
                                                            @if(!empty($query->users))
                                                                {{$query->users['name']}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{date('d M Y',strtotime($query->created_at))}}<br>
                                                            <strong>
                                                                {{date(' h:i A',strtotime($query->created_at))}}
                                                            </strong>
                                                        </td>
                                                        <td>
                                                            {{$query->customers['name']}}<br>
                                                            {{$query->customers['address']}}, {{$query->customers['city']}},{{$query->customers['country']}}<br>
                                                            <strong>phone:-</strong> {{$query->customers['phone_number']}}<br>
                                                            <strong>email:-</strong> {{$query->customers['email']}}
                                                        </td>
                                                        <td>
                                                            <p>
                                                                {{$query->query_details}}
                                                            </p>
                                                            <p>
                                                               Category:- <strong>{{$query->product_category}}</strong>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            {{$query->query_source}}
                                                        </td>
                                                        <td>
                                                            @if($query->status == 'Quotation Sent' )
                                                                <span class="bg-label-success rounded p-1">{{$query->status}}</span>
                                                            @elseif($query->status == 'Processing')
                                                                <span class="bg-label-primary p-1 rounded">{{$query->status}}</span>
                                                            @elseif($query->status == 'Closed')
                                                                <span class="bg-label-danger p-1 rounded">{{$query->status}}</span>
                                                            @elseif($query->status == 'Order Confirmed')
                                                                <span class="bg-label-success p-1 rounded">{{$query->status}}</span>
                                                            @else
                                                                <span class="bg-label-secondary p-1 rounded">{{$query->status}}</span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <div style="line-height: 30px" class="text-right">
                                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exLargeModal-{{$query->id}}">
                                                                    View
                                                                </button>
                                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#noteModal-{{$query->id}}">
                                                                    Note
                                                                </button>
                                                                @if(\Illuminate\Support\Facades\Auth::user()->id == $query->user_id)
                                                                    <a class="btn btn-sm btn-primary" href="{{route('user-showUpdateQuery',[$query->id])}}">Edit</a><br>
                                                                    <a  onclick="return confirm('Are you sure you want to delete this quotation?')"  class="btn btn-sm btn-danger" href="{{route('deleteQuery',[$query->id])}}">
                                                                        Delete
                                                                    </a>
                                                                @endif

                                                                <a class="btn btn-sm btn-primary" href="{{route('user-view-add-quotation',[$query->customer_id])}}">
                                                                    Make Quot.
                                                                </a><br>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        Req.For.Trans
                                                                    </button>
                                                                    <div class="dropdown-menu p-3" style=" width: 250px">
                                                                        <form method="POST" action="{{route('req-for-trans',[$query->id])}}">
                                                                            {{csrf_field()}}
                                                                            <div class="d-flex">
                                                                                <div class="mb-3">
                                                                                    <select name="req_user_id" id="defaultSelect" class="form-select form-select-sm">
                                                                                        <option>Select User</option>
                                                                                        @foreach($users as $user)
                                                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div>
                                                                                    <button type="submit" class="btn btn-sm btn-success">
                                                                                        <i class='bx bx-user-check'></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                            {{--================ Note Model ===============--}}

                                                    <div class="modal fade" id="noteModal-{{$query->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <form method="POST" action="{{route('add-note',[$query->customers['id'],$query->id])}}">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel3">Add Query Note</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col mb-3">
                                                                                <label for="nameLarge" class="form-label">Note</label>
                                                                                <textarea name="notes" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                            Close
                                                                        </button>
                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>



                                                    {{--                                                Modal Div--}}
                                                    <div class="modal fade" id="exLargeModal-{{$query->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">

                                                                </div>
                                                                <hr>
                                                                <div class="modal-body ">
                                                                    <div class="text-center">
                                                                        <h4>Query Details:</h4>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <h6>Customer Name:- {{$query->customers['name']}}</h6>
                                                                            <h6>Email:- {{$query->customers['email']}}</h6>
                                                                            <h6>Phone:- {{$query->customers['phone_number']}}</h6>
                                                                            <h6>Addres:- {{$query->customers['address']}}</h6>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <p>Product Name:- {{$query->product_name}}</p>
                                                                            <p>Product Sku:- {{$query->product_sku}}</p>
                                                                            <p>Product Quantity:- {{$query->product_quantity}}</p>
                                                                            <p>Status:- {{$query->status}}</p>
                                                                            <p>Source:- {{$query->query_source}}</p>
                                                                            <p>Details:- {{$query->query_details}}</p>
                                                                            <p><strong>Product Category:- {{$query->product_category}}</strong></p>
                                                                            <h5>Quotation Reminder:- {{$query->reminder_date}}</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--                                                /Modal Div--}}

                                                    <tr class="add-note-row d-none">
                                                        <td colspan="8">
                                                            <form class="add-note-form" method="POST" action="{{route('add-note',[$query->customers['id'],$query->id])}}">
                                                                {{ csrf_field() }}
                                                                <div>
                                                                    <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                                                                    <textarea class="form-control" name="notes" rows="3"></textarea>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <button type="submit" class="btn btn-success">
                                                                        Submit
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger remove-query-note-form">
                                                                        Remove
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="text-center">Notes</td>
                                                    </tr>
                                                    @foreach($query->notes->sortBy(function ($note) {
                                                             return $note->date;
                                                         })->reverse() as $note)
                                                        <tr>
                                                            <td colspan="5">{{$note->notes}}</td>
                                                            <td>{{$note->user_name}}</td>
                                                            <td>{{$note->date}}</td>
                                                            <td class="text-right">
                                                                <button class="btn btn-sm btn-info">
                                                                    <a class="text-white" href="">edit</a>
                                                                </button>
                                                                <button class="btn btn-sm btn-danger">
                                                                    <a class="text-white" onclick="return confirm('Are you sure you want to delete this quotation?')" href="{{route('delete-note',[$note->id])}}">delete</a>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="8">
                                                            <hr>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{$queries->links()}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@include('user.partials.layoutEnd')

