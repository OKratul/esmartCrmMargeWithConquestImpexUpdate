<table>
    <thead>
    <tr>
        <th>
            SRL
        </th>
        <th>
            Year
        </th>
        <th>
            Month
        </th>
        <th>
            Created At Date
        </th>
        <th>
            User Name
        </th>
        <th>
            <h1>
                Customer info
            </h1>
        </th>
        <th>
            <h1>
                Quotation number
            </h1>
        </th>
        <th>
            <h1>
                Product Info
            </h1>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($quotations as $index=>$quotation)

        @php
            $products = json_decode($quotation->products,true);
        @endphp

        <tr>
            <td>
                {{$index + 1}}
            </td>
            <td>
                {{$quotation->created_at->format('Y')}}
            </td>
            <td>
                {{$quotation->created_at->format('M')}}
            </td>
            <td>
                {{$quotation->created_at->format('d-m-Y')}}
            </td>
            <td>
                {{$quotation->users['name']}}
            </td>
            <td>
                <p>
                    Name:-{{ $quotation->customers['name'] }}
                </p>
                <p>
                    Phone Number:-{{ $quotation->customers['phone_number'] }}
                </p>
                <p>
                    Email:-{{ $quotation->customers['email'] }}
                </p>
            </td>
            <td>{{$quotation->quotation_number}}</td>
            <td>
                @foreach($products as $product)
                    <p>
                        Product Name:{{$product['product_name']}}
                    </p>
                    <p>

                        Product Code:{{$product['product_code']}}
                    </p>
                    <p>
                        Product unit price:{{$product['unit_price']}}
                    </p>
                    <hr>
                @endforeach
            </td>
        </tr>
    @endforeach
        <tr>
            <td>
                {{$quotations->count()}}
            </td>
        </tr>

    </tbody>
</table>
