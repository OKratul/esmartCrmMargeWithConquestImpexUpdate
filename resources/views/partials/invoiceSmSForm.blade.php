<div id="invice-sms-modal-{{$invoice->id}}" class="modal fade" tabindex="-1" aria-labelledby="standard-modalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Type Required Information for SmS</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <div class="sms-form">
                        <form action="{{request()->routeIs('user-all-invoice') ? route('user-sent-sms',[$invoice->id])  : route('sent-sms',[$invoice->id])}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="defaultSelect" class="form-label">Select Account*</label>
                                        <select required name="account_id" id="defaultSelect" class="form-select">
                                            <option> </option>
                                            @foreach($accounts as $account)
                                                <option value="{{$account->id}}">{{$account->account_type}},{{$account->bank_name}},{{$account->account_number}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="defaultFormControlInput" class="form-label">Total Bill*</label>
                                        <input required name="total_bill" type="text" class="form-control" placeholder="Total bill" >
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <label for="defaultFormControlInput" class="form-label">Payment Amount*</label>
                                        <input required type="text" name="payment_amount" class="form-control" placeholder="Payment Amount" >
                                    </div>

                                    <div class="col-6">
                                        <label class="form-check-label" for="inlineCheckbox1">Delivery Charge</label>
                                        <input name="delivery_charge" type="number" class="form-control" id="deliveryChargeInput" placeholder="Delivery charge">
                                    </div>
                                </div>

                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fe-send"></i> Sent
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
