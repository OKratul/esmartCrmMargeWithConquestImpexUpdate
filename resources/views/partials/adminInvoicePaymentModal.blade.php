<div class="modal fade" id="invoice-payment-modal-{{$invoice->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Add Payment For #{{$invoice->invoice_no}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{request()->routeIs('user-all-invoice')? route('add-payment-from-all-invoice',[$invoice->customer_id,$invoice->id])
                                            :(request()->routeIs('user-customer-profile')? route('add-payment-from-all-invoice',[$invoice->customer_id,$invoice->id])
                                            :route('admin-add-payment-from-all-invoice',[$invoice->customer_id,$invoice->id]))}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="mb-3 col-6">

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
                        <div class="mb-3 col-6">
                            <label class="form-label" for="basic-default-company">Bank Name*</label>
                            <input required type="text" name="bank_name" class="form-control" id="basic-default-company">
                        </div>

                        <div class="mb-3 col-6">
                            <label class="form-label" for="basic-default-fullname">Cash In*</label>
                            <select required name="cash_in" id="defaultSelect" class="form-select">
                                <option> </option>
                                @foreach($accounts as $account)
                                    <option value="{{$account->id}}">{{$account->bank_name}}({{$account->account_number}})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-6">
                            <label class="form-label" for="basic-default-email">REF NO</label>
                            <div class="input-group input-group-merge">
                                <input type="text" name="ref_no" id="basic-default-email" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label" for="basic-default-phone">Amount</label>
                            <input type="text" name="amount" id="basic-default-phone" class="form-control phone-mask">
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label" for="basic-default-phone">Payment Date *</label>
                            <input name="payment_date" class="form-control" type="date" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label" for="basic-default-message">Payment Note</label>
                            <textarea name="payment_note" id="basic-default-message" class="form-control">
                                                    Rest Payment Form Customer ({{$invoice->customers['name']}})
                                                </textarea>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Add Payment</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
