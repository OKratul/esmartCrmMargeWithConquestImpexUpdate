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
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td style="width: 50%; text-align: left">
                        <h2>Challan</h2>
                    </td>
                    <td style="width: 50%; text-align: right " >
                        <img src="{{$logo}}" width="180px">
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="100%">
            <tbody>
                <tr>
                    <td>
                        <div>
                            <p><strong>Name:</strong> {{$invoice->customers['name']}}</p>
                            <p><strong>Email:</strong> {{$invoice->customers['email']}}</p>
                            <p><strong>Address:</strong> {{$invoice->customers['address']}}</p>
                            <p><strong>Receiver Name:</strong> {{$invoice->customers['contact_person']}}</p>
                            <p><strong>Receiver Phone:</strong> {{$invoice->customers['contact_person_number']}}</p>
                        </div>
                    </td>
                    <td style="text-align: right">
                        <div >
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
            </tbody>
        </table>

        <table style="width: 100%">
            <tr>
                <td style="text-align: left">
                    Challan Number:- #{{ $invoice->invoice_number }}</td>
                <td style="text-align: right">
                    <b>{{$invoice->created_at->format('dM Y')}}</b>
                </td>
            </tr>
            <!-- Add more details as needed -->
        </table>

        <div>
            <table>
                <thead>
                    <tr style="border: 1px solid #cccccc">
                        <td style="border: 1px solid #cccccc">Sl</td>
                        <td style="border: 1px solid #cccccc">Name</td>
                        <td style="border: 1px solid #cccccc">Code</td>
                        <td style="border: 1px solid #cccccc">Size</td>
                        <td style="border: 1px solid #cccccc">Quantity</td>
                    </tr>
                </thead>

                <tbody>
                @php
                    $products = [];

                    $product_ids = explode('+', $invoice['product_id']);
                    $quantities = explode('+', $invoice['quantity']);
                    $unitPrices = explode('+', $invoice['unit_price']);
                    $totalPrices = explode('+', $invoice['total_price']);

                    foreach ($product_ids as $index => $productId) {
                        $products[] = [
                            'productId' => $productId,
                            'quantity' => $quantities[$index],
                            'unit_price' => $unitPrices[$index],
                            'total_price' => $totalPrices[$index],
                        ];
                    }
                @endphp

                @php
                    $totalSum = 0; // Initialize the total sum variable
                @endphp
                @foreach($products as $index => $product)
                    @php
                        $productInfo = \App\Models\conquest\ConquestProduct::where('product_code', $product['productId'] )->first();
                    @endphp
                    @php
                        $productInfo = \App\Models\conquest\ConquestProduct::where('product_code', $product['productId'])->first();
                        $totalSum += $product['total_price']; // Add the total_price to the total sum
                    @endphp
                    <tr style="border: 1px solid #cccccc">
                        <td style="border: 1px solid #cccccc">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid #cccccc">
                            {{$productInfo['name']}}
                        </td>
                        <td style="border: 1px solid #cccccc">{{ $product['productId'] }}</td>

                        <td style="border: 1px solid #cccccc">
                            {{$productInfo['size']}}
                        </td>
                        <!-- Add other columns as needed -->
                        <td style="border: 1px solid #cccccc">{{ $product['quantity'] }}</td>

                    </tr>
                @endforeach

                </tbody>
            </table>

            <div style="margin-top: 100px">
                <table style="width: 100%">
                    <tr>
                        <td style="text-align: left">
                       <span style="border-top: 1px dashed #000">
                           Authorised Signature
                       </span>
                        </td>
                        <td style="text-align: right">
                        <span style="border-top: 1px dashed #000000">
                            Customer Signature
                        </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</body>
