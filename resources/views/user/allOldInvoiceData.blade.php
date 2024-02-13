@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-12">
                            @include('error')
                            @include('success')
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">

                                    <button class="btn btn-primary">
                                        <a href="{{route('user-view-quotation-form')}}" class="text-white">Add New <i class='bx bx-plus'></i></a>
                                    </button>

                                    <div class="d-inline">
                                        <h3 class="mb-0">All Invoices</h3>
                                        <hr>
                                        <h5><strong>Total :- {{$totalInvoice}}</strong> </h5>
                                    </div>
                                    <div class="filter">
                                        <form method="GET" action="{{route('old-all-invoice-date-filter')}}">
                                            {{csrf_field()}}
                                            <div class="mb-3 row">
                                                <div class="col-md-10 d-flex">
                                                    <input name="date" class="form-control" type="date" id="html5-date-input">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class='bx bx-filter-alt' ></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <div class="card-body text-left">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>date</th>
                                            <th>Invoice No</th>
                                            <th>Customer Name</th>
                                            <th>Address,Phone & Email</th>
                                            <th>Product Name</th>
                                            <th>Total Price</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($invoices as $key => $invoice)
                                                <tr>
                                                <td>
                                                    {{$loop->iteration }}
                                                </td>
                                                <td>
                                                    {{$invoice->Date}}
                                                </td>
                                                 <td>
                                                     {{$invoice->Invoice_Number}}
                                                </td>
                                                <td>
                                                    {{$invoice->Customer_Name}}
                                                </td>
                                                <td>
                                                    <strong>Phone Num:-</strong> {{$invoice->Phone}}
                                                    <p>
                                                        <strong>Email:-</strong> {{$invoice->Email}}
                                                    </p>
                                                    <p>
                                                        <strong>Address:-</strong>{{$invoice->Address}}
                                                    </p>
                                                </td>
                                                <td style="font-size: 14px">
                                                    @php
                                                        $products = explode('+', $invoice->Product_Name);
                                                        $quantity = explode('+', $invoice->Quantity);
                                                        $unit = explode('+', $invoice->Unit)
                                                    @endphp

                                                    @foreach($products as $index=>$product)
                                                        <strong>Product:-</strong> {{$product}}<br>
                                                        <strong>Quantity:-</strong> {{$quantity[$index]}}.{{$unit[$index]}}<br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @php
                                                        $totalPrice = floatval($invoice->All_Total_Price) + floatval($invoice->Extra_Price)+ floatval($invoice->Delivery_Charge) - floatval($invoice->Discount);
                                                    @endphp
                                                    {{$totalPrice}}
                                                </td>
                                                <td>
                                                      {{$invoice->Paid}}
                                                </td>
                                                 <td>
                                                     {{$totalPrice - $invoice->Paid }}
                                                 </td>
                                                <td>
                                                    <div class="">
                                                        <div style="line-height: 30px" class="">
                                                            <button class="btn btn-sm btn-primary" type="button">
                                                                <a class="text-white" href="">Edit</a>
                                                            </button>
                                                            <button onclick="return confirm('Are you sure you want to delete this quotation?')" type="button" class="btn btn-sm btn-danger">
                                                                <a class="text-white" href="">Delete</a>
                                                            </button><br>
                                                            <button type="button" class="btn btn-sm btn-primary">
                                                                <a class="text-white" href="">View</a>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-primary add-query-note" id="">
                                                                <a class="text-white" href="">Download</a>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-primary add-query-note" id="">
                                                                <a class="text-white" href="">Send Mail</a>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-primary add-query-note" id="">
                                                                <a class="text-white" href="">Make Inv.</a>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{$invoices->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@include('partials.layoutEnd')
