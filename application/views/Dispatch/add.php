<?php
$pageSave = "Dispatch/save";
$pageBack = "Dispatch";
$operation = "Add";
$val_dispatch_date = "";
$val_orderid = "";
$val_chalan_no = "";
$val_dispatch_party = "";
$val_rate_qty = 0;
$val_total_amount = 0;
$val_batch_qty = 0;
$val_weight_piece = 0;
$val_total_weight = 0;
$val_avail_qty = 0;
$val_vehicleid = 0;
$disabled = "";
if ($id != "" and is_numeric($id)) {
    $operation = "Edit";
    $val_dispatch_date = StringRepair3($dispatch->dispatch_date);
    $date = new DateTime($val_dispatch_date);
    $val_dispatch_date = $date->format('d-m-Y');
    $val_chalan_no = StringRepair3($dispatch->chalan_no);
    $val_dispatch_party = StringRepair3($dispatch->dispatch_party);
    $val_rate_qty = StringRepair3($dispatch->rate_qty);
    $val_total_amount = StringRepair3($dispatch->total_amount);
    $val_orderid = StringRepair3($dispatch->orderid);
    $val_batch_qty = StringRepair3($dispatch->batch_qty);
    $val_weight_piece = StringRepair3($dispatch->weight_piece);
    $val_total_weight = StringRepair3($dispatch->total_weight);
    $val_avail_qty = StringRepair3($dispatch->batch_qty + $pendingqty);
    $val_vehicleid = StringRepair3($dispatch->vehicleid);
    $disabled = "disabled";
}
if ($dispatch_date = $this->session->flashdata('dispatch_date')) :
    $val_dispatch_date = StringRepair3($dispatch_date);
endif;
if ($chalan_no = $this->session->flashdata('chalan_no')) :
    $val_chalan_no = StringRepair3($chalan_no);
endif;
if ($dispatch_party = $this->session->flashdata('dispatch_party')) :
    $val_dispatch_party = StringRepair3($dispatch_party);
endif;
if ($orderid = $this->session->flashdata('orderid')) :
    $val_orderid = StringRepair3($orderid);
endif;
if ($rate_qty = $this->session->flashdata('rate_qty')) :
    $val_rate_qty = StringRepair3($rate_qty);
endif;
if ($total_amount = $this->session->flashdata('total_amount')) :
    $val_total_amount = StringRepair3($total_amount);
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

$managePage = $operation . " Dispatch";
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
                    print_r($orderlist);
                    datepicker('4', 'Dispatch Date', 'dispatch_date', 'Enter Dispatch Date', $val_dispatch_date);
                    dropdownbox('4', 'Order No.', 'orderid2', $orderlist, $val_orderid,'onChange="javascript:getOrderDetail(this.value)"');
                    editbox('4', 'Dispatch Chalan No.', 'chalan_no', 'Enter Dispatch Chalan No.', $val_chalan_no, 'disabled');
                    echo '<div class="clearfix"></div>';
                    dropdownbox('4', 'Dispatch Party', 'dispatch_party', $customerlist, $val_dispatch_party);
                    editbox('4', 'Batch Qty', 'batch_qty', 'Enter Batch Qty', $val_batch_qty, 'onblur="getQty(this.value)"');
                    editbox('4', 'Weight / Piece', 'weight_piece2', 'Enter Weight / Piece', $val_weight_piece, 'onblur="getQty(this.value)"');
                    echo '<div class="clearfix"></div>';
                    editbox('4', 'Total Weight', 'total_weight2', 'Enter Total Weight', $val_total_weight . " Kg");
                    editbox('4', 'Rate / Qty', 'rate_qty', 'Enter Rate / Qty', $val_rate_qty, 'onblur="getQty(this.value)"');
                    editbox('4', 'Total Amount', 'total_amount2', 'Enter Total Amount', $val_total_amount, 'disabled');
                    dropdownbox('4', 'Vehicle', 'vehicleid', $vehiclelist, $val_vehicleid);
                    submitbutton($pageBack);
                    ?>
                </div>
                <input type="hidden" name="orderid" id="orderid" value="<?= $val_orderid ?>">
                <input type="hidden" name="avail_qty" id="avail_qty" value="<?= $val_avail_qty ?>">
                <input type="hidden" name="weight_piece" id="weight_piece" value="<?= $val_weight_piece ?>">
                <input type="hidden" name="total_weight" id="total_weight" value="<?= $val_total_weight ?>">
                <input type="hidden" name="total_amount" id="total_amount" value="<?= $val_total_weight ?>">
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

    function getOrderDetail(id) {
        $("#orderid").val(id);
        $.get('<?php echo base_url(); ?>Dispatch/getOrderDetail/'+id,null,function(data) {
            $('#batch_qty').val(data.qty); //Set output element html
            $('#avail_qty').val(data.qty); //Set output element html
            $('#rate_qty').val(data.rate); //Set output element html
            $('#weight_piece2').val(data.weight); //Set output element html
            $('#weight_piece').val(data.weight); //Set output element html
            getQty();
        },'json');

    }

    function getQty(){
        var batch = parseFloat($("#batch_qty").val());
        var avail_qty = parseFloat($("#avail_qty").val());
        var weight = parseFloat($("#weight_piece").val());
        var rate = parseFloat($("#rate_qty").val());
        if(batch > avail_qty){
            title = "Dispatch Qty";
            ttext = "The Dispatch Qty is bigger than remaining Qty. Remaining Qty is "+avail_qty;
            $("#batch_qty").val(avail_qty);
            batch = avail_qty;
            alertbox(title,ttext);

        }
        var total = batch*weight;
        var amount = total*rate;
        $("#total_weight2").val(total.toFixed(3)+" Kg");
        $("#total_weight").val(total.toFixed(3));
        $("#total_amount2").val(amount.toFixed(2));
        $("#total_amount").val(amount.toFixed(2));
    }
    function onSubmitBox(){

        var title="";
        var ttext="";

        var dispatch_date = $("#dispatch_date").val();
        var orderid = $("#orderid").val();
        var chalan_no = $("#chalan_no").val();
        var dispatch_party = $("#dispatch_party").val();
        var batch_qty = $("#batch_qty").val();
        var rate_qty = $("#rate_qty").val();

        if(dispatch_date == ""){
            title = "Dispatch Date";
            ttext = "Please Enter Dispatch Date";
            document.frm1.dispatch_date.focus();
        }else if(orderid == "" || orderid == 0){
            title = "Order";
            ttext = "Please Select Order";
            document.frm1.orderid.focus();
        }else if(dispatch_party == "" || dispatch_party == 0){
            title = "Dispatch Party";
            ttext = "Please Select Dispatch Party";
            document.frm1.dispatch_party.focus();
        }else if(batch_qty == "" || batch_qty == 0){
            title = "Batch Qty";
            ttext = "Please Enter Batch Qty";
            document.frm1.batch_qty.focus();
        }else if(isNaN(batch_qty)){
            title = "Batch Qty";
            ttext = "Please Enter Batch Qty in Number Only";
            document.frm1.batch_qty.focus();
        }else if(rate_qty == ""){
            title = "Rate / Qty";
            ttext = "Please Enter Item No.";
            document.frm1.rate_qty.focus();
        }else if(isNaN(rate_qty)){
            title = "Rate Qty";
            ttext = "Please Enter Rate Qty Only Digits";
            document.frm1.rate_qty.focus();
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

    function alertbox(title,ttext) {
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
    function initSelect(){
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    }
</script>
</body>
</html>
