<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo public_path('Asset/css/pdfStyle.css'); ?>">
    <title>Quotation Mail</title>
</head>
<body>

        <div class="container">
            <p>Dear,{{$quotation->customers['name']}}</p>
            <p>Please check attachment.</p>
            <img src="https://crm.esmart.com.bd/images/12356.png" class="img-fluid" style="width: 150px"><br>
            <a href="https://esmart.com.bd/">eSmart.com.bd</a>
            <p>09617778877,01316448804</p>
            <p>House no 1/A, Flat B2</p>
        </div>

</body>
</html>
