<?php
$pageSave = "Invoice/save";
$pageBack = "Invoice";
$operation = "Add";
$val_customerid = "";
$val_invoice_date = "";
$val_invoice_no = "";
$val_cash_debit = "";
$val_tax_invoice = "";
$val_supply_of = "";
$val_dispatch_through = "";
$val_destination = "";
$val_case_bag = 0;
$val_sgst = 0;
$val_sgst_value = 0;
$val_cgst = 0;
$val_cgst_value = 0;
$val_igst = 0;
$val_igst_value = 0;
$val_total_weight = 0;
$val_total_amount = 0;
$val_grand_amount = 0;
$val_original_copy = 1;
$val_duplicate_copy = 1;
$val_extra_copy = 1;

if ($id != "" and is_numeric($id)) {
    $operation = "Edit";
    $val_customerid = StringRepair3($invoice->customerid);
    $val_invoice_date = StringRepair3($invoice->invoice_date);
    $date = new DateTime($val_invoice_date);
    $val_invoice_date = $date->format('d-m-Y');
    $val_invoice_no = StringRepair3($invoice->invoice_no);
    $val_cash_debit = StringRepair3($invoice->cash_debit);
    $val_tax_invoice = StringRepair3($invoice->tax_invoice);
    $val_supply_of = StringRepair3($invoice->supply_of);
    $val_dispatch_through = StringRepair3($invoice->dispatch_through);
    $val_destination = StringRepair3($invoice->destination);
    $val_case_bag = StringRepair3($invoice->case_bag);
    $val_sgst = StringRepair3($invoice->sgst);
    $val_sgst_value = StringRepair3($invoice->sgst_value);
    $val_cgst = StringRepair3($invoice->cgst);
    $val_cgst_value = StringRepair3($invoice->cgst_value);
    $val_igst = StringRepair3($invoice->igst);
    $val_igst_value = StringRepair3($invoice->igst_value);
    $val_total_qty = StringRepair3($invoice->total_qty);
    $val_total_weight = StringRepair3($invoice->total_weight);
    $val_total_amount = StringRepair3($invoice->total_amount);
    $val_grand_amount = StringRepair3($invoice->grand_amount);
    $val_original_copy = StringRepair3($invoice->original_copy);
    $val_duplicate_copy = StringRepair3($invoice->duplicate_copy);
    $val_extra_copy = StringRepair3($invoice->extra_copy);
}

$managePage = $operation . " Invoice";
?>
<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('Includes/head'); ?>
</head>

