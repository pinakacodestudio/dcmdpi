<?php
$currentpage = base_url() . "Invoice/invoice/" . $id;

$date = new DateTime($invoice->invoice_date);
$invoice_date = $date->format('d-m-Y');
$count = 20;

$printcount = 3;
$org = 0;
$dup = 0;
$ext = 0;

?>



<!DOCTYPE html>
<html>
<head>
    <style>
        table{
            font-size:12px;
            width:100%;
            border:1px solid #000;
			border-collapse:collapse;
        }
		table tr td,table tr th{
			padding: 3px 8px !important;
			border:1px solid #000;
			
		}
        .break { page-break-before: always; }
        
		ul li{ float:left; margin-right:20px;}
      
    </style>
</head>

<body>

               <?php 
														$print = 0;
														while ($print < $printcount) {


															?>

									<?php if ($invoice->original_copy == 1 && $org == 0) {
									$printvar = "ORIGINAL COPY";
									$print++;
									$org = 1;
								} else if ($invoice->duplicate_copy == 1 && $dup == 0) {
									$printvar = "DUPLICATE COPY";
									$print++;
									$dup = 1;
								} else if ($invoice->extra_copy == 1 && $ext == 0) {
									$printvar = "EXTRA COPY";
									$print++;
									$ext = 1;
								} else {
									$print++;
									continue;
								}

								printHeader($userinfo, $invoice, $invoice_date, $customer, $printvar);

								$i = 0;
								for ($i = 0; $i <= $j; $i++) {
									$totweight = $orderlist[$i]->jobwork_qty * $orderlist[$i]->weight_piece;
									$totamount = $totweight * $orderlist[$i]->contract_rate;
									$date = new DateTime($orderlist[$i]->jobwork_date);
									$jobwork_date = $date->format('d-m-Y');
									?>
										<tr>
										<td style="text-align:center;  border-bottom:0px; border-top:0px;"><?= $i + 1; ?></td>
										<td style="text-align:center; border-bottom:0px; border-top:0px;"><?= $orderlist[$i]->jobwork_chalan; ?></td>
										<td style="text-align:center; border-bottom:0px; border-top:0px;"><?= $jobwork_date; ?></td>
										<td style=" border-bottom:0px; border-top:0px;"><?= $orderlist[$i]->item_no; ?></td>
										<td style="text-align:center; border-bottom:0px; border-top:0px;"><?= $orderlist[$i]->part_type; ?></td>
										<td  style="text-align:right; border-bottom:0px; border-top:0px;"><?= $orderlist[$i]->jobwork_qty; ?></td>
										<td  style="text-align:right; border-bottom:0px; border-top:0px;"><?= $orderlist[$i]->weight_piece; ?></td>
										<td  style="text-align:right; border-bottom:0px; border-top:0px;"><?= sprintf("%0.3f", $totweight); ?></td>
										<td  style="text-align:right; border-bottom:0px; border-top:0px;"><?= sprintf("%0.2f", $orderlist[$i]->contract_rate); ?></td>
										<td style="text-align:right; border-bottom:0px; border-top:0px;"><?= sprintf("%0.2f", $totamount); ?></td>
										</tr>
										<?php

								}

								while ($i < $count) {
									$i++;
									?>
										<tr>
										<td style="text-align:center; border-bottom:0px; border-top:0px;">&nbsp;</td>
										<td style="text-align:center; border-bottom:0px; border-top:0px;"></td>
										<td style="text-align:center; border-bottom:0px; border-top:0px;"></td>
										<td style=" border-bottom:0px; border-top:0px;"></td>
										<td style="text-align:center; border-bottom:0px; border-top:0px;"></td>
										<td  style="text-align:right; border-bottom:0px; border-top:0px;"></td>
										<td  style="text-align:right; border-bottom:0px; border-top:0px;"></td>
										<td  style="text-align:right; border-bottom:0px; border-top:0px;"></td>
										<td  style="text-align:right; border-bottom:0px; border-top:0px;"></td>
										<td style="text-align:right; border-bottom:0px; border-top:0px;"></td>
										</tr>
									<?php

							}

							printFooter($invoice);
							?>

								
<div class="break"></div>
                <?php 
														} ?>
</body>
</html>


<?php

