<?php
$pageSave = "Process/save";
$pageBack = "Process";
$operation = "Add";
$val_platformid = $cid;
$val_start_preparing = "";
$val_end_removing = "";
$val_furnaceid = 0;
$val_attach_furnace = "";
$val_dettach_furnace = "";
$val_panelid = 0;
$val_attach_panel = "";
$val_dettach_panel = "";
$val_platform_capacity = $capacity;
$val_remaining_capacity = $capacity;
$val_status = 0;
$val_total_weight = 0;

$dis_process_end = "disabled";
$dis_furnaceid = "disabled";
$dis_fur_attach = "disabled";
$dis_fur_dettach = "disabled";
$dis_panelid = "disabled";
$dis_pan_attach = "disabled";
$dis_pan_dettach = "disabled";


if ($id != "" and $id != 0 and is_numeric($id)) {
    $operation = "Edit";
    $val_platformid = StringRepair3($process->platformid);
    $val_start_preparing = StringRepair3($process->start_preparing);
    $val_end_removing = StringRepair3($process->end_removing);
    $val_furnaceid = StringRepair3($process->furnaceid);
    $val_attach_furnace = StringRepair3($process->attach_furnace);
    $val_dettach_furnace = StringRepair3($process->dettach_furnace);
    $val_panelid = StringRepair3($process->panelid);
    $val_attach_panel = StringRepair3($process->attach_panel);
    $val_dettach_panel = StringRepair3($process->dettach_panel);
    $val_platform_capacity = StringRepair3($process->platform_capacity);
    $val_remaining_capacity = StringRepair3($process->remaining_capacity);
    $val_status = StringRepair3($process->status);
}

if ($val_status == 0) {
    $seldata = array('1' => 'Waiting For Furnace');
} else if ($val_status == 1) {
    $dis_furnaceid = "required";
    $dis_fur_attach = "required";
    $seldata = array('2' => 'Waiting For PowerPanel');
} else if ($val_status == 2) {
    $dis_furnaceid = "required";
    $dis_fur_attach = "required";
    $dis_panelid = "required";
    $dis_pan_attach = "required";
    $dis_pan_dettach = "required";
    $seldata = array('3' => 'Processing');
} else if ($val_status == 3) {
    $dis_furnaceid = "required";
    $dis_fur_attach = "required";
    $dis_fur_dettach = "required";
    $dis_panelid = "required";
    $dis_pan_attach = "required";
    $dis_pan_dettach = "required";
    $seldata = array('3' => 'Processing', '4' => 'Cooling');
} else if ($val_status == 4) {
    $dis_process_end = "required";
    $dis_furnaceid = "required";
    $dis_fur_attach = "required";
    $dis_fur_dettach = "required";
    $dis_panelid = "required";
    $dis_pan_attach = "required";
    $dis_pan_dettach = "required";
    $seldata = array('4' => 'Cooling', '5' => 'Closed');
} else if ($val_status == 5) {
    $dis_process_end = "required";
    $dis_furnaceid = "required";
    $dis_fur_attach = "required";
    $dis_fur_dettach = "required";
    $dis_panelid = "required";
    $dis_pan_attach = "required";
    $dis_pan_dettach = "required";
    $seldata = array('5' => 'Closed');
}

