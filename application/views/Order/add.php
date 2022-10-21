<?php
$pageSave = "Order/save";
$pageBack = "Order";
$operation = "Add";
$val_received_date = date('d-m-Y');
$val_main_chalan_no = "";
$val_chalan_date = "";
$val_chalan_no = "";
$val_from_forgine_party = "";
$val_main_party = "";
$val_item_no = "";
$val_part_type = "";
$val_batch_qty = 0;
$val_weight_piece = 0;
$val_total_weight = 0;
$val_note = "";
if ($id != "" and is_numeric($id)) {
    $operation = "Edit";
    $val_received_date = StringRepair3($order->received_date);
    $date = new DateTime($val_received_date);
    $val_received_date = $date->format('d-m-Y');
    $val_main_chalan_no = StringRepair3($order->main_chalan_no);
    $val_chalan_date = StringRepair3($order->chalan_date);
    $date = new DateTime($val_chalan_date);
    $val_chalan_date = $date->format('d-m-Y');
    $val_chalan_no = StringRepair3($order->chalan_no);
    $val_from_forgine_party = StringRepair3($order->from_forgine_party);
    $val_main_party = StringRepair3($order->main_party);
    $val_item_no = StringRepair3($order->item_no);
    $val_part_type = StringRepair3($order->part_type);
    $val_po_no = StringRepair3($order->po_no);
    $val_batch_qty = StringRepair3($order->batch_qty);
    $val_weight_piece = StringRepair3($order->weight_piece);
    $val_total_weight = StringRepair3($order->total_weight);
    $val_note = StringRepair3($order->note);
}
if ($received_date = $this->session->flashdata('received_date')) :
    $val_received_date = StringRepair3($received_date);
endif;
if ($main_chalan_no = $this->session->flashdata('main_chalan_no')) :
    $val_main_chalan_no = StringRepair3($main_chalan_no);
endif;
if ($chalan_date = $this->session->flashdata('chalan_date')) :
    $val_chalan_date = StringRepair3($chalan_date);
endif;
if ($chalan_no = $this->session->flashdata('chalan_no')) :
    $val_chalan_no = StringRepair3($chalan_no);
endif;
if ($from_forgine_party = $this->session->flashdata('from_forgine_party')) :
    $val_from_forgine_party = StringRepair3($from_forgine_party);
endif;
if ($main_party = $this->session->flashdata('main_party')) :
    $val_main_party = StringRepair3($main_party);
endif;
if ($item_no = $this->session->flashdata('item_no')) :
    $val_item_no = StringRepair3($item_no);
endif;
if ($part_type = $this->session->flashdata('part_type')) :
    $val_part_type = StringRepair3($part_type);
endif;
if ($batch_qty = $this->session->flashdata('batch_qty')) :
    $val_batch_qty = StringRepair3($batch_qty);
endif;
if ($weight_piece = $this->session->flashdata('weight_piece')) :
    $val_weight_piece = StringRepair3($weight_piece);
endif;
if ($total_weight = $this->session->flashdata('total_weight')) :
    $val_total_weight = StringRepair3($total_weight);
endif;

