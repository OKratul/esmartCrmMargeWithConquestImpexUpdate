<div class="table-responsive">
    <table class="table table-striped mb-0">
        <thead>
        <tr>
            <th>Created At</th>
            <th>Client Name/ Company Name</th>
            <th>Type</th>
            <th>Contact Person Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Query</th>
            <th>Quotation</th>
            <th>Invoice</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customers as $customer)
            <tr>
                <td>
                    {{$customer->created_at->format('d-m-Y')}}<br>
                    {{$customer->created_at->format('H:i a')}}
                </td>

                <td class="text-left">
                    <a href="{{ request()->routeIs('user-customers') ? route('user-customer-profile',[$customer->id]) : route('customer-profile', [$customer->id]) }}" class="">
                        <strong>{{$customer->name}}</strong>
                    </a>
                </td>
                <td class="text-left">
                    {{$customer->customer_type}}
                </td>
                <td class="text-left">
                    <b>{{$customer->contact_name}}</b>
                </td>
                <td class="text-left">
                    <b>
                        {{$customer->email}}
                    </b>
                </td>
                <td>
                    <b>{{$customer->phone_number}}</b>
                </td>
                <td>{{count($customer->queries)}}</td>
                <td>{{count($customer->quotations)}}</td>
                <td>{{count($customer->invoices)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-3">
        {{$customers->links('pagination::bootstrap-5')}}
    </div>
</div>
