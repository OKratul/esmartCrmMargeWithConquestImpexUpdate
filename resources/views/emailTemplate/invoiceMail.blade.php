<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo public_path('Asset/css/pdfStyle.css'); ?>">
    <title>Quotation Pdf</title>
</head>
<body>
<div class="container">
    <div>
        <p>Dear,{{ $invoice->customers['name']}}</p>
        <p>Please check attachment.</p>
    </div>
    <div>
        <p>Best Regards</p>
        <img src="https://crm.esmart.com.bd/images/pdf/pdf_logo2.png" style="width: 180px; margin-bottom: 15px"><br>
        <a href="https://esmart.com.bd/">eSmart Bangladesh</a>
        <p>09617778877,01316448804</p>
        House no 1/A, Flat B2
    </div>

    <div>

    </div>
{{--    <table class="pdf-body" style="width: 100%;">--}}
{{--        <tr>--}}
{{--            <td style="width: 50%;">--}}
{{--                <h3>Invoice</h3>--}}
{{--            </td>--}}
{{--            <td style="width: 50%; text-align: right;">--}}
{{--                <img src="<?php echo public_path('images/pdf/pdf_logo2.png'); ?>" style="width: 180px">--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td style="line-height: 20px; border:1px solid #000000;padding: 10px 10px 10px 5px">--}}
{{--                <p><strong>Name:-</strong> <?php echo $invoice->customers['name']; ?></p>--}}
{{--                <p><strong>Address:-</strong> <?php echo $invoice->customers['address'] . ',' . $invoice->customers['city'] . ',' . $invoice->customers['country']; ?></p>--}}
{{--                <p><strong>Email:-</strong> <?php echo $invoice->customers['email']; ?></p>--}}
{{--                <p><strong>Name:-</strong> <?php echo $invoice->customers['phone_number']; ?></p>--}}
{{--            </td>--}}
{{--            <td style="text-align: right;line-height: 20px;padding-top: 10px">--}}
{{--                <p>House no 1/A, Flat B2</p>--}}
{{--                <p>Eskaton Garden Road, Dhaka 1000</p>--}}
{{--                <p><strong>Hotline:</strong> 0961778877, 01316448804</p>--}}
{{--                <p><strong>Email:</strong> query@esmart.com.bd</p>--}}
{{--                <p><strong>Website:</strong> https://esmart.com.bd</p>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td style="font-size:16px; padding-top:10px ; ">--}}
{{--                <p><strong>Invoice No:</strong> #<?php echo $invoice->invoice_no; ?></p>--}}
{{--            </td>--}}
{{--            <td style="text-align: right; font-size:16px">--}}
{{--                <?php $date = \Carbon\Carbon::now()->format('d M, Y'); ?>--}}
{{--                <p><strong> <?php echo $date; ?></strong></p>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}

{{--    <table style="border-collapse: collapse; width: 100%;">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th style="border: 1px solid #304051; padding: 8px;">SL</th>--}}
{{--            <th style="border: 1px solid #304051; padding: 8px;">Product Name</th>--}}
{{--            <th style="border: 1px solid #304051; padding: 8px;">Product Code</th>--}}
{{--            <th style="border: 1px solid #304051; padding: 8px;">Description</th>--}}
{{--            <th style="border: 1px solid #304051; padding: 8px;">Quantity</th>--}}
{{--            <th style="border: 1px solid #304051; padding: 8px;">Unit Price</th>--}}
{{--            <th style="border: 1px solid #304051; padding: 8px;">Total Price</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        <?php--}}
{{--        $totalPrice = 0;--}}
{{--        $products = json_decode($invoice->products, true);--}}
{{--        foreach ($products as $key => $product) {--}}
{{--        $priceWithVat = $product['unit_price'] + $product['unit_price'] * $invoice->vat_tax / 100;--}}
{{--        $totalPrice += $priceWithVat * $product['quantity'];--}}
{{--        ?>--}}
{{--        <tr>--}}
{{--            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $key + 1; ?></td>--}}
{{--            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $product['product_name']; ?></td>--}}
{{--            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $product['product_code']; ?></td>--}}
{{--            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $product['description']; ?></td>--}}
{{--            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $product['quantity']; ?></td>--}}
{{--            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $priceWithVat; ?></td>--}}
{{--            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $priceWithVat * $product['quantity']; ?></td>--}}
{{--        </tr>--}}
{{--        <?php } ?>--}}
{{--        </tbody>--}}
{{--        <tfoot>--}}
{{--        @if($invoice->delivery_charge)--}}
{{--            <tr>--}}
{{--                <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">--}}
{{--                    <strong>Delivery Charge Include</strong>--}}
{{--                </td>--}}
{{--                <td style="border: 1px solid #304051; padding: 8px;">--}}
{{--                    <?php--}}
{{--                    $deliveryCharge = $invoice->delivery_charge;--}}
{{--                    echo $deliveryCharge;--}}
{{--                    ?>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endif--}}
{{--        @if($invoice->extra_amount)--}}
{{--            <tr>--}}
{{--                <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">--}}
{{--                    <strong>{{$invoice->extra_charge_name}}</strong>--}}
{{--                </td>--}}
{{--                <td style="border: 1px solid #304051; padding: 8px;">--}}
{{--                    {{$invoice->extra_amount}}--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endif--}}
{{--        @if($invoice->discount_amount)--}}
{{--            <tr>--}}
{{--                <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">--}}
{{--                    <strong>Discount</strong>--}}
{{--                </td>--}}
{{--                <td style="border: 1px solid #304051; padding: 8px;">--}}
{{--                    -{{$invoice->discount_amount}}--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endif--}}
{{--        <tr>--}}
{{--            <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">--}}
{{--                <strong>Total:</strong>--}}
{{--            </td>--}}
{{--            <td style="border: 1px solid #304051; padding: 8px;">--}}
{{--                <?php--}}
{{--                $totalPrice = $totalPrice + ($invoice->delivery_charge ?? 0) + ($invoice->extra_amount ?? 0) - ($invoice->discount_amount ?? 0);--}}
{{--                echo $totalPrice;--}}
{{--                ?>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">--}}
{{--                <strong>Paid:</strong>--}}
{{--            </td>--}}
{{--            <td style="border: 1px solid #304051; padding: 8px;">--}}
{{--                @php( $totalPayment = 0)--}}
{{--                @foreach($invoice->payments as $payment)--}}
{{--                    @php($totalPayment += $payment->amount)--}}
{{--                @endforeach--}}
{{--                {{$totalPayment}}--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">--}}
{{--                <strong>Due:</strong>--}}
{{--            </td>--}}
{{--            <td style="border: 1px solid #304051; padding: 8px;">--}}
{{--                {{$totalPrice - $totalPayment}}--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        </tfoot>--}}
{{--    </table>--}}

{{--    <p>--}}
{{--        <strong>Total Price (In Words):</strong>   <?php--}}
{{--        $numberFormatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);--}}
{{--        $totalPriceInWords = ucwords($numberFormatter->format($totalPrice));--}}
{{--        echo $totalPriceInWords.' Tk. Only';--}}
{{--        ?>--}}
{{--    </p>--}}
{{--    <div class="quotation-foot">--}}
{{--        <p><strong>Offer Validity:</strong>{{$invoice->offer_validity}}</p>--}}
{{--        <p><strong>Warranty:</strong>{{$invoice->offer_validity}}</p>--}}
{{--        @if($invoice->vat_tax == 7.5)--}}
{{--            <strong>Vat include 7.5%</strong>--}}
{{--        @elseif($invoice->vat_tax == 3)--}}
{{--            <strong>--}}
{{--                Ait Include 3%--}}
{{--            </strong>--}}
{{--        @else--}}
{{--            <strong>Vat & Ait Exclude</strong>--}}
{{--        @endif--}}
{{--        <p>--}}
{{--            <strong>Delivery Term:</strong> {{$invoice->delivery_term}}--}}
{{--        </p>--}}
{{--        <p>--}}
{{--            <strong>Delivery Time:</strong> <strong>Delivery Time:</strong> Within {{ \Carbon\Carbon::now()->diffInWeekdays($invoice->delivery_date) }} working days--}}
{{--        </p>--}}

{{--        <div style="line-height: 8px;">--}}
{{--            <img src="{{public_path('images/pdf/seal_logo2-1.jpeg')}}" style="width: 120px">--}}
{{--            <p>Best Regards</p>--}}
{{--            @if(!empty($invoice->users))--}}
{{--                <p>{{$invoice->users['name']}}</p>--}}
{{--            @else--}}
{{--                <p>{{$invoice->admins['username']}}</p>--}}
{{--            @endif--}}
{{--            <p>Business Development Executive</p>--}}
{{--        </div>--}}
{{--        <div style="line-height: 8px;width: 50%; ">--}}
{{--            --}}{{--            <img src="<?php echo public_path('images/pdf/pdf_logo2.png'); ?>" style="width: 180px" alt="eSmart Bangladesh">--}}
{{--            <p>eSmart Bangladesh</p>--}}
{{--            <p>House no 1/A, Flat B2</p>--}}
{{--        </div>--}}
{{--    </div>--}}

</div>
</body>
</html>
