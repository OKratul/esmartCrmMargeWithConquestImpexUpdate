@if(request()->routeIs('admin-view-add-expanses') || request()->routeIs('admin-view-add-expanse-invoice'))
    @include('partials.layoutHead')
@else
    @include('user.partials.layoutHead')
@endif

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @if(request()->routeIs('admin-view-add-expanses') || request()->routeIs('admin-view-add-expanse-invoice'))
            @include('partials.sidebar')
        @else
            @include('user.partials.sidebar')
        @endif
        <div class="layout-page">
            @if(request()->routeIs('admin-view-add-expanses') || request()->routeIs('admin-view-add-expanse-invoice'))
                @include('partials.navbar')
            @else
                @include('user.partials.navbar')
            @endif
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    @include('error')
                    @include('success')
                    <div class="customers">
                        <div class="card p-4">
                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="card">
                                        <div class="d-flex p-4 align-items-center justify-content-between">
                                            <h4>All Expenses</h4>

{{--                                            =======  filter  ======--}}
                                            <form method="GET" action="{{request()->routeIs('admin-view-add-expanses') ? route('admin-view-add-expanses') : route('user-filter-expanse')}}">
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
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Date</th>
                                                    <th>Invoice No</th>
                                                    <th>Expense Name</th>
                                                    <th>Amount</th>


                                                </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                @foreach($expanses as $key => $expanse)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            {{$expanse->date}}
                                                        </td>
                                                        <td>
                                                            @if($expanse->invoices)
                                                                {{$expanse->invoices['invoice_no']}}
                                                            @else
                                                                No Invoice
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{$expanse->expenseNames['expense_name']}}
                                                        </td>
                                                        <td>
                                                            {{$expanse->expanse_amount}}
                                                        </td>
{{--                                                        <td>--}}
{{--                                                            <div>--}}
{{--                                                                <button class="btn btn-sm btn-primary">--}}
{{--                                                                    <a class="text-white" href="{{route('user-view-update-expanse',[$expanse->id])}}">Edit</a>--}}
{{--                                                                </button>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                            {{ $expanses->links() }}
                                    </div>

                                    <div class="card mt-5 mb-5">
                                        <div class="date-filter p-2">
                                            <form method="GET"
                                                  @if(request()->routeIs('user-view-add-expanses') || request()->routeIs('user-filter-expanse') || request()->routeIs('user-search-expanse'))
                                                    action="{{route('user-view-add-expanses')}}"
                                                  @else
                                                  action="{{route('admin-view-add-expanses')}}">
                                                 @endif
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
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-borderless ">
                                                <thead class="text-left">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-left">
                                                @foreach($expenseNames as $index => $expenseName)
                                                    <tr>

                                                        <td>
                                                            <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$expenseName->expense_name}}</strong>
                                                        </td>
                                                        <td>
                                                            @php
                                                            $amount = 0;
                                                                foreach ($expenseName->expanses as $expanse)
                                                                    {
                                                                        $amount += $expanse->expanse_amount;
                                                                    };
                                                                echo '-'.$amount.'.Tk';
                                                            @endphp
                                                        </td>

                                                     </tr>
                                                @endforeach

                                                    <tr>
                                                        <hr>
                                                        <td>
                                                           <strong>
                                                               Total :-
                                                           </strong>
                                                        </td>
                                                        <td>
                                                            <strong>
                                                                @php
                                                                    $totalAmount = 0;
                                                                    foreach ($expenseNames as $expenseName) {
                                                                        foreach ($expenseName->expanses as $expanse) {
                                                                            $totalAmount += $expanse->expanse_amount;
                                                                        }
                                                                    }
                                                                    echo '-'.$totalAmount .'.tk';
                                                                @endphp
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl-4">
                                    <div class="card p-3 ">
                                        <h4>Add Expenses</h4>
                                        <div class="card-body text-left">
                                            <form
                                                @if(request()->routeIs('view-add-expanse-invoice'))
                                                    action="{{route('add-expanse-invoice',[$invoice_id])}}"
                                                @elseif(request()->routeIs('admin-view-add-expanses'))
                                                    action="{{route('admin-add-expanses')}}"
                                                @elseif(request()->routeIs('admin-view-add-expanse-invoice'))
                                                    action="{{route('admin-add-expanse-invoice',[$invoice_id])}}"
                                                @else
                                                action="{{route('user-add-expanses')}}"
                                                @endif
                                                method="POST">
                                                {{csrf_field()}}
                                                <div class="mb-3 row">
                                                    <label class="form-label" for="basic-default-fullname">Expanse Name*</label>
                                                    <select required name="expense_name" id="defaultSelect" class="form-select">
                                                        <option> </option>
                                                        @foreach($expenseNames as $expenseName)
                                                            <option value="{{$expenseName->id}}">{{$expenseName->expense_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="form-label" for="basic-default-company">Amount*</label>
                                                    <input required name="amount" type="number" class="form-control" id="basic-default-company" placeholder="ACME Inc.">
                                                </div>
                                                <div class="mb-3 row">
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
                                                <div class="mb-3 row">
                                                    <label class="form-label" for="basic-default-fullname">Receiver Bank Name*</label>
                                                    <input required type="text" name="bank_name" class="form-control">
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="form-label" for="basic-default-fullname">Receiver Account Number</label>
                                                    <input type="text" name="sent_to" class="form-control">
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="defaultSelect" class="form-label">Cash Out From*</label>
                                                    <select required name="account_id" id="defaultSelect" class="form-select">
                                                        <option> </option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{$account->id}}">{{$account->bank_name}}({{$account->account_number}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                                                    <textarea name="note" class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="html5-date-input" class="col-md-2 col-form-label">Date</label>
                                                     <input class="form-control" name="date" type="date" value="2021-06-18" id="html5-date-input">
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Add <i class='bx bx-plus' ></i></button>
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

</div>

@if(request()->routeIs('admin-view-add-expanses'))
    @include('partials.layoutEnd')
@else
    @include('user.partials.layoutEnd')
@endif
