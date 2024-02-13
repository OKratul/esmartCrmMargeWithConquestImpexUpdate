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
                                        <h3 class="mb-0">All Quotation</h3>
                                        <hr>
                                        <h5><strong>Total :- {{$totalQuotations}}</strong> </h5>
                                    </div>
                                    <div class="filter">
                                        <form method="GET" action="{{route('old-all-quotation-date-filter')}}">
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
                                            <th>Quotation No</th>
                                            <th>Customer Name</th>
                                            <th>Address,Phone & Email</th>
                                            <th>Product Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($quotations as $key=> $quotation)
                                            <tr>
                                                <td>
                                                    {{$loop->iteration}}
                                                </td>
                                                <td>
                                                    {{$quotation->Date}}
                                                </td> <td>
                                                    {{$quotation->Quotation_Number}}
                                                </td>
                                                <td>
                                                    {{$quotation->Customer_Name}}
                                                </td>
                                                <td>
                                                    {{$quotation->Phone}}
                                                    <p>
                                                        {{$quotation->Address}}
                                                    </p>
                                                    <p>
                                                        {{$quotation->Email}}
                                                    </p>
                                                </td>
                                                <td style="font-size: 14px">
                                                    @php
                                                        $products = explode(';', $quotation->Product_Name);
                                                        $quantities = preg_split("/[,+\-]/", $quotation->Quantity);
                                                        $quantities = array_map('trim', $quantities);
                                                        $units = explode('+', $quotation->Unit);
                                                    @endphp

                                                    @foreach($products as $index => $product)
                                                        <strong>Description:</strong> {{$product}}<br>

                                                        @if(isset($quantities[$index]) && isset($units[$index]))
                                                            <strong>Quantity:</strong> {{$quantities[$index]}},{{$units[$index]}}<br>
                                                        @endif
                                                    @endforeach
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
                            {{$quotations->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@include('partials.layoutEnd')
