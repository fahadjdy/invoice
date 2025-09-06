<?php 
// Function to calculate square footage (in square feet)
function calculateSquareFootage($lengthInInches, $widthInInches) {
    
    $lengthInInches = (double)$lengthInInches;
    $widthInInches = (double)$widthInInches;
    $sqft = ($lengthInInches * $widthInInches) / 144;
    return $sqft;
}

$deafaultColSpan = 6;
$colSpan = 0;
$is_default = !empty($headers['deafault']);
$is_location = !empty($headers['location']);
$is_image = !empty($headers['image']);

$datetime = $orders['created_at'] ?? time();
$date = date('d-m-Y', strtotime($datetime));

$gst_type = $orders['gst_type'] ?? 'Without GST';
$discount = $orders['discount'] ?? 0;
$skip = 3;
if($orders['invoice_id'] == 2 || $orders['invoice_id'] == 4){
    $skip = 4;
}else if($orders['invoice_id'] == 3){
    $skip = 5;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        .invoice-details table,
        .invoice-content table,
        .page-footer {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details table td,
        .invoice-details table th {
            font-size: 10px;
            padding: 4px 10px;
            font-weight: 550;
            border-right: 1px solid gray;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .invoice-details table tbody tr:nth-child(9) td {
            border-bottom: unset !important;
        }

        .invoice-details table tr td.inv-dtl-th {
            text-align: left;
            border: unset !important;
            width: 17%;
        }

        .invoice-details table tr td.colon-td {
            text-align: center;
            width: 3%;
            border: unset !important;
        }
      
        table.data-table thead tr th {
            font-size: 10px;
            font-weight: bold;
            padding: 5px;
            border-bottom: 1px solid gray;
        }

        table.data-table tbody tr td {
            padding: 10px !important;
            font-size: 10px;
            padding: 3px 4px;
            border-right: 1px solid gray;
        }

        table.page-footer td {
            padding: 5px 7px;
            border: 1px solid gray;
            height: 59px;
        }

        table.hsn-table thead tr th,
        table.hsn-table tfoot tr th {
            padding: 5px;
            font-size: 10px;
            font-weight: bold;
            border-right: unset !important;
            border-left: unset !important;
        }

        table.hsn-table tbody tr td {
            border-right: unset !important;
        }

        table.hsn-table tbody tr td:nth-child(1) {
            border-left: unset !important;
        }

        div.invoice-content {
            border-left: 1px solid gray !important;
            border-right: 1px solid gray !important;
        }

        .footer-div {
            margin-top: 30px;
        }
    </style>
</head>

<!-- <body> -->
<body onload="window.print()">
    <div style="font-weight: bold; height: 150px; border: 1px solid gray; border-bottom: unset;">
        <p style="color: gray; font-style: italic; text-align: right; font-weight: normal; font-size: 13px; margin: 5px 5px 0px 0px;">Original Copy</p>
        <div style="width:70%; float:left; text-align:center;">
            <p align="center" style="margin-top: 5px; margin-bottom:0%; font-size:13px;"><u>INVOICE</u></p>
            <h2 style="font-size: 25px; margin-top:10px;"><?=$profile['name']?></h2>
            <p style="font-size:10px; text-transform:uppercase; font-weight: normal;" align="center"><?=$profile['address']?></p>
            <p style="font-size:10px; font-weight: normal;"><span>Mo. : <?=$profile['contact']??null?></span>
                <?php if(!empty($profile['email'])) { ?>, <span>Email : <?=$profile['email']??'-'?></span> <?php } ?>
            </p>
        </div>
        <div style="width:30%; float:right; text-align: center;">
            <img src="<?=base_url('assets/images/profile/'.$profile['logo'])?>" alt="<?=$profile['name']?>" style="height: 120px;">
        </div>
    </div>

    <div class="invoice-details" style="border-left:1px solid gray !important;border-right:1px solid gray !important;border-top:1px solid gray !important;">
        <table>
            <tbody>
                <tr>
                    <td colspan="3" style="font-style:italic;font-weight: bold;">Party Details</td>
                    <td class="inv-dtl-th">Invoice No.</td>
                    <td class="colon-td">:</td>
                    <td><?=$orders['orders_id']?></td>
                </tr>
                <tr>
                    <td rowspan="1" colspan="3" style="text-transform: uppercase;"><?=$orders['paty_name']?></td>
                    <td class="inv-dtl-th">Date</td>
                    <td class="colon-td">:</td>
                    <td><?=date('y/m/d',strtotime($datetime))?></td>
                </tr>
                <tr>
                    <td class="inv-dtl-th">Address</td>
                    <td class="colon-td">:</td>
                    <td><?=$orders['paty_address']?></td>
                </tr>
                <tr>
                    <td class="inv-dtl-th">Contact</td>
                    <td class="colon-td">:</td>
                    <td><?=$orders['party_contact']?></td>
                </tr>
            </tbody>
        </table>


    <div class="invoice-content" style="border:1px solid gray !important;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <?php if ($is_image) { ?> <th>Image</th> <?php $colSpan++; } ?>
                    <?php if ($is_location) { ?> <th>Location</th> <?php $colSpan++; } ?>
                    <th>Product Description</th>
                    <th class="text-center">Size (inch.)</th>
                    <th class="text-right">Sqft.</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Qty.</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totalSum = 0;
                    $totalQty = 0;
                    $totalSqft = 0;
                    foreach($transactions as $key => $transaction) {
                        $locations = explode(',', $transaction['location_names']);
                        $sizes1 = explode(',', $transaction['sizes1']);
                        $sizes2 = explode(',', $transaction['sizes2']);
                        $prices = explode(',', $transaction['prices']);
                        $quantities = explode(',', $transaction['quantities']);

                        $locationString = implode(',<br>', $locations);
                        $totalSum += $transaction['total_price'];
                        $totalQty += array_sum($quantities);

                        $imagURL = "";
                        $path   = FCPATH . 'assets/images/FrameImage/' . $transaction['frame_image_url'];
                        if (!empty($transaction['frame_image_url']) && file_exists($path)) {
                            $imagURL = base_url('assets/images/FrameImage/' . $transaction['frame_image_url']);
                        }

                ?>
                <tr style="border-bottom:1px solid gray !important;">
                    <td class="text-center"><?=$key + 1?></td>
                    <?php if ($is_image) { ?>
                        <td class="text-center">
                             <?php if($imagURL): ?>
                                <img src="<?=$imagURL?>" width="100px" height="100px">
                            <?php endif; ?>
                        </td>
                    <?php } ?>
                    <?php if ($is_location) { ?> <td><?=$locationString?></td> <?php } ?>
                    <td><?=strtoupper($transaction['product_names'])?></td>
                    <td><?=implode('<br>', array_map(fn($s1, $s2) => ($s1 && $s2) ? $s1 . 'x' . $s2 : '', $sizes1, $sizes2))?></td>
                    <?php
                        if($sizes1 != null && $sizes2 != null){     
                            $data = array_map(fn($s1, $s2) => ($s1 && $s2) ? round(calculateSquareFootage($s1, $s2), 2) : '', $sizes1, $sizes2);
                            $totalSqft += array_sum($data);                        
                        }
                    ?>
                    <td><?=implode('<br>', $data)?></td>
                    <td><?=implode('<br>', $prices)?></td>
                    <td><?=implode('<br>', $quantities)?></td>
                    <td><?=$transaction['total_price']?></td>
                </tr>
                <?php } ?>

                <tr>
                    <td colspan = "<?=$skip?>" ></td>
                    <td class="text-right" style="font-weight: bold;"><?=$totalSqft?></td>
                    <td colspan = "0" ></td>
                    <td class="text-right" style="font-weight: bold;"><?=$totalQty?></td>
                    <td class="text-right" style="font-weight: bold;"><?=number_format($totalSum, 2)?></td>
                </tr>
                
                <?php if($discount > 0) : ?>
                    <tr style="border-top:1px solid gray !important;">
                        <td colspan = "<?=$skip?>" ></td>
                        <td class="text-right" ></td>
                        <td colspan = "0" ></td>
                        <td class="text-right" style="font-weight: bold;">Discount</td>
                        <td class="text-right" style="font-weight: bold;"> - <?=number_format($discount,2)?></td>
                    </tr>
                <?php endif; ?>

                <!-- if with gst  -->
                 <?php if($gst_type == "With GST") : ?>
                    <tr style="border-top:1px solid gray !important;">
                        <td colspan = "<?=$skip?>" ></td>
                        <td class="text-right" ></td>
                        <td colspan = "0" ></td>
                        <td class="text-right" style="font-weight: bold;">CGST (9%)</td>
                        <td class="text-right" style="font-weight: bold;"> + <?=number_format($totalSum*9/100,2)?></td>
                    </tr>
                    <tr style="border-top:1px solid gray !important;">
                        <td colspan = "<?=$skip?>" ></td>
                        <td class="text-right" ></td>
                        <!--<td colspan="<?=$deafaultColSpan + $colSpan?>" style="text-align: right; font-weight: bold; border-top: 1px solid gray;">Grand Total</td>-->
                        <td colspan = "0" ></td>
                        <td class="text-right" style="font-weight: bold;">SGST (9%)</td>
                        <td class="text-right" style="font-weight: bold;"> + <?=number_format($totalSum*9/100,2)?></td>
                    </tr>
                <?php endif; ?>
                
                <?php 
                $final_count = ($gst_type == "With GST") ?  number_format((($totalSum*18/100)+$totalSum) - $discount,2) :  number_format($totalSum - $discount,2) ;

                if($gst_type == "With GST" || $discount > 0){
                 
                ?>
                <tr style="border-top:1px solid gray !important;">
                    <td colspan = "<?=$skip?>" ></td>
                    <td class="text-right" ></td>
                    <td colspan = "0" ></td>
                    <td class="text-right" style="font-weight: bold;">Total</td>
                    <td class="text-right" style="font-weight: bold;"><?=$final_count?></td>
                </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

    <div class="footer-div">
        <table class="page-footer">
            <tr>
                <td rowspan="2">
                    <b><u>Terms & Conditions:</u></b><br>
                    <i><?=$profile['terms_condition']?></i>
                </td>
                <td style="font-weight: bold; font-size: 12px;">Receiver's Signature:</td>
            </tr>
            <tr>
                <td class="sign-td" style="font-size: 10px; font-weight: normal;">Authorised Signatory</td>
            </tr>
        </table>
    </div>

    </div>
</body>

</html>