<body class="dashboard-page sb-l-m sb-r-c">
<!-- Start: Main -->
<div id="main">
    <?php $this->load->view('Includes/header'); ?>
    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

        <!-- Begin: Content -->
        <section id="content" class="animated fadeIn">
            <?php alertbox(); ?>
            <div class="panel panel-default panel-border top">
                <?php echo form_open($pageSave, ['name' => 'frm1', 'onsubmit' => 'return onSubmitBox()', 'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                <input type="hidden" name="id" value="<?= $id; ?>">
                <div class="panel-heading">
                    <span class="panel-title"> <?= $managePage; ?></span>
                </div>
                <div class="panel-body">
                    <?php
                    dropdownbox('4', 'Customer', 'customerid', $customerlist, $val_customerid, 'onChange="javascript:addChalan(this.value);"');
                    datepicker('4', 'Invoice Date', 'invoice_date', 'Enter Invoice Date', $val_invoice_date);
                    editbox('4', 'Invoice No.', 'invoice_no', 'Enter Invoice No.', $val_invoice_no);
                    echo '<div class="clearfix"></div>';
                    $seldata = array('Cash' => 'Cash', 'Debit Memo' => 'Debit Memo');
                    dropdownbox('4', 'Cash / Debit', 'cash_debit', $seldata, $val_cash_debit);

                    $seldata = array('Job Work Invoice' => 'Job Work Invoice', 'Tax Invoice' => 'Tax Invoice', 'Retail Invoice' => 'Retail Invoice');
                    dropdownbox('4', 'Invoice Type', 'tax_invoice', $seldata, $val_tax_invoice);

                    $seldata = array('Supply of Service' => 'Supply of Service', 'Supply of Goods' => 'Supply of Goods');
                    dropdownbox('4', 'Supply of', 'supply_of', $seldata, $val_supply_of);
                    echo '<div class="clearfix"></div>';

                    editbox('4', 'Dispatch Through', 'dispatch_through', 'Enter Dispatch Through', $val_dispatch_through);
                    editbox('4', 'Destination', 'destination', 'Enter Destination', $val_destination);
                    editbox('4', 'No. of Case / Bag', 'case_bag', 'Enter No. of Case / Bag', $val_case_bag);

                    ?>


                    <table id="table" class="table table-bordered tabform panel  panel-default panel-border top">
                        <thead>
                        <tr>
                            <th style="text-align: center; "><div class="th-inner">Challan No.</div></th>
                            <th style="text-align: center; "><div class="th-inner">Challan Date</div></th>
                            <th style="text-align: center; "><div class="th-inner">Item</div></th>
                            <th style="text-align: center; " ><div class="th-inner">Part Type</div></th>
                            <th style="text-align: center; " ><div class="th-inner">Qty</div></th>
                            <th style="text-align: center; "><div class="th-inner">Weight / Pics</div></th>
                            <th style="text-align: center; "><div class="th-inner ">Total Weight</div></th>
                            <th style="text-align: center; width:50px; "><div class="th-inner">Rate</div></th>
                            <th style="text-align: center; "><div class="th-inner">Amount</div></th>
                            <th style="text-align: center; "><div class="th-inner">Delete</div></th>
                            </tr>
                        </thead>
                        <tbody id="addtarget">

                        <?php
                        if (count($orderlist)) :

                            $i = 0;

                        $totalqty = 0;
                        $totalweight = 0;
                        $totalamount = 0;
                        foreach ($orderlist as $post) :
                            $i++;
                        $totweight = $post->jobwork_qty * $post->weight_piece;
                        $totamount = $totweight * $post->contract_rate;
                        $date = new DateTime($post->jobwork_date);
                        $jobwork_date = $date->format('d-m-Y');

                        ?>
                       <tr id="box_<?= $i; ?>">
                            <td style="text-align: center; "><?= $post->jobwork_chalan; ?></td>
                            <td style="text-align: center; "><?= $jobwork_date; ?></td>
                            <td style="text-align: center; "><?= $post->item_no; ?></td>
                            <td style="text-align: center; "><?= $post->part_type; ?></td>
                            <td style="text-align: center; "><?= $post->jobwork_qty; ?></td>
                            <td style="text-align: center; "><?= sprintf("%0.3f", $post->weight_piece); ?></td>
                            <td style="text-align: right; "><?= sprintf("%0.3f", $totweight); ?></td>
                            <td style="text-align: center; "><?= sprintf("%0.2f", $post->contract_rate); ?></td>
                            <td style="text-align: right; "><?= sprintf("%0.2f", $totamount); ?></td>
                            <td  style="text-align: center; vertical-align: middle; ">
                                <button type="button" class="btn btn-danger btn-gradient btn-alt pt5 pb5 mn" onclick="javascript:RemoveData(<?= $i; ?>)" title="Delete Record"><i class="fa fa-close"></i></button>
                            </td>
                            <input type="hidden" name="ord_<?= $i; ?>" id="ord_<?= $i; ?>" value="<?= $post->id; ?>">
                            <input type="hidden" name="qty_<?= $i; ?>" id="qty_<?= $i; ?>" value="<?= $post->jobwork_qty; ?>">
                            <input type="hidden" name="weight_<?= $i; ?>" id="weight_<?= $i; ?>" value="<?= sprintf("%0.3f", $totweight); ?>">
                            <input type="hidden" name="total_<?= $i; ?>" id="total_<?= $i; ?>" value="<?= sprintf("%0.2f", $totamount); ?>">
                        </tr>
                               
                    <?php
                    endforeach;
                    endif;
                    ?>
                    <input type="hidden" name="count" id="count" value="<?= $i; ?>" />
                        </tbody>
                        <tfoot>
                        <tr>
                            <td  style="text-align: right; " colspan="4">Total</td>
                            <td style="text-align: right; "> <input type="number" disabled class="form-control" style="text-align: right; width:100%"  name="dqty" id="dqty" value="<?= $val_total_qty; ?>"></td>
                            <td>&nbsp;</td>
                            <td style="text-align: right; "><input type="text" disabled class="form-control"  name="dtotalweight" id="dtotalweight"  style="text-align: right; width:100%" value="<?= sprintf("%0.3f", $val_total_weight); ?>"></td>
                            <td></td>
                            <td style="text-align: right; "><input type="text" disabled class="form-control"  name="dtotalamount" id="dtotalamount"  style="text-align: right; width:100%" value="<?= sprintf("%0.2f", $val_total_amount); ?>"></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td  style="text-align: right; " colspan="7">SGST</td>
                            <td><input type="text" name="sgst" id="sgst" class="form-control"  onblur="javascript:calculate();" style="text-align: right; width:100%;" value="<?= $val_sgst; ?>"></td>
                            <td><input type="text" name="dsgst_value" disabled class="form-control"  id="dsgst_value"  style="text-align: right; width:100%" value="<?= sprintf("%0.2f", $val_sgst_value); ?>"></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td  style="text-align: right; " colspan="7">CGST</td>
                            <td><input type="text" name="cgst" id="cgst" class="form-control"   onblur="javascript:calculate();"  style="text-align: right; width:100%;" value="<?= $val_cgst; ?>"></td>
                            <td><input type="text" name="dcgst_value" disabled class="form-control"  id="dcgst_value"  style="text-align: right; width:100%" value="<?= sprintf("%0.2f", $val_cgst_value); ?>"></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td  style="text-align: right; " colspan="7">IGST</td>
                            <td><input type="text" name="igst" id="igst" class="form-control"   onblur="javascript:calculate();"  style="text-align: right; width:100%;" value="<?= $val_igst; ?>"></td>
                            <td><input type="text" name="digst_value" disabled class="form-control"  id="digst_value"  style="text-align: right; width:100%" value="<?= sprintf("%0.2f", $val_igst_value); ?>"></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td  style="text-align: right; " colspan="7">Grand Total</td>
                            <td>&nbsp;</td>
                            <td><input type="text" name="dgrand_total" disabled class="form-control"  id="dgrand_total"  style="text-align: right; width:100%" value="<?= sprintf("%0.2f", $val_grand_amount); ?>"></td>
                            <td>&nbsp;</td>
                        </tr>

                        </tfoot>
                    </table>
                    <input type="hidden" name="sgst_value" id="sgst_value"  style="text-align: right; width:100%" value="<?= sprintf("%0.2f", $val_sgst_value); ?>">
                    <input type="hidden" name="cgst_value" id="cgst_value"  style="text-align: right; width:100%" value="<?= sprintf("%0.2f", $val_cgst_value); ?>">
                    <input type="hidden" name="igst_value" id="igst_value"  style="text-align: right; width:100%" value="<?= sprintf("%0.2f", $val_igst_value); ?>">
                   <input type="hidden" name="totalweight" id="totalweight" value="<?= sprintf("%0.3f", $val_total_weight); ?>">
                   <input type="hidden" name="totalqty" id="totalqty" value="<?= $val_total_qty; ?>">
                   <input type="hidden" name="totalamount" id="totalamount" value="<?= sprintf("%0.2f", $val_total_amount); ?>">
                   <input type="hidden" name="grandamount" id="grandamount" value="<?= sprintf("%0.2f", $val_grand_amount); ?>">

                    <?php

                    checkbox($val_original_copy, "Original Copy", 'original_copy');
                    checkbox($val_duplicate_copy, "Duplicate Copy", 'duplicate_copy');
                    checkbox($val_extra_copy, "Extra Copy", 'extra_copy');
                    submitbutton($pageBack);
                    ?>
                </div>
                <?php form_close(); ?>
            </div>

        </section>
        <?php $this->load->view('Includes/footer'); ?>
    </section>
    <!-- End: Content-Wrapper -->
</div>
<!-- End: Main -->
<?php $this->load->view('Includes/footerscript'); ?>
<script>
    $(document).ready(function(){
        $('.datetimepicker').datepicker({ dateFormat: 'dd-mm-yy' });
    });

    function addChalan(sel){
        $("#addtarget").empty();
        $("#dqty").val(0);
        $("#totalqty").val(0);
        $("#dtotalweight").val(0);
        $("#dtotolamount").val(0);
        $("#totalweight").val(0);
        $("#totalamount").val(0);
        $("#grandamount").val(0);
        $("#dgrand_total").val(0);
        $("#cgst_value").val(0);
        $("#dcgst_value").val(0);
        $("#sgst_value").val(0);
        $("#dsgst_value").val(0);
        $("#igst_value").val(0);
        $("#digst_value").val(0);
        
        $.get('<?php echo base_url(); ?>Invoice/addsub/'+sel+'/<?= $id; ?>',null,function(result) {
            $("#addtarget").append(result); // Or whatever you need to insert the result
            calculate();
        },'html');

    };
  
    function RemoveData(colname){
        $("#box_"+colname).remove();
        calculate();
    }

    function calculate(){

        let count = $("#count").val();
        let totalweight = 0;
        let totalamount = 0;
        let totalqty = 0;
        let weight = 0;
        let amount = 0;
        let qty = 0;
        for (var i = 1; i <= count; i++){
            orderid = $("#ord_"+i).val();
            if(typeof orderid === 'undefined'){}else{
            weight = parseDouble($("#weight_"+i).val());
            amount = parseDouble($("#total_"+i).val());
            qty = parseInt($("#qty_"+i).val());
            totalweight = totalweight + weight;
            totalamount = totalamount + amount;
            totalqty = totalqty + qty;
            }
        }

        $("#dtotalweight").val(totalweight);
        $("#dtotalamount").val(totalamount);
        $("#dqty").val(totalqty);
        $("#totalweight").val(totalweight);
        $("#totalamount").val(totalamount);
        $("#totalqty").val(totalqty);
        
        let sgst = $("#sgst").val();
        let cgst = $("#cgst").val();
        let igst = $("#igst").val();

        let sgstper = (sgst * totalamount) / 100;
        let cgstper = (cgst * totalamount) / 100;
        let igstper = (igst * totalamount) / 100;

        $("#dsgst_value").val(sgstper);
        $("#dcgst_value").val(cgstper);
        $("#digst_value").val(igstper);
        $("#sgst_value").val(sgstper);
        $("#cgst_value").val(cgstper);
        $("#igst_value").val(igstper);

        let grandtotal = totalamount + sgstper + cgstper + igstper;
        $("#dgrand_total").val(grandtotal);
        $("#grandamount").val(grandtotal);

    }

    function onSubmitBox(){

        var title="";
        var ttext="";

        var jobwork_date = $("#jobwork_date").val();
        var jobwork_chalan = $("#jobwork_chalan").val();

        if(jobwork_date == ""){
            title = "Jobwork Date";
            ttext = "Please Enter Jobwork Date";
            document.frm1.jobwork_date.focus();
        }else if(jobwork_chalan == ""){
            title = "Chalan No.";
            ttext = "Please Enter Jobwork Chalan No.";
            document.frm1.jobwork_chalan.focus();
        }

        if(title != "" && ttext != "") {
            swal({
                title: title,
                text: ttext,
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Ok"
            });
            return false;
        }else{
            return true;
        }
    }
</script>
</body>
</html>
