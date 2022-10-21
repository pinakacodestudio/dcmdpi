<?php
$pageSave = "Order/savejob";
$pageBack = "Order";
$operation = "Add";
$val_jobwork_date = "";
$val_jobwork_chalan = "";
$val_chalan_date = "";
$val_chalan_no = "";
$val_from_forgine_party = "";
$val_main_party = "";
$val_item_no = "";
$val_part_type = "";
$val_batch_qty = 0;
$val_weight_piece = 0;
$val_total_weight = 0;
if ($id != "" and is_numeric($id)) {
    $operation = "Edit";
    $val_jobwork_date = StringRepair3($order->jobwork_date);
    $date = new DateTime($val_jobwork_date);
    $val_jobwork_date = $date->format('d-m-Y');
    $val_jobwork_chalan = StringRepair3($order->jobwork_chalan);
    $val_jobwork_qty = StringRepair3($order->jobwork_qty);
    $val_jobwork_amount = StringRepair3($order->jobwork_amount);
    $val_weight_piece = StringRepair3($order->weight_piece);
}

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
                    datepicker('4', 'Jobwork Date', 'jobwork_date', 'Enter Jobwork Date', $val_jobwork_date);
                    editbox('4', 'Jobwork Challan No.', 'jobwork_chalan', 'Enter Jobwork Challan No.', $val_jobwork_chalan);
                    echo '<div class="clearfix"></div>';

                    if (count($dispatchlist)) :
                    ?>


                    <table id="table" class="table table-bordered tabform panel  panel-default panel-border top">
                        <thead>
                        <tr>
                            <th style="text-align: center; "><div class="th-inner">Dispatch Challan No.</div></th>
                            <th style="text-align: center; "><div class="th-inner">Dispatch Date</div></th>
                            <th style="text-align: center; "><div class="th-inner">Dispatch Party</div></th>
                            <th style="text-align: center; " ><div class="th-inner">Quantity</div></th>
                            <th style="text-align: center; "><div class="th-inner">Weight / Pic</div></th>
                            <th style="text-align: center; "><div class="th-inner ">Total Weight</div></th>
                            <th style="text-align: center; "><div class="th-inner">Rate</div></th>
                            <th style="text-align: center; "><div class="th-inner">Amount</div></th>
                            </tr>
                        </thead>
                        <tbody id="addtarget">
                        <?php
                        $i = 0;

                        $totalqty = 0;
                        $totalweight = 0;
                        $totalamount = 0;
                        foreach ($dispatchlist as $post) :
                            $i++;
                        $val_total_weight = $val_total_weight + $post->total_weight;
                        $date = new DateTime($post->dispatch_date);
                        $dispatch_date = $date->format('d-m-Y');

                        $totalqty = $totalqty + $post->batch_qty;
                        $totalweight = $totalweight + $post->total_weight;
                        $totalamount = $totalamount + $post->total_amount;

                        ?>
                        <tr>
                            <td style="text-align: center; "><?= $post->chalan_no; ?></td>
                            <td style="text-align: center; "><?= $dispatch_date; ?></td>
                            <td style="text-align: center; "><?= $post->chalan_no; ?></td>
                            <td style="text-align: right; "><?= $post->batch_qty; ?></td>
                            <td style="text-align: right; "><?= $post->weight_piece; ?></td>
                            <td style="text-align: right; "><?= $post->total_weight; ?> Kg</td>
                            <td style="text-align: center; ">Rs. <?= $post->rate_qty; ?></td>
                            <td style="text-align: right; ">Rs. <?= $post->total_amount; ?></td>
                        </tr>
                               
                                <?php
                                endforeach;
                                ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td  style="text-align: right; " colspan="3">Total</td>
                            <td style="text-align: right; "><?= $totalqty; ?></td>
                            <td>&nbsp;</td>
                            <td style="text-align: right; "><?= $totalweight; ?> Kg</td>
                            <td></td>
                            <td style="text-align: right; ">Rs. <?= sprintf("%.2f", $totalamount); ?></td>
                        </tr>

                        </tfoot>
                    </table>

                   <input type="hidden" name="jobwork_qty" id="jobwork_qty" value="<?= $totalqty; ?>">
                   <input type="hidden" name="jobwork_amount" id="jobwork_amount" value="<?= $totalamount; ?>">

                    <?php
                    endif;

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
        /*Disable textarea using id */
        $('#total_weight2').prop("disabled", true);
    });

  
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
