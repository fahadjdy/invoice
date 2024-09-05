<?php 
// echo "<pre>";
//     print_r($orders);
    // print_r($headers);
//   print_r($transactions);
    // print_r($profile);
    $deafaultColSpan = 6;
    $colSpan = 0;
    $is_default    =  !empty($headers['deafault']) ? true : 'false';
    $is_location    =  !empty($headers['location']) ?true :  'false';
    $is_image       =  !empty($headers['image']) ? true : 'false';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .invoice-details table {
            margin: 0% !important;
            padding: 0% !important;
        }

        .invoice-details table tr th {
            font-weight: normal !important;
        }

        .invoice-details table tr td {
            padding: 4px 10px !important;
            margin: 0%;
            font-size: 10px !important;
            font-weight: 550;
            border-right: 1px solid gray;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif !important;
        }

        .invoice-details table tbody tr:nth-child(9) td {
            border-bottom: unset !important;
            padding-bottom: 10px;
        }

        .invoice-details table tbody tr:nth-child(1) td {
            padding-top: 10px;
        }

        .invoice-details table tr td.inv-dtl-th {
            text-align: left;
            /* font-weight: bold; */
            border: unset !important;
            width: 17%;
            letter-spacing: .1px;
        }

        .invoice-details table tr td.colon-td {
            text-align: center;
            width: 3%;
            border: unset !important;
        }

        table.data-table thead tr th {
            font-size: 10px !important;
            letter-spacing: .5px;
            font-weight: bold !important;
            padding: 5px;
            border: 1px solid gray;
        }

        table.data-table tbody tr td {
            font-size: 10px !important;
            padding: 3px 4px !important;
            /* border:1px solid gray !important; */
            border-right: 1px solid gray !important;
        }

        table.data-table thead tr th:nth-child(1) {
            border-left: unset !important;
        }

        table.data-table thead tr th:nth-child(9) {
            border-right: unset !important;
        }

        table.data-table tbody tr td:nth-child(1),
        table.data-table tbody tr td:nth-child(3),
        table.data-table tbody tr td:nth-child(5) {
            text-align: center !important;
        }

        table.data-table tbody tr td:nth-child(2) {
            text-align: left !important;
        }

        table.data-table tbody tr td:nth-child(4),
        table.data-table tbody tr td:nth-child(6),
        table.data-table tbody tr td:nth-child(7),
        table.data-table tbody tr td:nth-child(8),
        table.data-table tbody tr td:nth-child(9) {
            text-align: right !important;
        }

        table.data-table tbody tr td:nth-child(9) {
            border-right: unset !important;
        }

        table.page-footer {
            min-height: 200px !important;
        }

        table.page-footer tr td {
            padding: 5px 7px !important;
            border: 1px solid gray;
            height: 59px;

        }

        table.page-footer tr td:nth-child(1) {
            /* padding:10px !important; */
            border: 1px solid gray;
        }

        table.hsn-table thead tr th,
        table.hsn-table tfoot tr th {
            padding: 5px;
            font-size: 10px !important;
            font-weight: bold;
            /* border:1px solid gray !important; */
            /* border-bottom: 1px solid gray; */
            border-right: unset !important;
            /* border-top: unset !important; */
            border-left: unset !important;
        }

        table.hsn-table thead tr th:nth-child(1),
        table.hsn-table tfoot tr th:nth-child(1) {
            border-left: unset !important;
            border-right: unset !important;
        }

        table.hsn-table thead tr th:nth-child(5),
        table.hsn-table tfoot tr th:nth-child(5) {
            border-right: unset !important;
        }

        table.hsn-table tbody tr td {
            border-right: unset !important;
        }

        table.hsn-table tbody tr td:nth-child(1) {
            border-left: unset !important;
        }

        table.hsn-table tbody tr td:nth-child(5) {
            border-right: unset !important;
        }

        table.hsn-table tfoot tr th {
            border-bottom: 1px solid gray !important;
            border-top: 1px solid gray !important;
        }

        div.invoice-content {
            border-left: 1px solid gray !important;
            border-right: 1px solid gray !important;
        }
    </style>
</head>

