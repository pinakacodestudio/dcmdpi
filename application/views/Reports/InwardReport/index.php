<?php
$managePage = '<span class="fa fa-product-hunt mr10"></span> Inward Reports';
$addButton = "Export Inward Report";
$searchTitle = "Search Report";
$addPage = base_url() . "Reports/InwardReport/action";
$mainPage = base_url() . "Reports/InwardReport/";
$ses_customerid = $this->session->userdata['inwardreport']['customerid'];
$ses_parttype = $this->session->userdata['inwardreport']['parttype'];
$ses_itemno = $this->session->userdata['inwardreport']['itemno'];
$ses_sdate = $this->session->userdata['inwardreport']['sdate'];
$ses_edate = $this->session->userdata['inwardreport']['edate'];
$ses_sortbycol = $this->session->userdata['inwardreport']['sortbycol'];
$ses_sortby = $this->session->userdata['inwardreport']['sortby'];

$csorticon = "";
$ifsorticon = "";
$gifsorticon = "";
$ipsorticon = "";
if ($ses_sortby == "asc") {
    $ses_sortby = "desc";
    if ($ses_sortbycol == "category_name") {
        $csorticon = "-down";
    }
    if ($ses_sortbycol == "item_fullname") {
        $ifsorticon = "-down";
    }
    if ($ses_sortbycol == "guj_item_fullname") {
        $gifsorticon = "-down";
    }
    if ($ses_sortbycol == "item_price") {
        $ipsorticon = "-down";
    }
} else if ($ses_sortby == "desc") {
    $ses_sortby = "asc";
    if ($ses_sortbycol == "caterory_name") {
        $csorticon = "-up";
    }
    if ($ses_sortbycol == "item_fullname") {
        $ifsorticon = "-up";
    }
    if ($ses_sortbycol == "guj_item_fullname") {
        $gifsorticon = "-up";
    }
    if ($ses_sortbycol == "item_price") {
        $ipsorticon = "-up";
    }
} else {
    $ses_sortby = "asc";
}
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
        <?php manageheader($managePage, $addPage, $addButton); ?>
        <section id="content" class="animated fadeIn">
            <?php alertbox(); ?>
            <div class="panel panel-default panel-border top">
                <?php echo form_open($mainPage, ['name' => 'frm1', 'id' => 'frm1', 'class' => 'stdform']); ?>
                <div class="panel-heading">
                    <span class="panel-title"> <?= $searchTitle; ?></span>
                    </div>
                    <div class="panel-body">
                        <?php
                        datepicker('3', 'Select Start Date', 'sdate', 'Select Start date', $ses_sdate);
                        datepicker('3', 'Select End Date', 'edate', 'Select End date', $ses_edate);
                        dropdownbox('3', 'Select Customer', 'customerid', $customerlist, $ses_customerid);
                        dropdownbox('3', 'Select Item No', 'itemno', $itemlist, $ses_itemno);
                        echo '<div class="clearfix"></div>';
                        dropdownbox('3', 'Select Part Type', 'parttype', $parttypelist, $ses_parttype);
                        ?>
                        <div class="col-md-1">
                            <div class="form-group" style="float:left; margin-top: 20px;" >
                                <button type="submit" name="submit" class="btn btn-primary btn-gradient btn-alt">Submit</button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" style="float:left; margin-top: 20px;" >
                                <button type="submit" name="clearall" class="btn btn-primary btn-gradient btn-alt">Clear All</button>
                            </div>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>

           	<?php if (count($inwardreport)) : ?>
               <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                    
                                    <thead>
                                    <tr class="bg-light">
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
										<th>Received Date</th>
                                        <th>Challan No.</th>
                                        <th>Main Challan No.</th>
                                        <th>Main Challan Date</th>
                                        <th>Received From</th>
                                        <th>Main Party</th>
                                        <th>Item No.</th>
                                        <th>Part Type</th>
                                        <th>Qty</th>
                                        <th>Weight / PCS</th>
                                        <th>Total Weight</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $i = 0;
                                    $i = $page;
                                    foreach ($inwardreport as $post) :
                                        $i++;
                                    $date = new DateTime($post->received_date);
                                    $rdate = $date->format('d-m-Y');
                                    $date = new DateTime($post->chalan_date);
                                    $cdate = $date->format('d-m-Y');
                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                        <td ><?= $rdate; ?></td>
                                        <td ><?= $post->chalan_no; ?></td>
                                        <td ><?= $post->main_chalan_no; ?></td>
                                        <td ><?= $cdate; ?></td>
                                        <td><?= $post->forging_name; ?></td>
                                        <td><?= $post->main_party; ?></td>
                                        <td><?= $post->item_no; ?></td>
                                        <td><?= $post->part_type; ?></td>
                                        <td><?= $post->batch_qty; ?></td>
                                        <td><?= $post->weight_piece; ?></td>
                                        <td><?= $post->total_weight; ?></td>
                                    </tr>
                                    <?php
                                    endforeach; ?>
                                    </tbody>    
                                </table>
                        </div>
                        <input type="hidden" name="delid" id="delid" value="0">
                        
                <?php else :
                    noRecord("");
                endif; ?>
           
        </section>
        <?php $this->load->view('Includes/footer'); ?>
    </section>
    <!-- End: Content-Wrapper -->
</div>
<!-- End: Main -->
<?php $this->load->view('Includes/footerscript'); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
		$('.datetimepicker').datepicker({ dateFormat: 'dd-mm-yy' });
	});
</script>
</body>
</html>
