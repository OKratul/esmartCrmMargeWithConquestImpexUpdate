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

                            <div class="card mb-4">

                            </div>
                            <div class="card-body text-left">
                                @include('error')
                                @include('success')
                                <div class="card p-4">
                                    <form method="POST" action="{{route('add-payment-from-all-invoice',[$customer_id,$invoice_id])}}">
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
                                                <label class="form-label" for="basic-default-fullname">Cash In*</label>
                                                <select required name="cash_in" id="defaultSelect" class="form-select">
                                                    <option> </option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->id}}">{{$account->bank_name}}({{$account->account_number}})</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-email">REF NO</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" name="ref_no" id="basic-default-email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-phone">Amount</label>
                                                <input type="number" name="amount" id="basic-default-phone" class="form-control phone-mask">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-phone">Payment Date</label>
                                                <input name="payment_date" class="form-control" type="date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" id="html5-date-input">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-message">Payment Note</label>
                                                <textarea name="payment_note" id="basic-default-message" class="form-control">
                                                    Rest Payment Form {{$invoice->customers['name']}}
                                                </textarea>
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
