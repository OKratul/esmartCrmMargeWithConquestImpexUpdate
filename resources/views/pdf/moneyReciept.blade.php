<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Receipt</title>
    <style>
        .money-receipt {
            text-align: center;
            width: 80%;
            padding: 20px;
            border: 1px solid #ccc;
            margin: auto;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .logo {
            width: 150px;
        }
        .address {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        table td {
            padding: 10px;
            border-bottom: 1px dotted #ccc;
        }
        .align-left {
            text-align: left;
        }
        .align-right {
            text-align: right;
        }
    </style>
</head>
<body>
<div class="money-receipt">
    <div style="line-height: 10px">
        <img class="logo" src="{{ public_path("images/pdf/pdf_logo2.png") }}" alt="eSmart.com.bd">
        <p class="address">House no 1/A, Flat B2</p>
        <p class="address">Eskaton Garden Road, Dhaka 1000</p>
        <p class="address">Hotline: 09617778877, 01316448804</p>
        <p class="address">Email: query@esmart.com.bd</p>
        <p class="address">Website: https://esmart.com.bd</p>
    </div>

    <div>
        <div class="align-left">Sl NO:-</div>
        <div class="align-right"><?php $date = \Carbon\Carbon::now()->format('d M, Y'); ?><strong>{{$date}}</strong></div>
    </div>

    <div>
        @foreach($payments as $payment)
            <table style="margin-top: 5px">
                <tr>
                    <td>Received with Thanks from:</td>
                    <td style="text-align: right">
                        @if(!empty($payment->customers))
                            <strong>{{ $payment->customers['name'] }}</strong>
                        @else
                            <strong>

                            </strong>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Amount in BDT:</td>
                    <td style="text-align: right">
                        <strong>
                            <?php
                            $numberFormatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            $totalPriceInWords = ucwords($numberFormatter->format($payment->amount));
                            echo $totalPriceInWords.' Tk. Only';
                            ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>Pay With:</td>
                    <td style="text-align: right">
                        <strong>{{ $payment->payment_with }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>BDT:</td>
                    <td style="text-align: right">
                        <strong>{{ $payment->amount }}.TK</strong>
                    </td>
                </tr>
                <tr>
                    <td>Payment Date</td>
                    <td style="text-align: right">
                        <strong>{{ $payment->payment_date}}</strong>
                    </td>

                </tr>
            </table>
        @endforeach
        <table>
            <tr>
                <td style="text-align: center">
                    <img src="{{public_path('images/pdf/seal_logo2-1.jpeg')}}" style="width: 100px; vertical-align: bottom"><br>
                    Authorised Signature
                </td>
                <td style="text-align: center;vertical-align: bottom">
                    Received By
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
