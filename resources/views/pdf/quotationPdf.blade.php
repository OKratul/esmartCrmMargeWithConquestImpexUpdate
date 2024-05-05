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
@php
    $pdfSetup = \App\Models\PDFsetup::where('name',$quotation->logo)->first();
@endphp
<div class="container">
    <table class="pdf-body" style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <h3 style="font-size: 24px">Price Quotation</h3>
            </td>
            <td style="width: 50%; text-align: right;">
                <img src="<?php echo public_path('images/pdf/' . $pdfSetup['logo']); ?>" style="width: 180px">

                {{--                @if($quotation->logo == 'Esmart')--}}
{{--                    <img src="<?php echo public_path('images/pdf/pdf_logo2.png'); ?>">--}}
{{--                @else--}}
{{--                    <img src="<?php echo public_path('images/pdf/Asset 1.png'); ?>" style="width: 180px">--}}
{{--                @endif--}}


            </td>
        </tr>
        <!-- Other header content -->
        <tr>
            <td style="line-height: 20px; border:1px solid #000000;padding: 10px 10px 10px 5px">
                <p><strong>Name:-</strong> {{ $quotation->customers['name'] }}</p>
                <p><strong>Address:-</strong> {{ $quotation->customers['address'] }}, {{ $quotation->customers['city'] }}, {{ $quotation->customers['country'] }}</p>
                <p><strong>Email:-</strong> {{ $quotation->customers['email'] }}</p>
                <p>
                    <strong>Contact Person: </strong> {{$quotation->customers['contact_name']}}
                </p>
                <p><strong>Phone:-</strong>
                    @if(!empty($quotation->phone_number))
                        {{$quotation->phone_number}}
                    @else
                        {{ $quotation->customers['phone_number'] }}
                    @endif
                </p>
            </td>
            <td style="text-align: right;line-height: 20px;padding-top: 10px">
                <p>{!! $pdfSetup['address'] !!}</p>
                <p><strong>Hotline:</strong> {{$pdfSetup['hotline']}}</p>
                <p><strong>Email:</strong> {{$pdfSetup['email']}}</p>
                <p><strong>Website:</strong> {{$pdfSetup['website']}}</p>
            </td>
        </tr>
        <tr>
            <td style="font-size:16px; padding-top:10px ; ">
                <p><strong>Quotation No:</strong>{{ $quotation->quotation_number }}</p>
            </td>
            <td style="text-align: right; font-size:16px">
                <?php $date = $quotation->updated_at->format('d M, Y'); ?>
                <p><strong> {{ $date }}</strong></p>
            </td>
        </tr>
        <tr>
            <td colspan="8">
                <p>Dear, <br>
                    <strong>{{ $quotation->customers['name'] }}</strong></p>
                <p style="margin-bottom: 10px">
                    Upon your request for a quotation, here we enclose our price quotation offer for
                    <?php
                    $products = json_decode($quotation->products, true);
                    foreach ($products as $product) {
                        echo $product['product_name'] . ', ';
                    }
                    ?>
                </p>
            </td>
        </tr>
    </table>

    <table style="border-collapse: collapse; width: 100%;">
        <thead>
        <tr>
            <!-- Table header rows here -->
            <th style="border: 1px solid #304051; padding: 8px;">SL</th>
            <th style="border: 1px solid #304051; padding: 8px;">Product Name</th>
            <th style="border: 1px solid #304051; padding: 8px;">Product Code</th>
            <th style="border: 1px solid #304051; padding: 8px;">Description/Image</th>
            <th style="border: 1px solid #304051; padding: 8px;">QT</th>
            <th style="border: 1px solid #304051; padding: 8px;">Unit Price</th>
            <th style="border: 1px solid #304051; padding: 8px;">Total Price</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $totalPrice = 0;
        $products = json_decode($quotation->products, true);

        foreach ($products as $key => $product) {
        $unitPrice = $product['unit_price'];
        $priceWithVat = 0; // Initialize $priceWithVat

        if (!empty($quotation->vat_tax)) {
            if ($quotation->vat_tax == 10.5) {
                $priceWithAit = $unitPrice + floatval($unitPrice) * 3 / 100;
                $priceWithVat = $priceWithAit + $priceWithAit * 7.5 / 100;
                $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
            } else {
                $priceWithVat = $unitPrice + floatval($unitPrice) * floatval($quotation->vat_tax) / 100;
                $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
            }
        } else {
            $subTotal = $unitPrice * $product['quantity'];
            $priceWithVat = $unitPrice;
        }

        $totalPrice += $subTotal; // Update the total price

        ?>
        <tr>
            <!-- Table rows for product details here -->
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $key + 1; ?></td>
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $product['product_name']; ?></td>
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $product['product_code']; ?></td>
            <td style="border: 1px solid #304051; padding: 8px;">
                <div>
                    <?php echo $product['description']; ?> <br>

                </div>
                @if(!empty($product['product_image']))
                    <div>
                        <hr>
                        <img src="<?php echo public_path('images/quotationProduct/').$product['product_image']; ?>" style="width: 180px">
                    </div><br>
                @endif
            </td>
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo $product['quantity'], ' ' . $product['unit']; ?></td>
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo number_format($priceWithVat,2,'.',''); ?></td>
            <td style="border: 1px solid #304051; padding: 8px;"><?php echo number_format($subTotal,2,'.',''); ?></td>
        </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <!-- Footer rows and calculations here -->
        @if(!empty($quotation->delivery_check))
            <tr>
                <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">
                    <span style="font-size: 14px">
                        @if(!empty($quotation->delivery_check))
                            <strong>Delivery Charge Applicable</strong>
                        @elseif(!empty($quotation->delivery_charge))
                            <strong>Delivery Charge Include</strong><br>
                        @else
                            (Delivery Charge Not Applicable)
                        @endif
                    </span>
                </td>
                <td style="border: 1px solid #304051; padding: 8px;">
                    @if(!empty($quotation->delivery_check) && !empty($quotation->delivery_charge))
                        <?php
                        $deliveryCharge = floatval(preg_replace('/[^0-9]/', '', $quotation->delivery_charge));
                        echo number_format($deliveryCharge, 2, '.', '') . ' ' . preg_replace('/[0-9]/', '', $quotation->delivery_charge);
                        ?>
                    @endif


                </td>>
            </tr>
        @else
            <tr>
                <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">

                    <span style="font-size: 14px">
                        (Delivery Charge Not Applicable)
                    </span>
                </td>
                <td style="border: 1px solid #304051; padding: 8px;">

                </td>
            </tr>
        @endif
        @if($quotation->extra_amount)
            <tr>
                <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">
                    <strong>{{$quotation->extra_charge_name}}</strong>
                </td>
                <td style="border: 1px solid #304051; padding: 8px;">
                    {{$quotation->extra_amount}}
                </td>
            </tr>
        @endif
        @if($quotation->discount_amount)
            <tr>
                <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">
                    <strong>Total Discount</strong>
                </td>
                <td style="border: 1px solid #304051; padding: 8px;">
                    -{{$quotation->discount_amount}}
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="6" style="text-align: right; border: 1px solid #304051; padding: 8px;">
                <strong>Total:</strong>
            </td>
            <td style="border: 1px solid #304051; padding: 8px;">
                <?php
                $deliveryCharge = floatval($quotation->delivery_charge);
                $extraAmount = floatval($quotation->extra_amount);
                $discountAmount = floatval($quotation->discount_amount);

                $totalPrice = $totalPrice + ($deliveryCharge ?? 0) + ($extraAmount ?? 0) ;
                $totalPrice = $totalPrice - ($discountAmount ?? 0);
                echo number_format($totalPrice,2,'.','');
                ?>
            </td>
        </tr>
        </tfoot>
    </table>

    <p>
        <strong>Total Price (In Words):</strong>
        <?php
        $totalPrice = number_format($totalPrice, 2, '.', '');
        $numberFormatter = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $totalPriceInWords = ucwords($numberFormatter->format($totalPrice));
        echo $totalPriceInWords . ' Tk. Only';
        ?>
    </p>


    <div class="quotation-foot">
        <p><strong>Terms & Conditions</strong></p>
        <p>
            <strong>Payment Method:</strong> {{$quotation->payment_type}} , @if($quotation->payment_type == '50% Advance Payment by Bank' )Rest Payment By Cash @endif<br>

            <span>(Conquest Impex, Islami Bank Bangladesh Limited, Moghbazar branch, A/C: 20503320100150001)</span>
        </p>

        @if(!empty($quotation->offer_validity))
            <p>
                <strong>Offer Validity:</strong> {{$quotation->offer_validity}} Days
            </p>
        @endif
        @if($quotation->vat_tax == 7.5)
            <strong>Vat include 7.5%</strong>
        @elseif($quotation->vat_tax == 3)
            <strong>
                Ait Include 3%
            </strong>
        @elseif($quotation->vat_tax == 10.5)
            <strong>Vat & Ait Include</strong>
        @else
            <strong>Vat & Ait Exclude</strong>
        @endif

        <p>
            <strong>Warranty:</strong> {{$quotation->warranty}}
        </p>

        <p>
            <strong>Delivery Term:</strong> {{$quotation->delivery_term}}
        </p>


        <p>
            <strong>Delivery Time:</strong>Within {{$quotation->delivery_date }} working day after work order
        </p>


        @if(!empty($quotation->other_condition))
            <p>
                <strong>Other Condition:</strong> {{$quotation->other_condition}}
            </p>
        @endif
        <div style="line-height: 8px;">

            <img src="<?php echo public_path('images/pdf/' . $pdfSetup['seal']); ?>" style="width: 90px">

            <p>Best Regards</p>
            <p>{{$quotation->users['name']}}</p>
            <p>{{$pdfSetup['designation']}}</p>

        </div>
        <div style="line-height: 8px">
            @if($quotation->logo == 'Esmart')
                <img src="<?php echo public_path('images/pdf/' . $pdfSetup['logo']); ?>" style="width: 180px">
                <p>eSmart Bangladesh</p>
                <p style="line-height: 18px">{!! $pdfSetup['address'] !!}</p>
            @else
                <img src="<?php echo public_path('images/pdf/' . $pdfSetup['logo']); ?>" style="width: 180px">

                <p>Conquest Impex Bangladesh</p>
                <p style="line-height: 18px">{!! $pdfSetup['address'] !!}</p>
            @endif

        </div>

        <div>


        </div>
</body>
</html>