function printHeader($userinfo, $invoice, $invoice_date, $customer, $printext)
{ ?>
	<h5 style="text-align:right; margin:5px;"><?= $printvar; ?></h5>
                                    <table>
									<thead>
                                        <tr>
                                            <td style="text-align:center;"  colspan="8"> 
												<h1 style="margin:0px;"><?= $userinfo->company_name; ?></h1>
                                            </td>
											</td>
                                            <td style="" rowspan="3" colspan="2">
                                            <img src="<?php echo base_url($userinfo->company_logo); ?>" alt="DPI Logo" class="printlogo" style="width: 70px; float:right;">
                                            </td>
                                        </tr>
										<tr>
                                            <td style="text-align:center;" colspan="8"> 
											<b><?= $userinfo->company_address; ?></b>							

                                            </td>
                                        </tr>
                                    	<tr>
											<td colspan="5"></td>
											<td colspan="3" style="text-align:center;"><b><?= $invoice->cash_debit; ?></b></td>
										</tr>
                                        <tr>
										<td colspan="5">GSTIN NO. : <?= $userinfo->company_gstno; ?></td>
                                            <td colspan="5" style="text-align:center;"><b><?= strtoupper($invoice->supply_of); ?></b></td>
                                        </tr>
                                  		<tr>
											<td colspan="5" rowspan="4" style="vertical-align:top;">
											Name & Address of Consignee:
											<br>
											<b>M/s. <?= strtoupper($customer->company_name); ?></b><br/>			
											<div style="width:200px;"><?= $customer->customer_address; ?></div>
											</td>
											<td colspan="3" style="text-align:right;"><b>INVOICE NO. : -</b></td>
											<td colspan="2"><b><?= $invoice->invoice_no; ?></b></td>
										</tr>
										<tr>
											<td colspan="3" style="text-align:right;"><b>INVOICE DATE : -</b></td>
											<td colspan="2"><b><?= $invoice_date; ?></b></td>
										</tr>
										<tr>
											<td colspan="3" style="text-align:right;">Dispatch Through : -</td>
											<td colspan="2"><?= $invoice->dispatch_through; ?></td>
										</tr>
										<tr>
											<td colspan="3" style="text-align:right;">Destination : -</td>
											<td colspan="2"><?= $invoice->destination; ?></td>
										</tr>
										<tr>
											<td colspan="5"><b>GST NO. : <?= $customer->gstno; ?></b> </td>
											<td colspan="3" style="text-align:right;">No. of Case / Bag : -</td>
											<td colspan="2"><?= $invoice->case_bag; ?></td>
										</tr>
										<tr>
										<th style="width:5%;">SR.<br>No.</th>
										<th style="width:10%;">CHALLAN<br>NO.</th>
										<th style="width:10%;">CHALLAN<br>DATE</th>
										<th style="width:15%;">ITEM</th>
										<th style="width:10%;">PART<br>TYPE</th>
										<th style="width:10%;">QTY</th>
										<th style="width:10%;">WEIGHT /<br>PCS.</th>
										<th style="width:10%;">TOTAL<br>WEIGHT</th>
										<th style="width:10%;">RATE /<br>KGS.</th>
										<th style="width:10%;">AMOUNT</th>
										</tr>
										<tr><td colspan="10" style="text-align:center;"><b>HSN / SAC NO. : 9989</b></td></tr>


</thead>
<?php

}

function printFooter($invoice)
{ ?>
<tfoot>
									<tr>
										<td colspan="7" style="text-align:right; font-weight:bold">Total of Qty </td>
										<td style="text-align:right;"><b><?= sprintf("%0.2f", $invoice->total_weight); ?></b></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
									<td colspan="6" rowspan="4">
										Bank Detail : DCM PRECISION INDUSTRIES<br>
										Bank of India, Sapar ( Veraval )<br>Rajkot, Gujarat, India<br>Current Account : 312320110001095<br>
										IFSC : BKID0003123
									</td>
										<td colspan="2" style="text-align:right;"><b>Assessable Value</b></td>
										<td>&nbsp;</td>
										<td style="text-align:right;"><b><?= sprintf("%0.2f", $invoice->total_amount); ?></b></td>
									</tr>
									<tr>
											<td colspan="2" style="text-align:right;">SGST</td>
										<td style="text-align:right;"><?= sprintf("%0.2f", $invoice->sgst); ?>%</td>
										<td style="text-align:right;"><?= sprintf("%0.2f", $invoice->sgst_value); ?></td>
									</tr>
									<tr>
											<td colspan="2" style="text-align:right;">CGST</td>
										<td style="text-align:right;"><?= sprintf("%0.2f", $invoice->cgst); ?>%</td>
										<td style="text-align:right;"><?= sprintf("%0.2f", $invoice->cgst_value); ?></td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:right;">IGST</td>
										<td style="text-align:right;"><?= sprintf("%0.2f", $invoice->igst); ?>%</td>
										<td style="text-align:right;"><?= sprintf("%0.2f", $invoice->igst_value); ?></td>
									</tr>
									<tr>
									<td colspan="6"><b>Rupees In Words : - <?php echo convertMoney(sprintf("%0.0f", $invoice->grand_amount)); ?></b></td>
										<td colspan="2" style="text-align:right;"><b>Grand Total</b></td>
										<td>&nbsp;</td>
										<td style="text-align:right;"><b><?= sprintf("%0.2f", $invoice->grand_amount); ?></b></td>
									</tr>
										<tr>
											<td colspan="7">
											- Our responsibility ceases as soon as the goods leave our premises
											- All Transactions sujbect to Local Juridication only. - This this to ceritify that the price declared herein is as per section 4 of the Central Excise Act & that the amount indicated in the document represents the price actually charged by us & that there is no additional consideration either directly or indirectly from the goods that has been declared & if any, differential duty shell be paid, if payable.
											</ul></td>
											<td colspan="3" style="text-align: center">
												<b>For, DCM PRECISION INDUSTRIES </b><br>
												<br>
												<br>
												<br>
												Authorised Signatory
											</td>
										</tr>
										</tfoot>
									</table>
<?php 
}
?>