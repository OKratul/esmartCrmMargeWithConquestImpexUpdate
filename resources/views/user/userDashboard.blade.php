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

                <div class="row">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="d-flex justify-content-between mb-3">
                                            <div>
                                                <h2 class="card-title text-primary">
                                                    @if(now()->format('H:i') < '12:00')
                                                        Good Morning 🎉</h2>
                                                @elseif(now()->format('H:i') < '17:00')
                                                    Good Afternoon 🎉</h2>
                                                @else
                                                    Good Evening 🎉</h2>
                                                @endif
                                            </div>
                                            <div>
                                                <form action="{{route('user-dashboard')}}" method="GET">
                                                    @csrf
                                                    <div class="d-flex">
                                                        <div class="mr-2 d-flex align-items-center">
                                                            <label for="example-date" class="form-label" style="margin-right: 5px">From</label>
                                                            <input class="form-control" id="example-date" type="date" name="query_date_form">
                                                        </div>
                                                        <div class="mr-2 d-flex align-items-center">
                                                            <label for="example-date" class="form-label" style="margin-right: 5px">To</label>
                                                            <input class="form-control" id="example-date" type="date" name="query_date_to">
                                                        </div>
                                                        <button class="btn btn-primary" type="submit">
                                                            <i class="fas fa-filter"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">

                                            <div class="card " style="border-left:5px solid #F39C12 ; background: rgba(252, 159, 18, 0.3) ">
                                                <div class="card-body">
                                                    <h4>{{count($pendingQueries)}}</h4>
                                                    <h5>Pending Queries</h5>
                                                </div>
                                            </div>

                                            @php
                                                $statusColorMap = [
                                                    'Processing' => 'rgba(86, 139, 245, 0.5)',
                                                    'Quotation Sent' => 'rgba(242, 202, 0, 0.3)',
                                                    'Order Confirmed' => 'rgba(144, 255, 59, 0.3)',
                                                    'Delivery On Going' => 'rgba(112, 250, 255, 0.3)',
                                                    'Delivered' => 'rgba(7, 181, 48, 0.3)',
                                                    'Closed' => 'rgba(230, 55, 7, 0.3)',
                                                ];
                                            @endphp

                                            @foreach($statusCounts as $statusCount)
                                                @php
                                                    $backgroundColor = $statusColorMap[$statusCount['statusName']] ?? '';
                                                @endphp

                                                <div class="card"
                                                     style="border-left: 3px solid #0d6af4; background: {{ $backgroundColor }}; width: 150px">
                                                    <div class="card-body">
                                                        <h6>{{ $statusCount['statusName'] }}</h6>
                                                        <h5>{{ $statusCount['count'] }}</h5>
                                                    </div>
                                                </div>
                                            @endforeach




                                        </div>
                                        <h4 class="mt-0 header-title">All Queries</h4>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 mb-2">
                                                @php
                                                    $statuses = \App\Models\QueryStatus::all();
                                                @endphp
                                                <div id="datatable_filter" class="dataTables_filter">
                                                    <form action="{{route('user-dashboard')}}" method="GET">
                                                        @csrf
                                                        <div class="d-flex">
                                                            <select name="status" class="form-select">
                                                                <option >Select Status</option>
                                                                @foreach($statuses as $status)
                                                                    <option value="{{$status->query_status}}">{{$status->query_status}}</option>
                                                                @endforeach
                                                                <option value="Pending">Pending</option>
                                                            </select>
                                                            <button class="btn btn-primary" type="submit">
                                                                <i class="fas fa-filter"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="table-content">
                                            @include('partials.queryTable')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div>
                                                        <form action="{{route('user-dashboard')}}" method="GET">
                                                            @csrf
                                                            <div class="d-flex">
                                                                <div class="mr-2 d-flex align-items-center">
                                                                    <label for="example-date" class="form-label" style="margin-right: 5px">From</label>
                                                                    <input class="form-control" id="example-date" type="date" name="payment_date_form">
                                                                </div>
                                                                <div class="mr-2 d-flex align-items-center">
                                                                    <label for="example-date" class="form-label" style="margin-right: 5px">To</label>
                                                                    <input class="form-control" id="example-date" type="date" name="payment_date_to">
                                                                </div>
                                                                <button class="btn btn-primary" type="submit">
                                                                    <i class="fas fa-filter"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-6 mt-3 bg-success">
                                                    <div>
                                                        <h4>
                                                            BDT {{floor($totalInvoiceSell)}}
                                                        </h4>
                                                        <h5>
                                                            Total Sales
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-6 mt-3 bg-primary">
                                                    <div>
                                                        <h4>
                                                            BDT 155452
                                                        </h4>
                                                        <h5>
                                                            Total Quotation
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-6 mt-3 bg-danger">
                                                    <div>
                                                        <h4>
                                                            BDT 155452
                                                        </h4>
                                                        <h5>
                                                            Total Due
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-6 mt-3 bg-warning">
                                                    <div class="">
                                                        <h4>
                                                            BDT 155452
                                                        </h4>
                                                        <h5>
                                                            Sales
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div>
                                                <h3>Last Payments</h3>
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <thead class="table-dark">
                                                        <tr>
                                                            <th>date</th>
                                                            <th>Invo. No</th>
                                                            <th>Customer Name</th>
                                                            <th>Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($payments as $payment)
                                                            <tr>
                                                                <td>{{$payment->created_at->format('Y-M-d')}}</td>
                                                                <td>{{$payment->invoices['invoice_no']}}</td>
                                                                <td>{{$payment->customers['name']}}</td>

                                                                <td>
                                                                    {{$payment->amount}}
                                                                </td>

                                                                <td>
                                                                    <button type="button" class="btn btn-info view" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg-{{$payment->id}}">
                                                                        <i class="fas fa-eye" style="font-size: 20px"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                        <div class="payment-pagination">
                                                            {{$payments->links('pagination::bootstrap-5')}}
                                                        </div>
                                                    </table>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                        </div>
                    </div>
                </div>

                @foreach($payments as $payment)

                    {{-- =========== Modal  Contant =========--}}

                    <div class="modal fade" id="bs-example-modal-lg-{{$payment->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">Payment Details</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                            <tr>
                                                <th>Invoice No</th>
                                                <th>Customer Details</th>
                                                <th>Payment Details</th>
                                                <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">
                                                    {{$payment->invoices['invoice_no']}}
                                                </th>
                                                <td>
                                                    {{$payment->customers['name']}}<br>
                                                    {{$payment->customers['phone_number']}}<br>
                                                    {{$payment->customers['email']}}
                                                </td>
                                                <td>
                                                    Pay With:- {{$payment->payment_with}}
                                                    Bank Name:- {{$payment->bank_name}}
                                                    Ref No:- {{$payment->Ref_no}}
                                                    Payment Note:- {{$payment->payment_note}}
                                                </td>
                                                <td>
                                                    Tk.{{$payment->amount}}/-
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>

                @endforeach


                <div class="row">
{{--                    Pending Queries--}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <h3>Total Pending Queries
                                        <button type="button" class="btn btn-warning waves-effect waves-light">
                                            <strong style="font-size: 18px">
                                                {{count($pendingQueries)}}
                                            </strong>
                                        </button>
                                    </h3>
                                    <table class="table table-striped mb-0">
                                        <thead class="table-dark">
                                        <tr>
                                            <th>Date</th>
                                            <th>Query Details</th>
                                            <th>Customer Details</th>
                                            <th>Query Source</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pendingQueries as $query)
                                            <tr>
                                                <td class="align-middle">
                                                    {{$query->created_at->format('d-M-Y')}}<br>
                                                    {{$query->created_at->format('h:i:s A')}}<br>
                                                </td>
                                                <td>
                                                    {{$query->query_details}}<br>
                                                    Product Name:- {{$query->query_details}}<br>
                                                    Product Code:- {{$query->product_sku}}<br>
                                                </td>
                                                <td class="align-middle">
                                                    Name:- {{$query->customers['name']}}<br>
                                                    Phone:- {{$query->customers['phone_number']}}<br>

                                                </td>
                                                <td class="align-middle">
                                                    {{$query->query_source}}
                                                </td>

                                                <td class="align-middle">
                                                    <a style="width: 150px"
                                                       href="{{route('query-self-assign',[$query->id])}}"
                                                       class="btn btn-success rounded-pill waves-effect waves-light">
                                                        Self Assign
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    {{$pendingQueries->links('pagination::bootstrap-5')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
{{--                        Task List --}}
                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <h3>Task List
                                                <button type="button" class="btn btn-warning waves-effect waves-light">
                                                    <strong style="font-size: 18px">
                                                        {{count($tasks)}}
                                                    </strong>
                                                </button>
                                            </h3>
                                            <table class="table table-striped mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Assign Date</th>
                                                        <th>Submit Date</th>
                                                        <th>Task Details</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($tasks as $task)
                                                    <tr>
                                                        <td>
                                                            {{$task->start_date}}<br>
                                                        </td>
                                                        <td>
                                                            @if(!empty($task->end_date))
                                                                {{$task->end_date}}<br>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <h4>{{$task->title}}</h4>
                                                            {{$task->description}}
                                                        </td>
                                                        <td>
                                                            {{$task->status}}
                                                        </td>
                                                        <td>
                                                            @if($task->status == 'done')
                                                                <a href="{{route('task-undone',[$task->id])}}" class="btn btn-warning rounded-pill waves-effect waves-light">
                                                                    <i style="font-size: 18px" class="fe-corner-up-left"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{route('task-done',[$task->id])}}" class="btn btn-success rounded-pill waves-effect waves-light">
                                                                    <i style="font-size: 18px" class="fe-check"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--===== Query Reminder--}}
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>
                                            Query Reminder
                                            <button type="button" class="btn btn-warning waves-effect waves-light">
                                                <strong style="font-size: 18px">
                                                    {{count($queryReminders)}}
                                                </strong>
                                            </button>
                                        </h3>
                                        <table class="table table-striped mb-0">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Created At</th>
                                                    <th>Query Details</th>
                                                    <th>Customer Details</th>
                                                    <th>Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($queryReminders as $query)
                                                <tr>
                                                    <td>
                                                        {{$query->created_at->format('d-M-Y')}}
                                                    </td>
                                                    <td>
                                                        Product Name:- {{$query->product_name}}<br>
                                                        Details:- {{$query->query_details}}<br>
                                                    </td>
                                                    <td>
                                                        Name:- {{$query->customers['name']}}
                                                        Phone:- {{$query->customers['phone_number']}}
                                                    </td>
                                                    <td>
                                                        {{$query->product_quantity}}
                                                    </td>
                                                    <td>
                                                        <div style="line-height: 30px" class="text-right">
                                                            <div class="text-left d-flex gap-1">
                                                                <button style="width: 45px; height: 45px; padding: 0"
                                                                        type="button"
                                                                        class="btn btn-outline-primary rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                                        data-bs-toggle="modal" data-bs-target="#query-reminder-details-{{$query->id}}">
                                                                    <i class="ti-eye " style="font-size: 20px"></i>
                                                                </button>

                                                                @if(auth()->check() && $query->user_id == auth()->user()->id)
                                                                    <a  style="width: 45px; height: 45px; padding: 0"
                                                                        onclick="return confirm('Are you sure you want to delete this quotation?')"
                                                                        class="btn btn-outline-danger rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                                        href="{{request()->routeIs('all-query')? route('deleteQuery',[$query->id]) :
                                                                                (request()->routeIs('user-dashboard')?route('deleteQuery',[$query->id]) :route('admin-deleteQuery', [$query->id])) }}">
                                                                        <i class="ti-close" style="font-size: 20px"></i>
                                                                    </a>

                                                                @elseif(\Illuminate\Support\Facades\Auth::guard('admin')->check())

                                                                    <a  style="width: 45px; height: 45px; padding: 0"
                                                                        onclick="return confirm('Are you sure you want to delete this quotation?')"
                                                                        class="btn btn-outline-danger rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                                        href="{{request()->routeIs('all-query')? route('deleteQuery',[$query->id]) : route('admin-deleteQuery', [$query->id]) }}">
                                                                        <i class="ti-close" style="font-size: 20px"></i>
                                                                    </a>
                                                                @endif

                                                                <button
                                                                    style="width: 45px; height: 45px; padding: 0"
                                                                    type="button"
                                                                    class="btn btn-outline-dark rounded-circle waves-effect waves-light d-flex justify-content-center align-items-center"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#make-quotation-{{$query->id}}">
                                                                    <i class="ti-write" style="font-size: 20px"></i>
                                                                </button>

                                                            </div>


                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
{{-- =============query Reminder Details Modal --}}

                                    @foreach($queryReminders as $query)

                                        <div class="modal fade" id="query-reminder-details-{{$query->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
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

