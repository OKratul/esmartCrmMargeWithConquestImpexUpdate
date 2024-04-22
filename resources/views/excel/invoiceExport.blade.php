<table>
    <thead>
    <tr>
        <th>
            <b>
                SRL
            </b>
        </th>
        <th>
            <b>
                Year
            </b>
        </th>
        <th>
            <b>Month</b>
        </th>
        <th>
            <b>
                Created At Date
            </b>
        </th>
        <th>
            <b>User Name</b>
        </th>
        <th>
            <b>
                Customer info
            </b>
        </th>
        <th>
            <b>
                Invoice number
            </b>
        </th>
        <th>
            <b>
                Product Info
            </b>
        </th>
        <th>
            <b>
                Total
            </b>
        </th>
        <th>
            <b>Due</b>
        </th>
        <th>
            <b>Paid</b>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $index=> $invoice)

        @php

            $products = json_decode($invoice->products,true);

        @endphp

        <tr>
            <td>
                {{$index + 1}}
            </td>
            <td>
                {{$invoice->created_at->format('Y')}}
            </td>
            <td>
                {{$invoice->created_at->format('M')}}
            </td>
            <td>
                {{$invoice->created_at->format('d-m-Y')}}
            </td>
            <td>
                {{$invoice->users['name']}}
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
                    @php
                        $priceWithVat = $product['unit_price'] + $product['unit_price'] * $invoice->vat_tax / 100;
                        $totalPrice = $priceWithVat * $product['quantity'];
                        $productNameArray = explode(',', $product['product_name']);
                        $productNameWithBreaks = implode('<br>', $productNameArray);
                    @endphp
                    <p>
                        <b>
                           Product Name:
                        </b>
                        <span>
                            {{$product['product_name']}}
                        </span>
                    </p>
                    <p>
                        <b>
                           Product Code:
                        </b>
                        <span>{{$product['product_code']}}</span>
                    </p>
                    <p>
                        <b>Product Quantity:</b>
                        <span>{{$product['quantity']}}</span>
                    </p>
                    <p>
                        <b>
                           Product unit price:
                        </b>
                        <span>{{$product['unit_price']}}</span>
                    </p>
                    <p>------------------------</p>
                @endforeach
            </td>

            <td class="align-middle">
                total: {{$totalPrice}}<br>
            </td>
            <td>
                Due: {{ $totalPrice - $invoice->payments->sum('amount') }}
            </td>
            <td>
                paid: {{ $invoice->payments->sum('amount') }}<br>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
