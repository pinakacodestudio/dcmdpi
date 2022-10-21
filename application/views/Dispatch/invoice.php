<?php
$currentpage = base_url() . "Dispatch/invoice/" . $id;

$date = new DateTime($dispatch->dispatch_date);
$dispatch_date = $date->format('d-m-Y');
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        table{
            font-size:12px;
            width:100%;
            border:1px solid #000;
        }
		table tr td{
			padding: 3px 8px !important;
		}
        .break { page-break-before: always; }
        
      
    </style>
</head>

<body>

               <?php 
														$i = 0;
														while ($i < 2) {
															$i++;
															if ($i == 1) {
																$org = "Original";
															} else {
																$org = "Duplicate";
															}
															?>

                                    <table>
                                        <tr>
                                            <td style="width:30%";> 
                                           CHALLAN NO : <?= $dispatch->chalan_no; ?><br>
                                            DATE : <?= $dispatch_date; ?>
                                            </td>
                                            <td style="width:40%;"><h3 style="text-align: center;">DELIVERY CHALLAN<br><small><?= $org; ?></small></h3>
											</td>
                                            <td style="width:30%";>
                                            <img src="<?php echo base_url(); ?>assets/img/logodcm.jpeg" alt="DPI Logo" class="printlogo" style="width: 70px; float:right;">
                                            </td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <td style="width:50%";>NAME AND ADDRESS OF PROCESSOR</td>
                                            <td style="width:50%;">NAME AND ADDRESS OF PRINCIPAL SUPPLIER</td>
                                        </tr>
                                    </table>
									<table>
										<tr>
											<td style="width:50%;">
												DCM PRECISION INDUSTRIES<br>
												Survey No. 175, Plot No. 1/2,<br>
												Nr. Marshal Technocast<br>
												S.I.D.C. Road, At. Veraval (Shapar)<br>
												Dist. Rajkot Gujarat India - 360024<br>
											</td>
											<td  style="width:50%; vertical-align:top;" ><?= $dispatch->company_name . "<br>" . $dispatch->customer_address; ?></td>
										</tr>
										<tr>
											<td><b>GST NO. : 24AAJFD8896L1ZN</b></td>
											<td>GST NO. : <?= $dispatch->gstno; ?></td>
										</tr>
										<tr>
											<td>NATURE OF PROCESSING DONE : -</td>
											<td>ANNEALING JOB WORK</td>
										</tr>
										<tr>
											<td>MAIN CHALLAN NO. :- 01</td>
											<td>DATE : <?= $dispatch_date; ?></td>
										</tr>
										<tr>
											<td colspan="2">
												DELIVERY AT : - <?= $dispatch->dispatch_party; ?>
											</td>
										</tr>
									</table>

									<table>
										<tr style="background: #ececec; padding: 5px;text-align: center">
											<td colspan="3"><b>QUANTITY DISPATCHED  ( IN TERMS OF NOS. / WEIGHT ETC. )</b></td>
										</tr>
										<tr>
											<td>ITEM & DESCRIPTION : <?= $dispatch->item_no . " - " . $dispatch->part_type; ?></td>
											<td>QTY. : <?= $dispatch->batch_qty; ?></td>
                                            <td>TOTAL WEIGHT : <?= sprintf("%0.3f", $dispatch->total_weight); ?> KG</td>
										</tr>
										<tr style="background: #ececec; padding: 5px;text-align: center">
											<td colspan="3">QUANTITY LEFT IN BALANCE ( IN TERMS OF NOS./ WEIGHT ETC.)</td>
										</tr>
										<tr>
											<td>OPENING BALANCE : <?= $opening; ?></td>
											<td>USED MATERIAL : <?= $used_material; ?></td>
											<td>CLOSING BALANCE : <?= $closing; ?></td>
										</tr>
									</table>
									<table style="margin-bottom:20px">
										<tr style="border-top:1px solid #dddddd;">
											<td>Vehicle No. : <?= $vehicle; ?><br>Place : Veraval ( Shapar ) <br> Date : <?= $dispatch_date; ?></td>
											<td style="text-align: right">
												For, DCM PRECISION INDUSTRIES <br>
												<br>
												<br>
												<br>
												Authorised Signatory
											</td>
										</tr>

									</table>

                <?php 
														} ?>
</body>
</html>
