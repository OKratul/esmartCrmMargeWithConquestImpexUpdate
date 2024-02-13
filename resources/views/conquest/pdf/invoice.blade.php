<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Invoice Pdf</title>
    <style>
       .invoice-details{
           border-collapse: collapse;
           width: 100%;
        }

        .invoice-details th {
            background-color: #f2f2f2; /* Header background color */
        }
        .invoice-details tr:hover {
            background-color: #f5f5f5; /* Hover background color */
        }
    </style>

</head>
<body>

    <div class="invoice-header">
      <table style="width: 100%">
          <tr>
              <td>
                  <h2>Invoice</h2>
              </td>
              <td style="text-align: right;">
{{--                  <img src="{{ $logo }}" alt="Company Logo" style="width: 150px; height: auto;">--}}
              </td>
          </tr>
      </table>
    </div>

    <div>
        <h4 >Customer Details</h4>
        <table style="width: 100%;">
            <td style="border: 1px solid #ccc; padding: 5px 10px 5px 0px">
                <div style="margin-left: 5px">
                    <p>
{{--                        <b>Name:</b> {{$invoice->customers['name']}}<br>--}}
{{--                        <b>Address:</b> {{$invoice->customers['address']}}<br>--}}
{{--                        <b>Phone No:</b> {{$invoice->customers['phone']}}<br>--}}
                    </p>
                </div>
            </td>
            <td style="text-align: right">
                <p>
                   <span> 108, Kazi Nazrul Islam Avenue<br>
                    Banglamotor, Dhaka</span><br>
                    <b>Hotline:- </b>+8801910900986<br>
                    <b>Email:-</b> conquestimpex@gmail.com

                </p>

            </td>
        </table>
        <table style="width: 100%">
            <tr>
{{--                <td style="text-align: left">--}}
{{--                    Invoice Number:- #{{ $invoice->invoice_number }}--}}
{{--                </td>--}}
                <td style="text-align: right">
{{--                    @if($invoice->date)--}}
{{--                         <b>{{$invoice->date}}</b>--}}
{{--                    @endif--}}
                </td>
            </tr>
            <!-- Add more details as needed -->
        </table>
    </div>

    <div >
        <table class="invoice-details" style="width:100%; border: 1px solid #cccccc">
            <thead>
                <tr style="border: 1px solid #cccccc">
                    <td style="border: 1px solid #cccccc">Sl</td>
                    <td style="border: 1px solid #cccccc">Name</td>
                    <td style="border: 1px solid #cccccc">Code</td>
                    <td style="border: 1px solid #cccccc">Size</td>
                    <td style="border: 1px solid #cccccc">Quantity</td>
                    <td style="border: 1px solid #cccccc">Unit Price</td>
                    <td style="border: 1px solid #cccccc">Total </td>
                </tr>
            </thead>
{{--            <tbody>--}}
{{--            @php--}}
{{--                $products = [];--}}

{{--                $product_ids = explode('+', $invoice['product_id']);--}}
{{--                $quantities = explode('+', $invoice['quantity']);--}}
{{--                $unitPrices = explode('+', $invoice['unit_price']);--}}
{{--                $totalPrices = explode('+', $invoice['total_price']);--}}

{{--                foreach ($product_ids as $index => $productId) {--}}
{{--                    $products[] = [--}}
{{--                        'productId' => $productId,--}}
{{--                        'quantity' => $quantities[$index],--}}
{{--                        'unit_price' => $unitPrices[$index],--}}
{{--                        'total_price' => $totalPrices[$index],--}}
{{--                    ];--}}
{{--                }--}}
{{--            @endphp--}}

{{--            @php--}}
{{--                $totalSum = 0; // Initialize the total sum variable--}}
{{--            @endphp--}}
{{--            @foreach($products as $index => $product)--}}
{{--                @php--}}
{{--                    $productInfo = \App\Models\conquest\ConquestProduct::where('product_code', $product['productId'] )->first();--}}
{{--                @endphp--}}
{{--                @php--}}
{{--                    $productInfo = \App\Models\conquest\ConquestProduct::where('product_code', $product['productId'])->first();--}}
{{--                    $totalSum += $product['total_price']; // Add the total_price to the total sum--}}
{{--                @endphp--}}
{{--                <tr style="border: 1px solid #cccccc">--}}
{{--                    <td style="border: 1px solid #cccccc">{{ $loop->iteration }}</td>--}}
{{--                    <td style="border: 1px solid #cccccc">--}}
{{--                        {{$productInfo['name']}}--}}
{{--                    </td>--}}
{{--                    <td style="border: 1px solid #cccccc">{{ $product['productId'] }}</td>--}}

{{--                    <td style="border: 1px solid #cccccc">--}}
{{--                        {{$productInfo['size']}}--}}
{{--                    </td>--}}
{{--                    <!-- Add other columns as needed -->--}}
{{--                    <td style="border: 1px solid #cccccc">{{ $product['quantity'] }}</td>--}}
{{--                    <td style="border: 1px solid #cccccc">{{ $product['unit_price'] }}</td>--}}
{{--                    <td style="border: 1px solid #cccccc">{{ $product['total_price'] }} /-</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            <tr>--}}
{{--                <td colspan="6" style="text-align: right">--}}
{{--                    Total Amount:---}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    {{$totalSum}} /---}}
{{--                </td>--}}
{{--            </tr>--}}
{{--            </tbody>--}}
        </table>

        <div style="margin-top: 15px">
{{--            @php--}}
{{--                $numberFormatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);--}}
{{--                $totalPriceInWords = ucwords($numberFormatter->format($totalSum));--}}
{{--            @endphp--}}

            <p>
{{--                <b>Total Price (In Word):- </b> {{$totalPriceInWords}} Tk only--}}
            </p>
        </div>
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

    <div class="invoice-footer">


    </div>

</body>

</html>
