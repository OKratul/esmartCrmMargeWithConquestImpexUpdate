@include('partials.layoutHead')

<div id="wrapper">

    @include('partials.navbar')
    @include('partials.sidebar')


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
                    {{--=============  All Query =============--}}
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
                                              <form action="{{route('dashboard')}}" method="GET">
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
                                                    <h4>{{$pendingQuery}}</h4>
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
                                                <form action="{{route('dashboard')}}" method="GET">
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
                      {{--=========   Quyery Transfer Request   =======--}}
                          <div class="col-12">
                              <div class="card">
                                  <div class="card-body">
                                      <h2>Query Transfer Request</h2>
                                      <div class="table-responsive">
                                          <table class="table mb-0">
                                              <thead class="table-light">
                                              <tr>
                                                  <th>Date</th>
                                                  <th>Request Id</th>
                                                  <th>Query Details</th>
                                                  <th>Assign To</th>
                                                  <th>Action</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              @if(empty($assignRequests))
                                                  <tr>
                                                      <th colspan="4" class="text-center">No Assign Request</th>
                                                  </tr>
                                              @else
                                                  @foreach($assignRequests as $assignRequest)
                                                      <tr>
                                                          <th scope="row">{{$assignRequest->created_at}}</th>
                                                          <td>{{$assignRequest->reqIds['name']}}</td>
                                                          <td>{{$assignRequest->queries['query_details']}}</td>
                                                          <td>{{$assignRequest->users['name']}}</td>
                                                          <td>
                                                              <div class="d-flex gap-2">
                                                                  <a href="{{route('admin-approve-req',[$assignRequest->queries['id'],$assignRequest->reqIds['id'],$assignRequest->id])}}" class="btn btn-sm btn-success">
                                                                      Approve
                                                                  </a>
                                                                  <a href="{{route('admin-decline-req',[$assignRequest->id])}}" class="btn btn-sm btn-danger">
                                                                      Decline
                                                                  </a>
                                                              </div>
                                                          </td>
                                                      </tr>
                                                  @endforeach
                                              @endif

                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                          </div>

                        {{--======== Task Assign ===========--}}

                          <div class="col-12">
                              <div class="card">
                                  <div class="card-body">
                                      <div class="d-flex justify-content-between align-items-center">
                                          <h3>Users Sales Inquiry</h3>
                                          <form action="{{route('dashboard')}}" method="GET">
                                              @csrf
                                              <div class="d-flex">
                                                  <div class="mr-2 d-flex align-items-center">
                                                      <label for="example-date" class="form-label" style="margin-right: 5px">From</label>
                                                      <input class="form-control" id="example-date" type="date" name="sales_date_form">
                                                  </div>
                                                  <div class="mr-2 d-flex align-items-center">
                                                      <label for="example-date" class="form-label" style="margin-right: 5px">To</label>
                                                      <input class="form-control" id="example-date" type="date" name="sales_date_to">
                                                  </div>
                                                  <button class="btn btn-primary" type="submit">
                                                      <i class="fas fa-filter"></i>
                                                  </button>
                                              </div>
                                          </form>
                                      </div>
                                      <div class="table-responsive">
                                          <table class="table table-striped mb-0">
                                              <thead>
                                              <tr>
                                                  <th>Users</th>
                                                  <th>Queries</th>
                                                  <th>Quotations</th>
                                                  <th>Invoices</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              @foreach($usersData as $userData)
                                                  <tr>
                                                      <td>
                                                          {{$userData->name}}
                                                      </td>
                                                      <td>
                                                          Qty:- {{count($userData->queries)}}

                                                      </td>
                                                      <td>
                                                          Qty:- {{count($userData->quotations)}}<br>
                                                          @php
                                                              $totalValue = 0; // Initialize total value
                                                              foreach ($userData->quotations as $quotation) {
                                                                  $products = json_decode($quotation->products, true);
                                                                  foreach ($products as $product) {
                                                                      $unitPrice = $product['unit_price'];
                                                                      $quantity = $product['quantity'];
                                                                      $subtotal = $unitPrice * $quantity;
                                                                      $totalValue += $subtotal; // Accumulate subtotal to total value
                                                                  }
                                                              }
                                                          @endphp
                                                          Total Value: ${{ $totalValue }}
                                                      </td>
                                                      <td>
                                                          Qty:- {{count($userData->invoices)}}<br>
                                                          @php
                                                              $totalValue = 0; // Initialize total value
                                                              foreach ($userData->invoices as $invoice) {
                                                                  $products = json_decode($invoice->products, true);
                                                                  foreach ($products as $product) {
                                                                      $unitPrice = $product['unit_price'];
                                                                      $quantity = $product['quantity'];
                                                                      $subtotal = $unitPrice * $quantity;
                                                                      $totalValue += $subtotal; // Accumulate subtotal to total value
                                                                  }
                                                              }
                                                          @endphp
                                                          Total Value: ${{ $totalValue }}
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
                  </div>
                  <div class="col-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div>
                                                <form action="{{route('dashboard')}}" method="GET">
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
                                            <div class="" >
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
                                                <thead class="table-light">
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
                                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg-{{$payment->id}}">
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

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h2>Today's Attendance</h2>
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>Status</th>
                                                <th>Login Time</th>
                                                <th>Logout Time</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($admins as $admin)

                                                <tr class="bg-label-success">
                                                    <td>
                                                        {{ $admin->username }}
                                                    </td>
                                                    <td>
                                                        @if($admin->attendances->isNotEmpty())
                                                            @if(\Carbon\Carbon::parse($admin->attendances->first()->login_time)->format('H:i A') > \Carbon\Carbon::createFromFormat('h:i A', '10:30 AM')->format('H:i A'))
                                                                <span class="badge bg-label-warning me-1">Late</span>
                                                            @else
                                                                <span class="badge bg-label-success me-1">Present</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-label-danger me-1">Absent</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($admin->attendances->isNotEmpty())
                                                            {{ \Carbon\Carbon::parse($admin->attendances->first()->login_time)->format('h:i A') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($admin->attendances->isNotEmpty())
                                                            @if($admin->attendances->last()->logout_time)
                                                                {{ \Carbon\Carbon::parse($admin->attendances->last()->logout_time)->format('h:i A') }}
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>

                                            @endforeach

                                            @foreach($users as $user)
                                                <tr class="">
                                                    <td>
                                                        {{ $user->name }}
                                                    </td>
                                                    <td>
                                                        @if($user->attendances->isNotEmpty())
{{--                                                            {{$user->attendances['status']}}--}}
                                                        @else
                                                            <span class="badge bg-label-danger me-1">Absent</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($user->attendances->isNotEmpty())
                                                            {{ \Carbon\Carbon::parse($user->attendances->first()->login_time)->format('h:i A') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($user->attendances->isNotEmpty())
                                                            @if($user->attendances->last()->logout_time)
                                                                {{ \Carbon\Carbon::parse($user->attendances->last()->logout_time)->format('h:i A') }}
                                                            @endif
                                                        @else
                                                            -
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <h2>Expense</h2>
                                        <div class="mb-3">
                                            <form action="{{route('dashboard')}}" method="GET">
                                                @csrf
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-2 d-flex align-items-center">
                                                        <label for="example-date" class="form-label" style="margin-right: 5px">From</label>
                                                        <input class="form-control" id="example-date" type="date" name="expense_date_form">
                                                    </div>
                                                    <div class="mr-2 d-flex align-items-center">
                                                        <label for="example-date" class="form-label" style="margin-right: 5px">To</label>
                                                        <input class="form-control" id="example-date" type="date" name="expense_date_to">
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="fas fa-filter"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Expense Name</th>
                                                <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            <?php
                                            $totalAmount = 0;
                                            ?>
                                            @foreach($expenses as $index => $expense)
                                                <tr>
                                                    <td>
                                                        {{$loop->iteration}}
                                                    </td>
                                                    <td>
                                                        {{$expense->expenseNames['expense_name']}}<br>
                                                        {{$expense->accounts['bank_name']}} ({{$expense->accounts['account_number']}})<br>
                                                        ({{$expense->note}})
                                                    </td>
                                                    <td>
                                                        {{$expense->expanse_amount}} /-
                                                    </td>
                                                </tr>
                                                <?php
                                                    $totalAmount += $expense->expanse_amount;
                                                ?>
                                            @endforeach

                                            <tr>
                                                <td class="text-right" colspan="2"><strong>Total:-</strong></td>
                                                <td>
                                                    <h4>{{$totalAmount}} /-</h4>
                                                </td>
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Task Details</th>
                                            <th>Start -> End </th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                        @foreach($totalTasks as $totalTask)
                                            <tr  class="{{$totalTask->status == 'pending' ? 'bg-label-warning' : ($totalTask->status == 'done' ? 'bg-label-success' : ($totalTask->status == 'approve' ? 'bg-label-success' : 'bg-label-danger'))}}">
                                                <td class="text-center">
                                                      <span class="avatar avatar-xs pull-up">
                                                          @if($totalTask['users']['profiles'] == null)
                                                              <img style="width: 30px; height: 30px" class="rounded-circle" src="{{asset('Asset/img/avatars/1.png')}}">
                                                          @else
                                                              <img style="width: 30px; height: 30px" class="rounded-circle" src="{{asset('profiles/'.$totalTask['users']['profiles']['pro_img'] )}}">
                                                          @endif
                                                      </span><br>
                                                    <strong>{{$totalTask->users['name']}}</strong>
                                                </td>
                                                <td>
                                                    <p>
                                                        <strong>{{$totalTask->title}}</strong><br>
                                                        <span>{{$totalTask->description}}</span>
                                                    </p>
                                                </td>
                                                <td>
                                                    {{ date('dM', strtotime($totalTask->start_date)) }} -> {{date('dM', strtotime($totalTask->end_date))}}
                                                </td>
                                                <td>
                                                    {{$totalTask->status}}
                                                </td>
                                                <td>
                                                    <a href="{{route('task-approve',[$totalTask->id])}}" class="btn btn-sm btn-primary mb-2">
                                                        Approve
                                                    </a>
                                                    <a href="{{route('task-failed',[$totalTask->id])}}" class="btn btn-sm btn-danger ">
                                                        Job Failed
                                                    </a>
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
                <!-- end row -->

            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>


    @include('partials.rightbar')


@include('partials.layoutEnd')