<body onload="window.print()">

    <div style="font-weight: bold;height: 150px !important;border:1px solid gray;border-bottom: unset !important;">
        <p
            style="color: gray;font-style: italic;text-align: right;font-weight: normal !important;margin: 5px 5px 0px 0px !important;font-size: 13px;">
            Original Copy</p>
        <div
            style="width:70%;float:left;margin-top: 0px; text-align:center;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
            <p align="center" style="margin-top: 5px;margin-bottom:0%;font-size:13px"><u>INVOICE</u></p>
            <h2 style="margin-bottom:3px;margin-left: 10px;font-size: 25px;margin-top:10px;"> <?=$profile['name']?>
            </h2>
            <p style="margin-bottom:0%;font-size:10px;margin:3px;letter-spacing:.1px;margin-left: 10px;text-transform:uppercase;font-weight: normal !important;"
                align="center"><?=$profile['address']?></p>
            <p
                style="margin-bottom:0%;font-size:10px;margin:3px;letter-spacing:.1px;margin-left: 10px;font-weight: normal !important;">
                <span>Mo. : <?=$profile['contact']??null?></span> , <span>Email : <?=$profile['email']??'-'?></span></p>
           
        </div>
        <div style="width:30%;float:right;padding: 0%;text-align: center;height: 170px;">
            <img src="<?=base_url('assets/images/profile/'.$profile['logo'])?>" alt="<?=$profile['name']?>"
                style="height: 120px;transform: scale(.9);margin-top: 40px;">
        </div>
    </div>
    <div class="invoice-details" style="width: 100%;">
        <table class="table m-0 p-0 invoice-to"
            style="width: 100%;border-collapse: collapse;border: 1px solid gray;border-bottom: unset !important;">
            <tbody>
                <tr>
                    <td colspan="3" width="50%" style="font-style:italic;font-weight: bold;">Party Details </td>
                    <td class="inv-dtl-th">Invoice No.</td>
                    <td class="colon-td"> : </td>
                    <td>INV0013</td>
                </tr>
                <tr>
                    <td style="width:50%;text-transform: uppercase;vertical-align: top !important;" rowspan="1"
                        colspan="3">Fahad Iliyas Jadiya</td>
                    <td class="inv-dtl-th">Date</td>
                    <td class="colon-td"> : </td>
                    <td>28-12-2022</td>
                </tr>
                <tr>
                    <td class="inv-dtl-th">Address</td>
                    <td class="colon-td"> : </td>
                    <td>M/S DARVANI ABIDBHAI HASANBHAI, VERAVAL, GUJRAT</td>
                </tr>
                <tr>
                    <td class="inv-dtl-th">Contact</td>
                    <td class="colon-td"> : </td>
                    <td>7203070468</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="invoice-content">
        <table class="table data-table" style="width: 100%;border-collapse: collapse">
            <thead>
                <tr>
                    <th width="7%">S.N.</th>
                    <?php if($is_image === true){ ?> <th style="text-align: center;" width="11%">Image</th> <?php $colSpan++; } ?>
                    <?php if($is_location === true){ ?> <th style="text-align: center;" width="11%">Location</th> <?php $colSpan++; } ?>
                    <th>Product Description</th>
                    <th style="text-align: right;" width="7%">Qty.</th>
                    <th class="text-center" width="6%">Size(sqft.)</th>
                    <th style="text-align: right;" width="10%">Sqft.</th>
                    <th style="text-align: right;" width="8%">Price</th>
                    <th style="text-align: right;" width="11%">Amount</th>
                </tr>
            </thead>

            <tbody>

                <?php 
                        $grandTotal = 0; 
                        foreach($transactions as $key => $val){ 
                        $price = $val['price'] * $val['qty']
                    ?>
                <tr>
                    <td class="text-center" style=""><?=$key+1?></td>
                    <?php if($is_image === true){ ?> <td style="text-align: center;display: flex;justify-content: center;"><img src="<?=base_url('assets/images/FrameImage/'.$val['frame_image_url'])?>" alt="demo-image" width="100px" height="100px"></td> <?php } ?>
                        <?php if($is_location === true){ ?>  <td><?=$val['location_name']?></td> <?php } ?>
                    <td style="text-transform:uppercase"><?=$val['product_names']?>  </td>
                    <td style="padding-left:0% !important"><?=$val['qty']?></td>
                    <td style="text-transform:uppercase"><?=$val['size1'].'*'.$val['size2']?></td>
                    <td><?=$val['size1']*$val['size2']?></td>
                    <td style="border-right: 1px solid gray !important;"><?=$val['price']?></td>
                    <td><?=$price?></td>
                </tr>
                <?php $grandTotal += $price; } ?>

                <tr>
                    <td colspan="<?=$deafaultColSpan + $colSpan?>" style="border-top: 1px solid gray;text-align: right;font-weight: bold;letter-spacing: 1px;">Grand Total</td>
                    <td style="text-align: right;font-weight: bold;letter-spacing: .2px;border-top:1px solid gray">
                        <?=$grandTotal?></td>

                </tr>
            </tbody>
        </table>
    </div>
    <div class="footer-div">
        <table width="100%" class="page-footer" border="1" style="border-collapse: collapse; border-color: gray;">
            <tr>
                <td width="60%" rowspan="2">
                    <b><u style="font-size: 13px;">Terms & Conditions :</u></b>
                    <br>
                    <i style="font-size: 11px;"><?=$profile['terms_condition']?></i>
                </td>
                <td width="40%"
                    style="vertical-align: top !important;font-weight: bold;font-size: 12px;letter-spacing: .5px;"
                    align="left">
                    Receiver's Signature :
                </td>
            </tr>
            <tr>
                <td align="right" class="sign-td" style="font-weight: bold;font-size: 12px;letter-spacing: .5px;">
                    for  <?=$profile['name']?>
                    <br><br>
                    Authorised Signature
                </td>
            </tr>
        </table>
    </div>
</body>

</html>