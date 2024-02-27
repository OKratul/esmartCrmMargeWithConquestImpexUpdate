<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conquest Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            margin-bottom: 0;
        }
        h4 {
            margin-top: 0;
        }
    </style>
</head>

<body>

<div>
    <table style="width: 100%;">
        <tbody>
        <tr>
            <td style="width: 50%">
                <h2>Invoice</h2>
            </td>
            <td style="width: 50%; text-align: right">
                <div>
                    <img src="{{$logo}}" width="200px" alt="Logo">
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    @php
        $products = [] ;

        $product_ids = explode('+', $invoice['product_id']);
        $quantities = explode('+', $invoice['quantity']);
        $unitPrices = explode('+', $invoice['unit_price']);
        $totalPrices = explode('+', $invoice['total_price']);

        foreach ($product_ids as $index => $product_id){
            $products[] = [
                'productId' => $product_id,
                'quantity' => $quantities[$index],
                'unit_price' => $unitPrices[$index],
                'total_price' => $totalPrices[$index],
            ];
        }
    @endphp


    <table style="margin-top: 50px; width: 100%;">
        <tbody>
        <tr>
            <td style="line-height: 20px; border: 1px solid #000000; padding: 10px 10px 10px 5px">
                <div>
                    <h4>Customer Details</h4>
                    <p><strong>Name:</strong> {{$invoice->customers['name']}}</p>
                    <p><strong>Contact Person:</strong> {{$invoice->customers['contact_person']}}</p>
                    <p><strong>Address:</strong> {{$invoice->customers['address']}}</p>
                    <p><strong>Phone No:</strong> {{$invoice->customers['phone']}}</p>
                </div>
            </td>
            <td style="text-align: right">
                <div>
                    <p>
                        108, Kazi Nazrul Islam Avenue<br>
                        Banglamotor, Dhaka
                    </p>
                    <p>
                        <strong>Hotline:</strong> +8801910900986
                    </p>
                    <p>
                        <strong>Email:</strong> conquestimpex@gmail.com
                    </p>
                </div>
            </td>
        </tr>

        <tr>
            <td>
                <p style="padding-top: 25px">
                    <strong>Invoice No: {{$invoice['invoice_number']}}</strong>
                </p>
            </td>
            <td style="text-align:right">
                <p>
                    <strong>{{ date('d M Y', strtotime($invoice['date'])) }}</strong>
                </p>
            </td>
        </tr>
        </tbody>
    </table>

    <table style="width: 100% ; margin-top: 20px">
        <thead>
        <tr style="border: 1px solid #cccccc">
            <th>Sl</th>
            <th>Name</th>
            <th>Code</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
        </thead>

        <tbody>
        @php
            $totalSum = 0; // Initialize the total sum variable
        @endphp
        @foreach($products as $index => $product)
            @php
                $productInfo = \App\Models\conquest\ConquestProduct::where('product_code', $product['productId'])->first();
                $totalSum += $product['total_price']; // Add the total_price to the total sum
            @endphp
            <tr style="border: 1px solid #cccccc">
                <td>{{ $loop->iteration }}</td>
                <td>{{$productInfo['name']}}</td>
                <td>{{ $product['productId'] }}</td>
                <td>{{$productInfo['size']}}</td>
                <td>{{ $product['quantity'] }}</td>
                <td>{{ $product['unit_price'] }}</td>
                <td>{{ $product['total_price'] }} /-</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold">Total Amount:</td>
            <td style="font-weight: bold">{{$totalSum}} /-</td>
        </tr>
        </tbody>
    </table>

    <div style="margin-top: 15px">
        @php
            $numberFormatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $totalPriceInWords = ucwords($numberFormatter->format($totalSum));
        @endphp
        <p>
            <b>Total Price (In Word):- </b> {{$totalPriceInWords}} Tk only
        </p>
    </div>
    <div style="margin-top: 100px">
        <table style="width: 100%">
            <tr>
                <td style="text-align: left">
                    <span style="border-top: 1px dashed #000">Authorised Signature</span>
                </td>
                <td style="text-align: right">
                    <span style="border-top: 1px dashed #000000">Customer Signature</span>
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
