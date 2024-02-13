@if(request()->routeIs('admin-make-payment'))
    @include('partials.layoutHead')
@else
    @include('user.partials.layoutHead')
@endif

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @if(request()->routeIs('admin-make-payment'))
            @include('partials.sidebar')
        @else
            @include('user.partials.sidebar')
        @endif

        <div class="layout-page">
            @if(request()->routeIs('admin-make-payment'))
                @include('partials.navbar')
            @else
                @include('user.partials.navbar')
            @endif
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
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
                                                <a href="{{route('user-query-add-form-profile',[$customer_id])}}"><i class='bx bx-notepad me-1'></i>Lead/Qurery</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-customer-all-quotations',[$customer_id])}}"><i class='bx bxs-file-pdf me-1'></i>All Quotations</a>
                                            </li>
                                            <li>
                                                <a href="{{route('all-invoice',[$customer_id])}}"><i class='bx bx-food-menu me-1'></i> Invoices</a>
                                            </li>
                                            <li>
                                                <a href="{{route('customer-all-payment',[$customer_id])}}"><i class='bx bxs-badge-dollar me-1'></i> payments</a>
                                            </li>
                                            <li>
                                                <a href=""><i class='bx bx-note me-1'></i>Notes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">

                            <div class="card mb-4">

                                    </div>
                                    <div class="card-body text-left">
                                        @include('error')
                                        @include('success')
                                        <div class="card p-4">
                                            <form method="POST" action="{{request()->routeIs('admin-make-payment') ? route('admin-direct-add-payment',[$customer_id,$quotation_id,$invoice_id]) : route('direct-add-payment',[$customer_id,$quotation_id,$invoice_id])}}">
                                                {{csrf_field()}}
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-fullname">Pay With*</label>
                                                        <select required name="pay_with" id="defaultSelect" class="form-select">
                                                            <option> </option>
                                                            <option value="Bank Transfer">Bank Transfer</option>
                                                            <option value="Bkash">Bkash</option>
                                                            <option value="Nagad">Nagad</option>
                                                            <option value="SSL Commerz">SSL Commerz</option>
                                                            <option value="Cash">Cash</option>
                                                            <option value="Cheque">Cheque</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-company">Bank Name*</label>
                                                        <input required type="text" name="bank_name" class="form-control" id="basic-default-company">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-email">REF NO*</label>
                                                        <div class="input-group input-group-merge">
                                                            <input required type="text" name="ref_no" id="basic-default-email" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-fullname">Cash In*</label>
                                                        <select required name="cash_in" id="defaultSelect" class="form-select">
                                                            <option> </option>
                                                            @foreach($accounts as $account)
                                                                 <option value="{{$account->id}}">{{$account->bank_name}} ({{$account->account_number}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-phone">Amount*</label>
                                                        <input required type="number" name="amount" id="basic-default-phone" class="form-control phone-mask">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-phone">Payment Date*</label>
                                                        <input required name="payment_date" class="form-control" type="date" value="2021-06-18" id="html5-date-input">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-message">Payment Note*</label>
                                                        <textarea name="payment_note" required placeholder="Give A Name of Your Transaction" id="basic-default-message" class="form-control"></textarea>
                                                    </div>
                                                    <div>
                                                        <button type="submit" class="btn btn-primary">Add Payment</button>
                                                    </div>
                                                </div>
                                            </form>
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
