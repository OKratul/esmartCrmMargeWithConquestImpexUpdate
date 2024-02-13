@if(request()->routeIs('admin-all-payments'))
    @include('partials.layoutHead')
@else
    @include('user.partials.layoutHead')
@endif
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @if(request()->routeIs('admin-all-payments'))
            @include('partials.sidebar')
        @else
            @include('user.partials.sidebar')
        @endif

        <div class="layout-page">

            @if(request()->routeIs('admin-all-payments'))
                @include('partials.navbar')
            @else
                @include('user.partials.navbar')
            @endif

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
{{--                                Add Payment Modal--}}
{{--                                <div>--}}
{{--                                    <div class="modal fade" id="smallModal" tabindex="-1" style="display: none;" aria-hidden="true">--}}
{{--                                        <div class="modal-dialog modal-sm" role="document">--}}
{{--                                            <form>--}}
{{--                                                <div class="modal-content">--}}
{{--                                                    <div class="modal-header">--}}
{{--                                                        <h5 class="modal-title" id="exampleModalLabel2">Modal title</h5>--}}
{{--                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-body text-left">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col mb-3">--}}
{{--                                                                <label for="nameSmall" class="form-label">Purpose*</label>--}}
{{--                                                                <input type="text" required name="purpose" id="nameSmall" class="form-control" placeholder="Enter Name">--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col mb-3">--}}
{{--                                                                <label for="nameSmall" class="form-label">Amount*</label>--}}
{{--                                                                <input type="number" required name="amount" id="nameSmall" class="form-control" placeholder="Enter Name">--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="row g-2">--}}
{{--                                                            <div class="col mb-0">--}}
{{--                                                                <label class="form-label" for="emailSmall">Invoice</label>--}}
{{--                                                                <select name="invoice_id" id="defaultSelect" class="form-select">--}}
{{--                                                                    <option>Select Invoice</option>--}}
{{--                                                                    @foreach($invoices as $invoice)--}}
{{--                                                                        <option {{$invoice->id}}>{{$invoice->invoice_no}}</option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-footer">--}}
{{--                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">--}}
{{--                                                            Close--}}
{{--                                                        </button>--}}
{{--                                                        <button type="button" class="btn btn-primary">Save changes</button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </form>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                {{--Add Payment Modal End--}}

                                <div class="p-4">
                                    <h4 class="bg-success rounded-1 p-2">Total Payment = {{$totalPayment}}.TK</h4>
                                    <h5 class="card-header">All Payments</h5>
{{--                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#smallModal">--}}
{{--                                        Add Payment--}}
{{--                                    </button>--}}
                                    <div>
                                        <form method="GET" action="{{request()->routeIs('all-payments') ? route('all-payments') : route('admin-all-payments')}}">
                                            @csrf
                                            <div class="mb-3 row">
                                                <div class="col-md-10 d-flex">
                                                    <span class="m-2">From</span><input name="date_from" class="form-control" type="date" id="html5-date-input">
                                                    <span class="m-2">to</span><input name="date_to" class="form-control" type="date" id="html5-date-input">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="bx bx-filter-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table ">
                                        <thead>
                                        <tr class="text-left">
                                            <th>SL</th>
                                            <th>Cash In Account</th>
                                            <th>Invoice No</th>
                                            <th>Customer Name</th>
                                            <th>Ref No</th>
                                            <th>Pay With</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                        @foreach($payments as $key=>$payment)
                                                <tr onclick="" class="payment-row">
                                                    <td class="align-middle text-left">
                                                        {{$loop->iteration}}
                                                    </td>
                                                    <td class="text-left">
                                                        {{$payment->accounts['bank_name']}}({{$payment->accounts['account_number']}})
                                                    </td>
                                                    <td class="align-middle text-left">
                                                       @if($payment->invoices)
                                                            #{{$payment->invoices['invoice_no']}}
                                                        @endif
                                                    </td>
                                                    <td class="text-left align-middle">
                                                        @if(!empty($payment->customers))
                                                            {{$payment->customers['name']}}
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-left">
                                                        {{$payment->Ref_no}}
                                                    </td>
                                                    <td class="align-middle text-left">
                                                        {{$payment->payment_with}}
                                                    </td>
                                                    <td class="align-middle text-left">
                                                        {{$payment->amount}} .TK
                                                    </td>
                                                    <td>
                                                        @if(request()->routeIs('admin-all-payments'))
                                                            <a href="{{route('admin-single-money_rec',[$payment->id])}}" class="btn btn-sm btn-info ">
                                                                Money.Rec
                                                            </a>
                                                        @else
                                                            <a href="{{route('single-money_rec',[$payment->id])}}" class="btn btn-sm btn-info ">
                                                                Money.Rec
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div id="payment-details-popup" style="display: none;">
                                        <!-- Content of the popup -->
                                        <!-- You can customize the layout and add more details here -->
                                        <p id="payment-details"></p>
                                    </div>

                                </div>
                            </div>
{{--                            @if()--}}
                            {{$payments->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.layoutEnd')

