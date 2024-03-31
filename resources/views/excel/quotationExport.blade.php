<table>
    <thead>
    <tr>
        <h1 style="font-size: 25px">
            All Quotation Data
        </h1>
    </tr>
    <tr>
        <th>
            Created At Date
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
    @foreach($quotations as $quotation)

        @php
            $products = json_decode($quotation->products,true);
        @endphp

        <tr>
            <td>
                {{$quotation->created_at->format('d-m-Y')}}
            </td>
            <td>
                <p>
                    Name:-{{ $quotation->customers['name'] }}
                </p>
                <br>
                <p>
                    Phone Number:-{{ $quotation->customers['phone_number'] }}
                </p>
                <br>
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
                    <br>
                    <p>

                        Product Code:{{$product['product_code']}}
                    </p>
                    <br>
                    <p>
                        Product unit price:{{$product['unit_price']}}
                    </p>
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
