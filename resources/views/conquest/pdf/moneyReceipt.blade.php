<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Money Receipt</title>
    </head>

    <body>
        <div style="border: 1px solid #cccccc; padding: 10px">
            <div style="text-align: center">
                <img src="{{$logo}}" style=" padding: 12px">
                <p>
                    108, Kazi Nazrul Islam Avenue
                    Banglamotor, Dhaka
                </p>
                <p>
                    <strong>Hotline:</strong> +8801910900986
                </p>
                <p>
                    <strong>Email:</strong> conquestimpex@gmail.com
                </p>
            </div>

            <p style="text-align: right">
                <strong>
                    {{date('d M Y', strtotime($invoice['date']))}}
                </strong>
            </p>

            <table style="width: 100%">
                <tbody >
                    <tr>
                        <td style="text-align: left">
                           <p>
                              <strong>
                                  Received with Thanks
                                  from:
                              </strong>
                           </p>
                        </td>
                        <td  style="text-align: right">
                            <p style="text-align: right">
                                <strong>
                                    {{$invoice->customers['name']}}
                                </strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <strong>
                                    Amount in BDT
                                </strong>
                            </p>
                        </td>
                        <td  style="text-align: right">
                            <p>
                                <strong>
                                    <?php
                                    $numberFormatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                    $totalPriceInWords = ucwords($numberFormatter->format($invoice['pay_amount']));
                                    echo $totalPriceInWords.' Tk. Only';
                                    ?>
                                </strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>
                                <strong>
                                    Pay With:
                                </strong>
                            </p>
                        </td>
                        <td  style="text-align: right">
                            <p>
                                <strong>
                                    {{$invoice['pay_type']}}
                                </strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <strong>
                                    BDT:
                                </strong>
                            </p>
                        </td>
                        <td  style="text-align: right">
                            <p>
                                <strong>
                                    {{$invoice['pay_amount']}} /-
                                </strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <strong>
                                    Payment Date:
                                </strong>
                            </p>
                        </td>
                        <td  style="text-align: right">
                            <p>
                                <strong>
                                    {{$invoice['date']}} /-
                                </strong>
                            </p>
                        </td>
                    </tr>


                </tbody>
            </table>

            <table style="width: 100%; margin-top: 100px">
                <tr>
                    <td style="text-align: center">

                        Authorised Signature
                    </td>
                    <td style="text-align: center;vertical-align: bottom">
                        Received By
                    </td>
                </tr>
            </table>

        </div>
    </body>

</html>
