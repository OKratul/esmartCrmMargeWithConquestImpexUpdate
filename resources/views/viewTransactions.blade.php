@if(request()->routeIs('user-view-transactions'))
    @include('user.partials.layoutHead')
@else
    @include('partials.layoutHead')
@endif
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @if(request()->routeIs('user-view-transactions'))
            @include('user.partials.sidebar')
        @else
            @include('partials.sidebar')
        @endif

        <div class="layout-page">
            @if(request()->routeIs('user-view-transactions'))
                @include('user.partials.navbar')
            @else
                @include('partials.navbar')
            @endif
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">

                    <div>
                        <div class="card">
                            <div class="p-4">
                                @include('error')
                                @include('success')
                            </div>

                            <div class="p-4">
                                <div class="text-center mb-4">
                                    <h5 >All Transactions</h5>
                                    <hr>
                                    <h5>Account Type :- {{$account['account_type']}}</h5>
                                    <h5>Bank Name :- {{$account['bank_name']}}</h5>
                                    <h5>Account Number :- {{$account['account_number']}}</h5>
                                    <h5>Balance :- {{$account['balance']}}</h5>
                                    <hr>
                                </div>
                            </div>
                            <div class="card-body">

                                <table class="table table-hover">
                                    <thead>
                                    <tr class="text-left">
                                        <th>Sl</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Sender/Receiver Account</th>
                                        <th>Note</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    @foreach($transactions as $index=>$transaction)
                                        <tr>
                                            <td class="text-left">
                                                {{$loop->iteration}}
                                            </td>
                                            <td class="text-left">
                                                {{$transaction->created_at}}
                                            </td>
                                            <td class="text-left">
                                                @if($transaction->status == 'Debit')
                                                    Cash In
                                                @else
                                                    Cash Out
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                @if(!empty($transaction->payments))
                                                    {{$transaction->payments['payment_with']}}<br>
                                                    {{$transaction->payments['bank_name']}}<br>
                                                    {{$transaction->payments['Ref_no']}}<br>
                                                @endif
                                                @if(!empty($transaction->expanses))
                                                    {{$transaction->expanses['receive_with']}}<br>
                                                    {{$transaction->expanses['bank_name']}}<br>
                                                    {{$transaction->expanses['receiver_account']}}<br>
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                {{$transaction->table_note}}
                                            </td>
                                            <td class="text-left">
                                                @if($transaction->status == 'Debit')
                                                    {{$transaction->amount}}.Tk
                                                @else
                                                    -{{$transaction->amount}}.Tk
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                {{$transaction->balance}}.Tk
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

@if(request()->routeIs('user-view-transactions'))
    @include('user.partials.layoutEnd')
@else
    @include('partials.layoutEnd')
@endif

