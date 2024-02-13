<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('Asset/css/pdfStyle.css') }}">
    <title>Quotation Pdf</title>
</head>
<body>
<div class="container">
    <table class="pdf-body" style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <h3>Challan</h3>
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
    
                 <div>
                     <div>
                         <p><strong>Name:</strong> {{$invoice->customers['name']}}</p>
                         <p><strong>Email:</strong> {{$invoice->customers['email']}}</p>
                         @if(!empty($invoice->delivery_address))
                         <p><strong>Delivery Address:</strong> {{$invoice->delivery_address}}</p>
                         @else
                            <p><strong>Address:</strong> {{$invoice->customers['address']}}, {{$invoice->customers['city']}}, {{$invoice->customers['country']}}</p>
                         @endif
                         
                         @if(!empty($invoice->receiver_name))
                         <p><strong>Receiver Name:</strong> {{$invoice->receiver_name}}</p>
                         @else
                        <p><strong>Receiver Name:</strong> {{$invoice->customers['contact_name']}}</p>
                         @endif
                         
                         @if(!empty($invoice->receiver_number) )
                         <p><strong>Receiver Phone:</strong> {{$invoice->receiver_number}}</p>
                         @else
                         <p><strong>Receiver Phone:</strong> {{$invoice->customers['phone_number']}}</p>
                         @endif
                     </div>
                 </div>
         
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
                <p><strong>Challan No:</strong> #CHA-{{$invoice->created_at->format('ymdhis')}}</p>
            </td>
            <td style="text-align: right; font-size:16px">
                <?php $date = \Carbon\Carbon::now()->format('d M, Y'); ?>
                <p><strong>{{$date}}</strong></p>
            </td>
        </tr>
    </table>

    <table style="border-collapse: collapse; width: 100%;">
        <thead>
        <tr>
            <th style="border: 1px solid #304051; padding: 8px;">SL</th>
            <th style="border: 1px solid #304051; padding: 8px;">Product Name</th>
            <th style="border: 1px solid #304051; padding: 8px;">Product Code</th>
            <th style="border: 1px solid #304051; padding: 8px;">Quantity</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $totalPrice = 0;
        $products = json_decode($invoice->products, true);
        ?>
        @foreach($products as $key=>$product)
            <tr>
                <td style="border: 1px solid #304051; padding: 8px; text-align: center;">{{$loop->iteration}}</td>
                <td style="border: 1px solid #304051; padding: 8px;text-align: center;">{{$product['product_name']}}</td>
                <td style="border: 1px solid #304051; padding: 8px;text-align: center;">{{$product['product_code']}}</td>
                <td style="border: 1px solid #304051; padding: 8px;text-align: center;">{{$product['quantity']}} {{$product['unit']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 100px">
        <tr>
            <td>
                <img src="{{public_path('images/pdf/seal_logo2-1.png')}}" style="width: 90px"><br>
                <span style="vertical-align: bottom;">Authorized Signature</span>
            </td>
            <td style="text-align: right;vertical-align:bottom">
                <span>Customer Signature</span>
            </td>
        </tr>
    </table>

    <div style="text-align: center; margin-top: 100px">
        <p>
            Any Shortage or damage must be notified within 72 hours of receipt of goods. Complaints can only be accepted if
            made in writing within 72 hours of receipt of goods. No goods may be returned without prior authorization from
            the company.
        </p>
        <h4>
            <strong>Thank you for your business!</strong>
        </h4>
        <p>
            If you have any inquiries concerning this delivery note, please contact esmart.com.bd on
            09617778877, 01316448804.
        </p>
        <p>
            House no 1/A, Flat B2, Eskaton Garden Road, Dhaka 1000.
            E-mail: query@esmart.com.bd, Web: https://esmart.com.bd
        </p>
    </div>
</div>
</body>
</html>