{{--                                        Make Quotation Modal --}}
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
                                                                                        <option>Select Warranty</option>
                                                                                        @foreach($warranties as $warranty)
                                                                                            <option value="{{$warranty->warranty}}">{{$warranty->warranty}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="mb-3 col-4">
                                                                                    <label class="form-label" for="basic-default-company">Payment Type*</label>
                                                                                    <select required name="payment_type" id="defaultSelect" class="form-select">
                                                                                        <option>Select Payment</option>
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
                                                                                        <option>Select Delivery Term</option>
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
                                                                                        <option>Select User</option>
                                                                                        @foreach($users as $user)
                                                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label class="form-label" for="basic-default-company">Status*</label>
                                                                                    <select name="status" id="defaultSelect" class="form-select">
                                                                                        <option>Select Status</option>
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
                    </div>

                    <div class="col-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>Expenses</h3>

                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead class="table-dark">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Expense Name</th>
                                                    <th>Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($expenses as $expense)
                                                    <tr>
                                                        <td>
                                                            {{$expense->created_at->format('d-M-Y')}}<br>
                                                            {{$expense->created_at->format('h:i:s A')}}<br>
                                                        </td>
                                                        <td>
                                                            <h4>
                                                                {{$expense->expenseNames['expense_name']}}
                                                            </h4>
                                                            <span>
                                                        {{$expense->note}}
                                                    </span>
                                                        </td>
                                                        <td>
                                                            {{$expense->expanse_amount}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3>My Attendance</h3>
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead class="table-dark">
                                                    <tr>
                                                        <th>Date</th>
                                                        <th> Login Time </th>
                                                        <th>Status</th>
                                                        <th>Log Out Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="table-active">
                                                        <th scope="row">1</th>
                                                        <td>Column content</td>
                                                        <td>Column content</td>
                                                        <td>Column content</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>Column content</td>
                                                        <td>Column content</td>
                                                        <td>Column content</td>
                                                    </tr>
                                                    <tr class="table-success">
                                                        <th scope="row">3</th>
                                                        <td>Column content</td>
                                                        <td>Column content</td>
                                                        <td>Column content</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">4</th>
                                                        <td>Column content</td>
                                                        <td>Column content</td>
                                                        <td>Column content</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