$dis_pan_attach = $dis_pan_attach . ' onBlur="javascript:getDate(this.value)"';
$managePage = $operation . " Process";
?>
<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('Includes/head'); ?>
    <style>
        th,td{
            text-align: center;
            vertical-align: middle;
        }
    </style>
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
                    dropdownbox('4', 'Platform Id', 'platformid', $platformlist, $val_platformid, 'onchange="javascript:getPlatformCapacity(this.value)"');
                    datepicker('4', 'Process Start Date', 'start_preparing', 'Enter Process Start Date', $val_start_preparing, 'required onkeypress="return false;"');
                    datepicker('4', 'Process End Date', 'end_removing', 'Enter Process End Date', $val_end_removing, $dis_process_end . ' onkeypress="return false;"');
                    echo '<div class="clearfix"></div>';
                    dropdownbox('4', 'Furnace Id', 'furnaceid', $furnacelist, $val_furnaceid, $dis_furnaceid);
                    datepicker('4', 'Furnace Attach Date', 'attach_furnace', 'Enter Furnace Attach Date', $val_attach_furnace, $dis_fur_attach . ' onkeypress="return false;"');
                    datepicker('4', 'Furnace Dettach Date', 'dettach_furnace', 'Enter Furnace Dettach Date', $val_dettach_furnace, $dis_fur_dettach . ' onkeypress="return false;"');
                    echo '<div class="clearfix"></div>';
                    dropdownbox('4', 'Panel Id', 'panelid', $panellist, $val_panelid, $dis_panelid);
                    datepicker('4', 'Panel Start Date Time', 'attach_panel', 'Enter Panel Start Date', $val_attach_panel, $dis_pan_attach . ' onkeypress="return false;"');
                    datepicker('4', 'Panel Stop Date Time', 'dettach_panel', 'Enter Panel End Date', $val_dettach_panel, $dis_pan_dettach . ' onkeypress="return false;"');
                    echo '<div class="clearfix"></div>';
                    dropdownbox('4', 'Status', 'status', $seldata, $val_status);
                    editbox('4', 'Platform Capacity', 'platform_capacity2', 'Enter Platform Capacity', $val_platform_capacity, 'disabled');
                    editbox('4', 'Remaining Capacity', 'remaining_capacity2', 'Enter Remaining Capacity', $val_remaining_capacity, 'disabled');
                    ?>
                </div>
                <div class="panel-heading">
                    <span class="panel-title"> Add Material</span>
                </div>
                <div class="panel-body">
                    <table id="table" class="table table-bordered tabform panel  panel-default panel-border top">
                        <thead>
                        <tr>
                            <th style="text-align: center; "><div class="th-inner">Order Id</div></th>
                            <th style="text-align: center; " ><div class="th-inner">Quantity</div></th>
                            <th style="text-align: center; "><div class="th-inner">Weight / Pic</div></th>
                            <th style="text-align: center; "><div class="th-inner ">Total Weight</div></th>
                           <?php if ($val_status == 0) { ?>
                            <th style="text-align: center; "><div class="th-inner ">Delete</div></th>
                            <?php 
                        } ?>
                            </tr>
                        </thead>
                        <tbody id="addtarget">
                        <?php
                        $i = 0;

                        if (count($materialslist)) :
                            foreach ($materialslist as $post) :
                            $i++;
                        $val_total_weight = $val_total_weight + $post->total_weight;
                        ?>
                                <input type="hidden" name="subid_<?= $i; ?>" id="subid_<?= $i; ?>" value="<?= $post->id; ?>">
                                <tr id="box_<?= $i; ?>">
                                    <td style="text-align: center; vertical-align: middle;">
                                        <input type="text" class="form-control" id="orderid2_<?= $i; ?>" disabled name="orderid2_<?= $i; ?>" value="<?= $post->company_name . " - " . $post->item_no . " - " . $post->part_type; ?>">
                                    </td>
                                    <td style="text-align: center; vertical-align: middle; ">
                                        <input type="number" class="form-control" id="qty_<?= $i; ?>"  name="qty_<?= $i; ?>" value="<?= $post->qty; ?>" required onblur="getAmount(<?= $i; ?>)">
                                    </td>
                                    <td style="text-align: center; vertical-align: middle; ">
                                        <input type="text" disabled class="form-control" id="weight2_<?= $i; ?>" name="weight2_<?= $i; ?>" value="<?= $post->weight_piece; ?>" required>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle; ">
                                        <input type="text" disabled class="form-control" id="total2_<?= $i; ?>" name="total2_<?= $i; ?>" value="<?= $post->total_weight; ?>" required>
                                    </td>
                                <?php if ($val_status == 0) { ?>
                                <td  style="text-align: center; vertical-align: middle; ">
                                        <button type="button" class="btn btn-danger btn-gradient btn-alt pt5 pb5 mn" onclick="javascript:RemoveData(<?= $i; ?>)" title="Print Record"><i class="fa fa-cross"></i>X Delete</button>
                                    </td>
                                <?php 
                            } ?>
                                    <input type="hidden" name="orderid_<?= $i; ?>" id="orderid_<?= $i; ?>" value="<?= $post->orderid; ?>">
                                    <input type="hidden" name="weight_<?= $i; ?>" id="weight_<?= $i; ?>" value="<?= $post->weight_piece; ?>">
                                    <input type="hidden" name="total_<?= $i; ?>" id="total_<?= $i; ?>" value="<?= $post->total_weight; ?>">
                                    </tr>
                                <?php
                                endforeach;
                                endif;
                                ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>
                                <?php if ($val_status == 0) { ?>
                                <button type="button" class="addpro btn btn-success btn-gradient btn-alt">Add Material</button>
                                <?php 
                            } ?>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="text" class="form-control" disabled id="tot_weight2" name="tot_weight2" value="<?= $val_total_weight; ?>" required>
                            </td>
                        </tr>

                        </tfoot>
                    </table>

                    <input type="hidden" name="cloop" id="cloop" value="<?= $i; ?>">
                    <input type="hidden" name="tot_weight" id="tot_weight" value="<?= $val_total_weight; ?>">
                    <input type="hidden" name="platform_capacity" id="platform_capacity" value="<?= $val_platform_capacity ?>">
                    <input type="hidden" name="remaining_capacity" id="remaining_capacity" value="<?= $val_remaining_capacity ?>">

                    <?php
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
	function getDate(paneltime){
		var minutesToAdjust = 1200;
		var millisecondsPerMinute = 60000;
        var date = paneltime;
        var datearray = date.split("/");
        var newdate = datearray[1] + '/' + datearray[0] + '/' + datearray[2];

		var originalDate = new Date(newdate);
        var modifiedDate2 = new Date(originalDate.valueOf() + (minutesToAdjust * millisecondsPerMinute));
		modifiedDate2 = moment(modifiedDate2).format('DD/MM/YYYY h:mm A'); // 08/20/2014 3:30 pm
		$('#dettach_panel').val(modifiedDate2);		
	}
    $(document).ready(function(){
        $('.datetimepicker').datetimepicker({format:'DD/MM/YYYY hh:mm A'});
    });

    function getPlatformCapacity(id){
        $.get('<?php echo base_url(); ?>Process/getpcap/'+id,null,function(data) {
            $('#platform_capacity').val(data.capacity); //Set output element html
            $('#platform_capacity2').val(data.capacity); //Set output element html
            $('#remaining_capacity').val(data.capacity); //Set output element html
            $('#remaining_capacity2').val(data.capacity); //Set output element html
        },'json');

    }

    function getOrderDetail(id,colname) {
        $.get('<?php echo base_url(); ?>Process/getOrderDetail/'+id,null,function(data) {
            $('#qty_'+colname).val(data.qty); //Set output element html
            $('#qty2_'+colname).val(data.qty); //Set output element html
            $('#remqty_'+colname).val(data.qty); //Set output element html
            $('#weight2_'+colname).val(data.weight); //Set output element html
            $('#weight_'+colname).val(data.weight); //Set output element html
            getAmount(colname);
        },'json');

    }

    function getAmount(id){

        var qty = parseFloat($("#qty_"+id).val());
        var remqty = parseFloat($("#remqty_"+id).val());
        var weight = parseFloat($("#weight_"+id).val());
        var total = parseFloat(qty * weight);
        $('#total_'+id).val(total.toFixed(3));
        $('#total2_'+id).val(total.toFixed(3));

        if(qty > remqty){
            title = "Order Qty";
            ttext = "The Order Qty is bigger than remaining Qty. Remaining Qty is "+remqty;
            $('#qty_'+id).val(remqty);
            alertbox(title,ttext);
        }
        getTotalOff();
    }


    function getTotalOff() {
        var title="";
        var ttext="";

        var count = $('#cloop').val();
        var sumtotal= 0;
        var capacity = parseFloat($('#platform_capacity').val());

        i=1;
        while(i <= count){
            product = "";
            tid = $('#orderid_'+i).val();

            if(tid != "") {
                total = parseFloat($('#total_' + i).val());
                if (!isNaN(total)) {
                    sumtotal = parseFloat(total + sumtotal);
                } else {
                    sumtotal = parseFloat(0 + sumtotal);
                }
            }
            i++;
        }

        var rem_capacity = capacity - sumtotal;
        if(rem_capacity < 0){
            title = "Platform Capacity";
            ttext = "The Platform Capacity is Overloaded";
            alertbox(title,ttext);
        }else{
            $('#remaining_capacity').val(rem_capacity.toFixed(3));
            $('#remaining_capacity2').val(rem_capacity.toFixed(3));
        }

        $('#tot_weight').val(sumtotal.toFixed(3));
        $('#tot_weight2').val(sumtotal.toFixed(3));


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
    $(".addpro").click(function(){

        var count = $('#cloop').val();
        count++;
        $('#cloop').val(count);

        $.get('<?php echo base_url(); ?>Process/additem/'+count,null,function(result) {
            $("#addtarget").append(result); // Or whatever you need to insert the result
            initSelect();
        },'html');

    });

    function RemoveData(colname){
        $("#box_"+colname).remove();
        getTotalOff();
    }

    function onSubmitBox(){

        var title="";
        var ttext="";

        var platform_capacity = parseInt($("#platform_capacity").val());
        var remaining_capacity = parseInt($("#remaining_capacity").val());
        var tot_weight = parseFloat($("#tot_weight").val());
        var status = $("#status").val();
        var count = $('#cloop').val();
        var arr=[];
        i=1;
        prod = 0;
        while(i <= count) {
            product = "";
            tid = $('#orderid_' + i).val();
            arr.push(tid);
            if (tid != "" && tid != 0) {
                prod = 1;
            }
            i++;
        }
        var artrue = 0;
        if ( arr.length != _.unique(arr).length ){
            artrue = 1
        }

       if(prod == 0){
            title = "No Material";
            ttext = "Please Enter Atleast One Order to Continue Process";
        }else if(artrue == 1){
            title = "Order Duplication";
            ttext = "There are Duplication of the Order Added in the Process";
        }else if(tot_weight > platform_capacity){
            title = "Platform Overloaded";
            ttext = "There Platform Capacity is Overloaded";
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

    function initSelect(){
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    }

</script>
</body>
</html>
