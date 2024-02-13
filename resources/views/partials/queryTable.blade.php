

    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
        <thead>
            <tr>
            <th>Date</th>
            <th>User</th>
            <th>Details</th>
            <th>Customer Details</th>
            <th>Query Source</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody id="query-table-body">
        @foreach($queries as $index => $query)
            <tr>
                <td>{{$query->created_at->format('d-m-Y')}}</td>
                <td>
                    @if(!empty($query->users))
                        {{$query->users['name']}}
                    @else
                        -----
                    @endif
                </td>
                <td>{{$query->query_details}}</td>
                <td>
                    <a href="{{request()->routeIs('user-dashboard')? route('user-customer-profile',[$query->customer_id])  : route('customer-profile',[$query->customers['id']])}}">
                        {{$query->customers['name']}}
                        <br>{{$query->customers['phone_number']}}
                    </a>
                </td>
                <td>{{$query->query_source}}</td>
                <td>
                    <h6 class="badge {{$query->status == 'Processing' ? 'bg-primary'
                                       : ($query->status == 'Quotation Sent'? 'bg-success'
                                       :($query->status == 'Order Confirmed'?'bg-success'
                                       :($query->status == 'Delivery On Going' ? 'bg-success'
                                       :($query->status == 'Delivered'?'bg-success' :'bg-danger'))))
                                        }}">
                        {{$query->status}}
                    </h6>
                </td>

                <!-- Use a unique modal ID based on the query index or ID -->
                @php
                    $modalId = 'modal-' . $query->id;
                @endphp


                <td>
                    <button type="button" class="btn btn-secondary rounded view" data-bs-toggle="modal" data-bs-target="#{{$modalId}}">
                    <i class="fas fa-eye" style="font-size: 20px"></i>
                    </button>
                </td>
            </tr>
        @endforeach

        </tbody>

    </table>

    <div>
        @foreach($queries as $query)

            @php
                $modalId = 'modal-' . $query->id;
            @endphp

            <div id="{{$modalId}}" class="modal fade" tabindex="-1" aria-labelledby="Label" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-full-width">
                    <div class="modal-content">
                        <div class="">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="timeline-steps aos-init aos-animate d-flex justify-content-center mt-3" data-aos="fade-up">

                                                @foreach($statuses as $status)
                                                    @php
                                                        // Define a mapping of status values to background colors
                                                        $statusColors = [
                                                            'Processing' => 'style=background:#0272d4',
                                                            'Quotation Sent' => 'style=background:#c7ffd8',
                                                            'Order Confirmed' => 'style=background:#94ffb4',
                                                            'Delivery On Going' => 'style=background:#67fa61',
                                                            'Delivered' => 'style=background:#10fa07',
                                                            'Closed' => 'style=background:#08b502',
                                                            // Add more statuses and corresponding colors as needed
                                                        ];

                                                        // Check if the current status has a corresponding color in the mapping
                                                        $statusColor = isset($statusColors[$status->query_status]) ? $statusColors[$status->query_status] : 'bg-white';
                                                    @endphp

                                                    <div class="timeline-step">
                                                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title=""  data-original-title="2003">
                                                            <div {{$statusColor}} class="{{$query->status == $status->query_status ? 'inner-circle-active' : 'inner-circle '}}" ></div>
                                                            <p class="h6 mt-3 mb-1">{{$status->query_status}}</p>
                                                            <p class="h6 text-muted mb-0 mb-lg-0">
                                                                @if($query->status == $status->query_status )
                                                                    {{$query->updated_at->format('d M-Y ')}}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4" style="border-right: 1px solid #ccc">
                                    <div style="border-top: 4px solid #27A1DB" class="customer-info-div">
                                        <h5>
                                            <div class="p-1">
                                                <span class="badge badge-outline-primary" style="font-size: 22px">Customer Information</span>
                                            </div>
                                        </h5>

                                        <div>
                                            <div class="card border">
                                                <div class="card-body ">
                                                        <div class=" m-2 p-2 rounded " style="border: 1px solid #ccc;">
                                                            <h5>Customer Type:- {{$query->customers['customer_type']}}</h5>
                                                        </div>
                                                        <div class="m-2 rounded p-2 " style="border: 1px solid #ccc; ">
                                                            <h5>
                                                                Name:- {{$query->customers['name']}}
                                                            </h5>
                                                        </div>
                                                        <div class="m-2 rounded p-2 " style="border: 1px solid #ccc; ">
                                                            <h5>
                                                               Email:-{{$query->customers['email']}}
                                                            </h5>
                                                        </div>
                                                        <div class="m-2 rounded p-2 " style="border: 1px solid #ccc; ">
                                                            <h5>
                                                                Phone  Number:- {{$query->customers['phone_number']}}
                                                            </h5>
                                                        </div>
                                                        <div class="m-2 rounded p-2" style="border: 1px solid #ccc;">
                                                           <h5>
                                                               Address:- {{$query->customers['address']}}
                                                           </h5>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="">
                                            <div class="p-2">
                                                <h3>Add Notes</h3>
                                                <form class="add-note-form" method="POST"
                                                      action="{{request()->routeIs('user-dashboard') ? route('add-note',[\Illuminate\Support\Facades\Auth::user()->id,$query->id])
                                                                :route('admin-add-note',[$query->customers['id'],$query->id])}}">
                                                    {{ csrf_field() }}
                                                    <div class="mb-3">
                                                        <label for="example-textarea" class="form-label">Text</label>
                                                        <textarea name="notes" class="form-control rounded" id="modal-note" rows="2"></textarea>
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

                                <div class="col-8">
                                    <div style="border-top: 4px solid #27A1DB" class="customer-info-div">
                                        <h5>
                                            <div class="p-1">
                                                <span class="badge badge-outline-primary" style="font-size: 22px">Query Information</span>
                                            </div>
                                        </h5>
                                        <div class="modal-query-contatiner">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead class="table-dark">
                                                    <tr>
                                                        <th>Query Details</th>
                                                        <th>Quantity</th>
                                                        <th>
                                                            Product Code
                                                        </th>
                                                        <th>Query Source</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                               <strong style="font-size: 18px"> {{$query->query_details}}<br>
                                                                   category:- {{$query->product_category}}
                                                               </strong>
                                                            </td>
                                                            <td>
                                                                {{$query->product_quantity}}
                                                            </td>
                                                            <td>
                                                                {{$query->product_sku}}
                                                            </td>
                                                            <td>{{$query->query_source}}</td>
                                                            <td>
                                                                <div class="btn-group mb-2 dropstart">
                                                                    <button type="button" class="btn btn-info waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="mdi mdi-chevron-left"></i> {{$query->status}}
                                                                    </button>
                                                                    <div class="dropdown-menu" style="">
                                                                        @foreach($statuses as $status)
                                                                            <a class="dropdown-item"
                                                                               @if(request()->routeIs('user-dashboard'))
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
                                                            <td>
                                                                @if(!empty($query->users))
                                                                    <div class="btn-group mb-2">
                                                                        <button type="button" class="btn btn-success rounded-pill waves-effect waves-light">
                                                                            <span class="btn-label">User:</span>{{$query->users['name']}}
                                                                        </button>
                                                                    </div>

                                                                @else
                                                                    <button type="button" class="btn btn-warning rounded-pill waves-effect waves-light">
                                                                        <span class="btn-label">User:</span>Not Assigned
                                                                    </button>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light">
                                                                    <span class="btn-label">Created At:</span>{{$query->created_at->format('dM-Y, h:i:s A')}}
                                                                </button>
                                                            </td>

                                                            <td colspan="3">
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
                                        </div>
                                    </div>
{{--                                    Quotation Information --}}
                                    <div class="p-1">
                                        <span class="badge badge-outline-primary" style="font-size: 22px">Last Quotation Information</span>

                                        @php
                                            $lastQuotation = \App\Models\Quotation::where('customer_id', $query->customer_id)->latest()->first();
                                        @endphp

                                        <div class="table-responsive mt-3">
                                            <table class="table mb-0">
                                                <thead @if($lastQuotation)
                                                           class="{{$lastQuotation->status == 'Sent' ? 'table-success' : 'table-primary'}}"
                                                    @else
                                                        class="table-primary"
                                                    @endif
                                                    >
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Quot. No</th>
                                                    <th>Product Details</th>
                                                    <th>Status</th>
                                                    <th>Total Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($lastQuotation)
                                                    <tr>
                                                        <td>{{$lastQuotation->created_at}}</td>
                                                        <td>{{$lastQuotation->quotation_number}}</td>
                                                        <td>
                                                            <hr>
                                                            <div style="height: 150px; overflow: auto;">
                                                               @php
                                                                    $products = json_decode($lastQuotation->products, true);
                                                                    $totalPrice = 0; // Initialize $totalPrice
                                                                @endphp
                                                                
                                                                @foreach($products as $product)
                                                                    @php
                                                                        $unitPrice = $product['unit_price'];
                                                                        $priceWithVat = 0; // Initialize $priceWithVat
                                                                
                                                                        if (!empty($quotation->vat_tax)) {
                                                                            if ($quotation->vat_tax == 10.5) {
                                                                                $priceWithVat = $unitPrice + floatval($unitPrice) * 3 / 100;
                                                                                $priceWithVat = $priceWithVat + $priceWithVat * 7.5 / 100;
                                                                            } else {
                                                                                $priceWithVat = $unitPrice + floatval($unitPrice) * floatval($quotation->vat_tax) / 100;
                                                                            }
                                                                        } else {
                                                                            $priceWithVat = $unitPrice;
                                                                        }
                                                                
                                                                        $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
                                                                        $totalPrice += $subTotal;
                                                                    @endphp
                                                                
                                                                    <p style="word-wrap: break-word;"><strong>Name:</strong>{{$product['product_name']}}</p>
                                                                    <p><strong>Code:-</strong>{{$product['product_code']}}</p>
                                                                    <p><strong>Unit Price:-</strong>{{$product['unit_price']}}</p>
                                                                    <hr>
                                                                @endforeach

                                                            </div>
                                                        </td>
                                                        <td>{{$lastQuotation->status}}</td>
                                                        <td>
                                                            @if(!empty($totalPrice))
                                                                {{$totalPrice}} /-
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(request()->routeIs('user-dashboard'))
                                                                <a target="_blank" href="{{route('view-quotation-pdf',[$lastQuotation->customers['id'],$lastQuotation->id])}}" class="btn text-black btn-soft-blue waves-effect waves-light show">
                                                                    View
                                                                </a>
                                                            @else
                                                                <a target="_blank" href="{{route('admin-view-quotation-pdf',[$lastQuotation->customers['id'],$lastQuotation->id])}}" class="btn text-black btn-soft-blue waves-effect waves-light show">
                                                                    View
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center">No quotations found</td>
                                                    </tr>
                                                @endif
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="invoices">
                                        <span class="badge badge-outline-primary" style="font-size: 22px">Last Invoice Information</span>
                                        @php
                                            $invoice = \App\Models\Invoice::where('customer_id',$query->customer_id)
                                                                            ->with('payments','customers','users')
                                                                            ->latest()->first();
                                        @endphp

                                        <div class="table-responsive p-1">
                                            <table class="table mb-0">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Invo. No</th>
                                                    <th>Product Details</th>
                                                    <th>Total Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($invoice))
                                                        <tr>
                                                            <th>
                                                                {{$invoice['created_at']->format('d-M-Y')}}<br>
                                                                {{$invoice['created_at']->format('H-i-s A')}}
                                                            </th>
                                                            <td>
                                                                {{$invoice['invoice_no']}}
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $totalPrice = 0;
                                                                $invoiceProducts = json_decode($invoice->products, true);
                                                                ?>
                                                                @foreach($invoiceProducts as $product)
                                                                    @php
                                                                        $priceWithVat = $product['unit_price'] + $product['unit_price'] * $invoice->vat_tax / 100;
                                                                         $totalPrice = $priceWithVat * $product['quantity'];
                                                                    @endphp
                                                                    <strong style="font-size: 13px">Name:-</strong>{{$product['product_name']}}<br>
                                                                    <strong style="font-size: 13px">Code:-</strong>{{$product['product_code']}}<br>
                                                                    <strong style="font-size: 13px">Unit Price:-</strong>{{$product['unit_price']}}.tk<br>
                                                                    <hr>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                total: {{$totalPrice}} /-<br>
                                                                paid: {{ $invoice->payments->sum('amount') }} /-<br>
                                                                Due: {{ $totalPrice - $invoice->payments->sum('amount')}} -/
                                                            </td>
                                                            <td>
                                                               @if(request()->routeIs('user-dashboard'))
                                                                    <a target="_blank" href="{{route('view-invoice-pdf',[$invoice->customers['id'],$invoice->id])}}" class="btn btn-primary">
                                                                        View
                                                                    </a>
                                                                @else
                                                                    <a target="_blank" href="{{route('admin-view-invoice-pdf',[$invoice->customers['id'],$invoice->id])}}" class="btn btn-primary">
                                                                        View
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="5" class="text-center">
                                                                No Invoice Found
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
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
        @endforeach
    </div>

    <div id="pagination-container">
        {{$queries->links('pagination::bootstrap-5') }}
    </div>