$managePage = $operation . " Order";
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
                    datepicker('4', 'Received Date', 'received_date', 'Enter Received Date', $val_received_date);
                    editbox('4', 'Main Challan No.', 'main_chalan_no', 'Enter Main Challan No.', $val_main_chalan_no);
                    datepicker('4', 'Challan Date', 'chalan_date', 'Enter Challan Date', $val_chalan_date);
                    echo '<div class="clearfix"></div>';
                    editbox('4', 'Challan No.', 'chalan_no', 'Enter Challan No.', $val_chalan_no);
                    dropdownbox('4', 'From Forging Party', 'from_forgine_party', $customerlist, $val_from_forgine_party);
                    dropdownbox('4', 'Main Party', 'main_party', $customerlist, $val_main_party);
                    echo '<div class="clearfix"></div>';
                    editbox('4', 'Item No.', 'item_no', 'Enter Item No.', $val_item_no);
                    //editbox('2', 'Part Type', 'part_type', 'Enter Party Type', $val_part_type);
                    dropdownbox('4', 'Part Type', 'part_type', $part_type_list, $val_part_type);
                    
					?>
                    <!--<div class="col-lg-1">
                        <fieldset class="form-group">
                            <label class="form-label semibold">&nbsp;</label>
                            <button onclick="javascript:setPart('IR');" type="button" style="width: 100%" class="btn btn-primary btn-gradient btn-alt">IR</button>
                        </fieldset>
                    </div>
                    <div class="col-lg-1">
                        <fieldset class="form-group">
                            <label class="form-label semibold">&nbsp;</label>
                            <button onclick="javascript:setPart('OR');" type="button"style="width: 100%" class="btn btn-primary btn-gradient btn-alt">OR</button>
                        </fieldset>
                    </div>  
					-->
                    <?php

                    editbox('4', 'PO No.', 'po_no', 'Enter PO No.', $val_po_no);
                    echo '<div class="clearfix"></div>';
                    editbox('4', 'Batch Qty', 'batch_qty', 'Enter Batch Qty', $val_batch_qty, 'onblur="getQty(this.value)"');
                    editbox('4', 'Weight / Piece', 'weight_piece', 'Enter Weight / Piece', $val_weight_piece, 'onblur="getQty(this.value)"');
                    editbox('4', 'Total Weight', 'total_weight2', 'Enter Total Weight', $val_total_weight . " Kg");
                    editbox('4', 'Note', 'note', 'Enter Order Description', $val_note);
                    submitbutton($pageBack);
                    ?>
                </div>
                <input type="hidden" name="total_weight" id="total_weight" value="<?= $val_total_weight ?>">
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
        /*Disable textarea using id */
        $('#total_weight2').prop("disabled", true);
    });

    function setPart(val){
        $('#part_type').val(val);
    }

    function getQty(){
        var batch = parseFloat($("#batch_qty").val());
        var weight = parseFloat($("#weight_piece").val());
        var total = batch*weight;
        $("#total_weight2").val(total.toFixed(3)+" Kg");
        $("#total_weight").val(total.toFixed(3));
    }
    function onSubmitBox(){

        var title="";
        var ttext="";

        var received_date = $("#received_date").val();
        var main_chalan_no = $("#main_chalan_no").val();
        var main_chalan_date = $("#main_chalan_date").val();
        var from_forgine_party = $("#from_forgine_party").val();
        var main_party = $("#main_party").val();
        var item_no = $("#item_no").val();
        var part_type = $("#part_type").val();
        var chalan_no = $("#chalan_no").val();
        var batch_qty = $("#batch_qty").val();
        var weight_piece = $("#weight_piece").val();

        if(received_date == ""){
            title = "Received Date";
            ttext = "Please Enter Received Date";
            document.frm1.received_date.focus();
        }else if(main_chalan_no == ""){
            title = "Main Chalan No.";
            ttext = "Please Enter Chalan No.";
            document.frm1.main_chalan_no.focus();
        }else if(chalan_date == ""){
            title = "Chalan Date";
            ttext = "Please Enter Chalan Date";
            document.frm1.chalan_date.focus();
        }else if(chalan_no == ""){
            title = "Chalan No.";
            ttext = "Please Enter Chalan No.";
            document.frm1.chalan_no.focus();
        }else if(from_forgine_party == "" || from_forgine_party == 0){
            title = "From Forgine Party";
            ttext = "Please Select From Forgine Party";
            document.frm1.from_forgine_party.focus();
        }else if(main_party == "" || main_party == 0){
            title = "Main Party";
            ttext = "Please Select Main Party";
            document.frm1.chalan_no.focus();
        }else if(item_no == ""){
            title = "Item No.";
            ttext = "Please Enter Item No.";
            document.frm1.item_no.focus();
        }else if(part_type == ""){
            title = "Part Type";
            ttext = "Please Enter Part Type";
            document.frm1.part_type.focus();
        }else if(batch_qty == ""){
            title = "Batch Qty";
            ttext = "Please Enter Batch Qty.";
            document.frm1.batch_qty.focus();
        }else if(isNaN(batch_qty)){
            title = "Batch Qty";
            ttext = "Please Enter Batch Qty Only Digits";
            document.frm1.batch_qty.focus();
        }else if(weight_piece == ""){
            title = "Weight / Peice";
            ttext = "Please Enter Weight / Piece.";
            document.frm1.batch_qty.focus();
        }else if(isNaN(weight_piece)){
            title = "Weight / Peice";
            ttext = "Please Enter Weight / Piece Only Digits";
            document.frm1.weight_piece.focus();
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
