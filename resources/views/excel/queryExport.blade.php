
<table>
    <thead>
    <tr>
        <h1 style="font-size: 25px">
            <b>
                All Queries Data
            </b>
        </h1>
    </tr>
    <tr>
        <th>
            <b>
                Srl
            </b>
        </th>
        <th>
            <b>
                Created At Date
            </b>
        </th>
        <th>
            <b>
                Query Source
            </b>
        </th>
        <th>
            <b>
                Customer info
            </b>
        </th>
        <th>
            <b>
               Query Status
            </b>
        </th>
        <th>
            <b>
                Product Sku
            </b>
        </th>

        <th>
            <b>
                Query Details
            </b>
        </th>
        <th>
            <b>
                Product Name
            </b>
        </th>
        <th>
            <b>
                Product Category
            </b>
        </th>
        <th>
            <b>
                Notes
            </b>
        </th>
        <th>
            <b>Customer Status</b>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($queries as $index => $query)

        <tr>
            <td>
                {{$loop->iteration}}
            </td>
            <td>
                {{$query->created_at->format('d-m-Y')}}
            </td>
            <td>
                {{$query->query_source}}
            </td>
            <td>
                <p>
                    Name:-{{ $query->customers['name'] }};
                </p>
                <p>
                    Phone Number:-{{ $query->customers['phone_number'] }};
                </p>
                <p>
                    Email:-{{ $query->customers['email'] }}
                </p>
                <hr>
            </td>
            <td>
                    {{$query->status}}
            </td>
            <td>
                    {{$query->product_sku}}
            </td>
            <td>
                    {{$query->query_details}}
            </td>
            <td>
                    {{$query->product_name}}
            </td>
            <td>
                    {{$query->product_category}}
            </td>
            <td>
                @if(!empty($query->notes))
                    @foreach($query->notes as $note)
                        <p>
                            <span>user:- {{$note->user_name}}</span><br>
                            {{$note->notes}}
                        </p>
                        <br>
                    @endforeach
                @endif
            </td>
            <td>
                @php
                    // Get the customer ID
                    $customer_id = $query->customers['id'];
                    // Count the number of queries for this customer
                    $customerQueryCount = \App\Models\Query::where('customer_id', $customer_id)->count();
                @endphp

                @if($customerQueryCount > 1)
                    <p>Repeated</p>
                @else
                    <p>New Customer</p>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
