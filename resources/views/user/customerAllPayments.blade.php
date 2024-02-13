@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    @include('error')
                    @include('success')
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="customer-profile-sidebar">
                                        <ul>
                                            <li>
                                                <a href="{{route('user-customer-profile',[$customer_id])}}"><i class='bx bx-user-circle me-1' ></i> Profile</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-view-all-query',[$customer_id])}}"><i class='bx bx-notepad me-1'></i>Lead/Query</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-view-add-quotation',[$customer_id])}}"><i class='bx bxs-file-pdf me-1'></i>All Quotations</a>
                                            </li>
                                            <li>
                                                <a href="{{route('all-invoice',[$customer_id])}}"><i class='bx bx-food-menu me-1'></i> Invoices</a>
                                            </li>
                                            <li class="active-2">
                                                <a href="{{route('customer-all-payment',[$customer_id])}}"><i class='bx bxs-badge-dollar me-1'></i> payments</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-customer-notes',[$customer_id])}}"><i class='bx bx-note me-1'></i>Notes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                                <div class="card">
                                    <div class="d-flex justify-content-between align-items-end">

                                        <h4 class="card-header">All Payments</h4>
                                    </div>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Invoice No</th>
                                                <th>Added By</th>
                                                <th>Pay With</th>
                                                <th>Bank Name</th>
                                                <th>Ref No</th>
                                                <th>Amount</th>
                                                <th>Payment note</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            @foreach($payments as $key=>$payment)
                                                <tr>
                                                 <td>
                                                    {{$loop->iteration}}
                                                 </td>
                                                 <td>
                                                     {{$payment->invoices['invoice_no']}}
                                                 </td>
                                                 <td>
                                                    @if(!empty($payment->users))
                                                         {{$payment->users['name']}}
                                                     @else
                                                        Admin
                                                     @endif
                                                 </td>
                                                 <td>
                                                    {{$payment->payment_with}}
                                                 </td>
                                                 <td>
                                                    {{$payment->bank_name}}
                                                 </td>
                                                 <td>
                                                    {{$payment->Ref_no}}
                                                 </td>
                                                  <td>
                                                       {{$payment->amount}}
                                                  </td>
                                                    <td>
                                                        {{$payment->payment_note}}
                                                    </td>
                                                    <td>
                                                        {{$payment->payment_date}}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a class="btn btn-sm btn-success" href="{{route('single-money_rec',[$payment->id])}}">
                                                                Money Rec.
                                                            </a>
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

@include('partials.layoutEnd')
