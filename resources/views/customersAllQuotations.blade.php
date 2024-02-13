@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-2">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="customer-profile-sidebar">
                                        <ul style="padding: 0px">
                                            <li>
                                                <a href="{{route('customer-profile',[$customer_id])}}"><i class='bx bx-user-circle me-1' ></i> Profile</a>
                                            </li>
                                            <li>
                                                <a href="{{route('view-all-query',[$customer_id])}}"><i class='bx bx-notepad me-1'></i>Lead/Query</a>
                                            </li>
                                            <li class="active-2">
                                                <a href="{{route('customer-all-quotations',[$customer_id])}}"><i class='bx bxs-file-pdf me-1'></i>All Quotations</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin-customer-all-invoice',[$customer_id])}}"><i class='bx bx-food-menu me-1'></i> Invoices</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin-customer-all-payment',[$customer_id])}}"><i class='bx bxs-badge-dollar me-1'></i> payments</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin-customer-notes',[$customer_id])}}"><i class='bx bx-note me-1'></i>Notes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <div class="card">
                                @foreach($customers as $customer)
                                    <h4 class="card-header">{{$customer['name']}}'s all Quotations</h4>
                                    <h5>Phone Number:- {{$customer['phone_number']}}</h5>
                                    <p><strong>Address:-</strong>{{$customer['address']}},{{$customer['city']}},{{$customer['country']}}</p>
                                @endforeach
                                <div class="card-body">
                                    <div class="text-left p-2">
                                        <a href="{{route('admin-view-add-quotation',[$customer_id])}}" class="btn btn-primary">
                                            Add New <i class='bx bx-plus'></i>
                                        </a>
                                    </div>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Date</th>
                                                <th>Quotation No</th>
                                                <th>Product Details</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($quotations as $key=>$quotation)
                                                    <tr class="{{$quotation->status == 'Sent' ? 'bg-label-success' : ''}}">
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            {{$quotation->created_at->format('d/m/Y')}} <br>
                                                            {{$quotation->created_at->format('h:i A')}}
                                                        </td>
                                                        <td>
                                                            {{$quotation->quotation_number}}
                                                        </td>
                                                        <td class="text-left">
                                                           <div style="height: 200px; width: 300px; overflow: scroll">
                                                               @php
                                                                   $products = json_decode($quotation->products, true)
                                                               @endphp
                                                               @foreach($products as $product)
                                                                   <strong style="font-size: 13px">Name:-</strong>{{$product['product_name']}}<br>
                                                                   <strong style="font-size: 13px">Code:-</strong>{{$product['product_code']}}<br>
                                                                   <strong style="font-size: 13px">Unite Price:-</strong>{{$product['unit_price']}}.tk<br>
                                                                   <hr>
                                                               @endforeach
                                                           </div>
                                                        </td>
                                                        <td>
                                                            {{$quotation->status}}
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <div>
                                                                    <a class="btn btn-sm btn-primary" href="{{route('view-edite-quotation-from-profile',[$customer_id,$quotation->id])}}">Edit</a>
                                                                    <a class="btn btn-sm btn-primary" href="{{route('admin-view-quotation-pdf',[$customer_id,$quotation->id])}}">View</a>
                                                                    <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this quotation?')" href="{{route('delete-quotation',[$customer_id,$quotation->id])}}">Delete</a>
                                                                </div>
                                                                <div class="mt-1">
                                                                    <a class="btn btn-sm btn-primary" href="{{route('admin-view-invoice-generator',[$customer_id,$quotation->id])}}">Make Inv..</a>
                                                                    <a class="btn btn-sm btn-primary" href="{{route('admin-sent-quotation-mail',[$customer_id,$quotation->id])}}">Sent Mail</a>
                                                                </div>
                                                                <div class="mt-1">
                                                                  <a class="btn btn-sm btn-primary" href="{{route('generate-pdf-download',[$customer_id,$quotation->id])}}">Download</a>
                                                              </div>
                                                            </div>
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
            </div>
        </div>

    </div>

</div>


@include('partials.layoutEnd')
