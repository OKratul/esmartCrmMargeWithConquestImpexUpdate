
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
                Status
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
    </tr>
    </thead>
    <tbody>
    @foreach($queries as $query)

        <tr>
            <td>
                {{$query->created_at->format('d-m-Y')}}
            </td>
            <td>
                {{$query->query_source}}
            </td>
            <td>
                <p>
                    Name:-{{ $query->customers['name'] }}
                </p><br>
                <p>
                    Phone Number:-{{ $query->customers['phone_number'] }}
                </p><br>
                <p>
                    Email:-{{ $query->customers['email'] }}
                </p><br>
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
        </tr>
    @endforeach
    </tbody>
</table>
