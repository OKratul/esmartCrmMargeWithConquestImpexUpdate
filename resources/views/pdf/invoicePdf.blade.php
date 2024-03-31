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
    <table class="pdf-body" style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <h3 style="font-size: 28px">Invoice</h3>
            </td>
            <td style="width: 50%; text-align: right;">
                @if($invoice->logo == 'Esmart')
                    <img src="<?php echo public_path('images/pdf/pdf_logo2.png'); ?>" style="width: 180px">
                @else
                    <img src="<?php echo public_path('images/pdf/Asset 1.png'); ?>" style="width: 180px">
                @endif
            </td>
        </tr>
        <tr>
            <td style="line-height: 20px; border:1px solid #000000;padding: 10px 10px 10px 5px">
                <p><strong>Name:-</strong> <?php echo $invoice->customers['name']; ?></p>
                <p><strong>Address:-</strong> <?php echo $invoice->customers['address'] . ',' . $invoice->customers['city'] . ',' . $invoice->customers['country']; ?></p>
                <p><strong>Email:-</strong> <?php echo $invoice->customers['email']; ?></p>
                <p><strong>Phone Number:-</strong> <?php echo $invoice->customers['phone_number']; ?></p>
                @if(!empty($invoice->customers['contact_name']) || !empty($invoice['receiver_name']))
                    <p><strong>Contact Name:-</strong> <?php echo $invoice['receiver_name']; ?></p>
                    @if(!empty($invoice->phone_number) || !empty($invoice['receiver_number']) )
                        <p><strong>Phone Number:-</strong> <?php echo $invoice['receiver_number']; ?></p>
                    @endif
                @endif
            </td>
            <td style="text-align: right;line-height: 20px;padding-top: 10px">
                <p>House no 1/A, Flat B2</p>
                <p>Eskaton Garden Road, Dhaka 1000</p>
                <p><strong>Hotline:</strong> 0961778877, 01316448804</p>
                <p><strong>Email:</strong> query@esmart.com.bd</p>
                <p><strong>Website:</strong> https://esmart.com.bd</p>
            </td>
        </tr>
        <tr>
            <td style="font-size:16px; padding-top:10px ; ">
                <p><strong>Invoice No:</strong> #<?php echo $invoice->invoice_no; ?></p>
            </td>
            <td style="text-align: right; font-size:16px">
                <?php $date = $invoice->created_at->format('d M Y'); ?>
                <p><strong> <?php echo $date; ?></strong></p>
            </td>
        </tr>
    </table>

    <table style="border-collapse: collapse; width: 100%;">
        <thead>
        <tr>
            <th style="border: 1px solid #304051; padding: 8px;">SL</th>
            <th colspan="2" style="border: 1px solid #304051; padding: 8px;">Product Name</th>
            <th style="border: 1px solid #304051; padding: 8px;">Product Code</th>
            <th style="border: 1px solid #304051; padding: 8px;">Quantity</th>
            <th style="border: 1px solid #304051; padding: 8px;">Unit Price</th>
            <th style="border: 1px solid #304051; padding: 8px;">Total Price</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $totalPrice = 0;
        $products = json_decode($invoice->products, true);
        foreach ($products as $key => $product) {

        if($invoice->vat_tax == 10.5){
             $priceWithAit = floatval($product['unit_price']) + floatval($product['unit_price']) * 3 / 100;
             $priceWithVat = $priceWithAit + $priceWithAit * 7.5 / 100 ;
             $totalPrice += floatval($priceWithVat )* floatval( $product['quantity']);
        }else{
            $priceWithVat = floatval($product['unit_price']) + floatval($product['unit_price']) * floatval($invoice->vat_tax / 100);
            $totalPrice += floatval($priceWithVat )* floatval( $product['quantity']);
        }

        ?>
        <tr>
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $key + 1; ?></td>
            <td colspan="2" style="border: 1px solid #304051; padding: 8px;"><?php echo $product['product_name']; ?></td>
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $product['product_code']; ?></td>
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $product['quantity']; ?></td>
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo number_format($priceWithVat, 2). ' /-'; ?></td>
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo number_format(floatval($priceWithVat) * floatval($product['quantity']), 2). ' /-'?></td>
        </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        @if($invoice->delivery_charge)
            <tr>
                <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">
                    <strong>Delivery Charge Include</strong>
                </td>
                <td style="border: 1px solid #304051; padding: 8px;">
                    <?php
                        $deliveryCharge = floatval($invoice->delivery_charge);
                         echo number_format( $deliveryCharge, 2). ' /-';
                    ?>
                </td>
            </tr>
            @else
                @php($deliveryCharge = 0)
        @endif
        @if($invoice->extra_amount)
            <tr>
                <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">
                    <strong>{{$invoice->extra_charge_name}}</strong>
                </td>
                <td style="border: 1px solid #304051; padding: 8px;">
                    {{number_format($invoice->extra_amount, 2) .' /-'}}
                </td>
            </tr>
        @endif
        @if($invoice->discount)
            <tr>
                <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">
                    <strong>Total Discount</strong>
                </td>
                <td style="border: 1px solid #304051; padding: 8px;">
                    -{{number_format($invoice->discount, 2). ' /-'}}
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">
                <strong>Total:</strong>
            </td>
            <td style="border: 1px solid #304051; padding: 8px;">
                <?php
                $discountAmount = floatval($invoice->discount);
                $totalPrice = floatval($totalPrice) - (floatval($invoice->discount_amount) ?? 0) + floatval($deliveryCharge) - ($discountAmount ?? 0);
                echo number_format($totalPrice, 2) . ' /-';
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">
                <strong>Paid:</strong>
            </td>
            <td style="border: 1px solid #304051; padding: 8px;">
                @php( $totalPayment = 0)
                @foreach($invoice->payments as $payment)
                    @php($totalPayment += floatval($payment->amount))
                @endforeach
                {{ number_format($totalPayment, 2) }} /-
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">
                <strong>Due:</strong>
            </td>
            <td style="border: 1px solid #304051; padding: 8px;">
                @if(floatval($totalPrice) <= floatval($totalPayment))
                    00.00 tk
                @else
                    {{ number_format(floatval($totalPrice) - floatval($totalPayment), 2). ' /-' }}
                @endif
            </td>
        </tr>

        </tfoot>
    </table>

   <p>
        <strong>Total Price (In Words):</strong> <?php
        $numberFormatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $formattedTotalPrice = number_format(floatval($totalPrice), 2, '.', ''); // Format with two decimal places
        $totalPriceInWords = ucwords($numberFormatter->format($formattedTotalPrice));
        echo $totalPriceInWords . ' Tk. Only';
        ?>
    </p>

    <div class="quotation-foot">
        <p><strong>Warranty:</strong> {{$invoice->warranty}}</p>
        @if($invoice->vat_tax == 7.5)
            <strong>Vat include 7.5%</strong>
        @elseif($invoice->vat_tax == 3)
            <strong>
                Ait Include 3%
            </strong>
        @elseif($invoice->vat_tax == 10.5)
            <strong>Vat & Ait Include</strong>
        @else
            <strong>Vat & Ait Exclude</strong>
        @endif
        <p>
            <strong>Delivery Term:</strong> {{$invoice->delivery_term}}
        </p>
        <?php
            $deliveryTime = $invoice->delivery_date
        ?>

        @if($deliveryTime > 0)
        <p>
            <strong>Delivery Date:</strong>  {{ date("d M Y", strtotime($deliveryTime)) }}
        </p>
        @elseif($deliveryTime == 0)
            <strong>Delivery Time:</strong>
        @endif

        @if(!empty($invoice->other_condition))
            <strong>Other Condition:</strong> {{$invoice->other_condition}}
        @endif

        <div style="line-height: 8px;">
            @if($invoice->logo == 'Esmart')
                <img src="{{public_path('images/pdf/seal_logo2-1.png')}}" style="width: 90px">
            @else
                <img src="{{public_path('images/pdf/Impex Seal.png')}}" style="width: 90px">
            @endif
                <p>Best Regards</p>
            @if(!empty($invoice->users))
                <p>{{$invoice->users['name']}}</p>
            @else
                <p>{{$invoice->admins['username']}}</p>
            @endif
            <p>Business Development Executive</p>
        </div>
        <div style="line-height: 8px;width: 50%; ">
{{--            <img src="<?php echo public_path('images/pdf/pdf_logo2.png'); ?>" style="width: 180px" alt="eSmart Bangladesh">--}}
            <p>eSmart Bangladesh</p>
            <p>House no 1/A, Flat B2</p>
            <p>Eskaton Garden Road, Dhaka 1000</p>
            <p><strong>Hotline:</strong> 0961778877, 01316448804</p>
            <p><strong>Email:</strong> query@esmart.com.bd</p>
            <p><strong>Website:</strong> https://esmart.com.bd</p>
        </div>
    </div>

</div>
</body>
</html>
