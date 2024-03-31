<table>
    <thead>
    <tr>
        <h1 style="font-size: 25px">
            All Invoice Data
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
                Invoice number
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
    @foreach($invoices as $invoice)

        @php
            $products = json_decode($invoice->products,true);
        @endphp

        <tr>
            <td>
                {{$invoice->created_at->format('d-m-Y')}}
            </td>
            <td>
                <p>
                    <b>Name:-</b>{{ $invoice->customers['name'] }}
                </p>
                <p>
                    <b>Phone Number:-</b>{{ $invoice->customers['phone_number'] }}
                </p>
                <p>
                    <b>Email:-</b>{{ $invoice->customers['email'] }}
                </p>
            </td>
            <td>{{$invoice->invoice_no}}</td>
            <td>
                @foreach($products as $product)
                    <p>
                        <b>
                           Product Name:
                        </b>
                        {{$product['product_name']}}
                    </p>
                    <p>
                        <b>
                           Product Code:
                        </b>
                        {{$product['product_code']}}
                    </p>
                    <p>
                        <b>
                           Product unit price:
                        </b>
                        {{$product['unit_price']}}
                    </p>
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
