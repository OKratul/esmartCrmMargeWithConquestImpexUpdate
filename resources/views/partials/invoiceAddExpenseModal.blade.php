<div class="modal fade" id="invoice-expense-modal-{{$invoice->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Add Expenses For #{{$invoice->invoice_no}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $expenseNames = \App\Models\ExpenseName::all();
                @endphp
               <div class="p-2">
                   <form
                       @if(request()->routeIs('view-add-expanse-invoice'))
                           action="{{ route('add-expanse-invoice', [ $invoice->id]) }}"
                       @elseif(request()->routeIs('admin-view-add-expanses'))
                           action="{{ route('admin-add-expanses') }}"
                       @elseif(request()->routeIs('admin-all-invoice'))
                           action="{{ route('admin-add-expanse-invoice', [$invoice->id]) }}"
                       @elseif(request()->routeIs('user-all-invoice'))
                           action="{{ route('add-expanse-invoice', [$invoice->id]) }}"
                       @else
                           action="{{ route('add-expanse-invoice',[$invoice->id])}}"
                       @endif
                       method="POST"
                   >
                       {{csrf_field()}}

                       <div class="row">
                           <div class="mb-3 col-6">
                               <label class="form-label" for="basic-default-fullname">Expanse Name*</label>
                               <select required name="expense_name" id="defaultSelect" class="form-select">
                                   <option> </option>
                                   @foreach($expenseNames as $expenseName)
                                       <option value="{{$expenseName->id}}">{{$expenseName->expense_name}}</option>
                                   @endforeach
                               </select>
                           </div>
                           <div class="mb-3 col-6">
                               <label class="form-label" for="basic-default-company">Amount*</label>
                               <input required name="amount" type="number" class="form-control" id="basic-default-company" placeholder="ACME Inc.">
                           </div>
                       </div>

                       <div class="row">
                           <div class="mb-3 col-6">
                               <label for="defaultSelect" class="form-label">Pay with*</label>
                               <select required name="pay_with" id="defaultSelect" class="form-select">
                                   <option> </option>
                                   <option value="Bkash">Bkash</option>
                                   <option value="Rocket">Rocket</option>
                                   <option value="Nagad">Nagad</option>
                                   <option value="Bank">Bank</option>
                                   <option value="SSL Commerz">SSL Commerz</option>
                                   <option value="Cash">Cash</option>
                               </select>
                           </div>
                           <div class="mb-3 col-6">
                               <label class="form-label" for="basic-default-fullname">Receiver Bank Name*</label>
                               <input required type="text" name="bank_name" class="form-control">
                           </div>
                       </div>

                       <div class="row">
                           <div class="mb-3 col-6">
                               <label class="form-label" for="basic-default-fullname">Receiver Account Number</label>
                               <input type="text" name="sent_to" class="form-control">
                           </div>
                           <div class="mb-3 col-6">
                               <label for="defaultSelect" class="form-label">Cash Out From*</label>
                               <select required name="account_id" id="defaultSelect" class="form-select">
                                   <option> </option>
                                   @foreach($accounts as $account)
                                       <option value="{{$account->id}}">{{$account->bank_name}}({{$account->account_number}})</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>

                       <div class="row">
                           <div class="col-6">
                               <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                               <textarea name="note" class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                           </div>
                           <div class="col-6">
                               <label for="html5-date-input" class="col-md-2 col-form-label">Date</label>
                               <input class="form-control" name="date" type="date" value="2021-06-18" id="html5-date-input">
                           </div>
                       </div>


                       <div class="text-center mt-2">
                           <button type="submit" class="btn btn-primary">Submit <i class='bx bx-plus'></i></button>
                       </div>
                   </form>
               </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
