<table class="table">
    <thead>
    <tr>
        <th><b>Srl</b></th>
        <th>
            <b>Year</b>
        </th>
        <th>
            <b>Month</b>
        </th>
        <th><b>Created At Date</b></th>
        <th>
            <b>User Name</b>
        </th>
        <th><b>Query Source</b></th>
        <th><b>Customer Info</b></th>
        <th><b>Query Status</b></th>
        <th><b>Product Sku</b></th>
        <th><b>Query Details</b></th>
        <th><b>Product Name</b></th>
        <th><b>Product Category</b></th>
        <th><b>Notes</b></th>
        <th><b>Customer Status</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($queries as $index => $query)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                {{$query->created_at->format('Y')}}
            </td>
            <td>
                {{$query->created_at->format('M')}}
            </td>
            <td>{{ $query->created_at->format('d-m-Y') }}</td>
            <td>
                @if(!empty($query->users))
                    {{ $query->users['name'] }}
                @else
                    User Not Found
                @endif
            </td>
            <td>{{ $query->query_source }}</td>
            <td>
                <p><b>Name:</b> {{ $query->customers['name'] }}</p>
                <p><b>Phone Number:</b> {{ $query->customers['phone_number'] }}</p>
                <p><b>Email:</b> {{ $query->customers['email'] }}</p>
                <hr>
            </td>
            <td>{{ $query->status }}</td>
            <td>{{ $query->product_sku }}</td>
            <td>{{ $query->query_details }}</td>
            <td>{{ $query->product_name }}</td>
            <td>{{ $query->product_category }}</td>
            <td>
                @if(!empty($query->notes))
                    @foreach($query->notes as $note)
                        <p><b>User:</b> {{ $note->user_name }}</p>
                        <p>{{ $note->notes }}</p>
                    @endforeach
                @endif
            </td>
            <td>
                @php
                    $customerQueryCount = \App\Models\Query::where('customer_id', $query->customers['id'])->count();
                @endphp
                {{ $customerQueryCount > 1 ? 'Repeated' : 'New Customer' }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="mt-4">
    <p><b>Total Queries:</b> {{ $queries->count() }}</p>
</div>
