<?php
$managePage = '<span class="fa fa-product-hunt mr10"></span> Material Reports';
$addButton = "Export Material Report";
$searchTitle = "Search Report";
$addPage = ""; //base_url() . "Reports/MaterialReport/action";
$mainPage = base_url() . "Reports/MaterialReport/";
$ses_customerid = $this->session->userdata['materialreport']['customerid'];
$ses_itemno = $this->session->userdata['materialreport']['itemno'];
$ses_sdate = $this->session->userdata['materialreport']['sdate'];
$ses_edate = $this->session->userdata['materialreport']['edate'];
$ses_sortbycol = $this->session->userdata['materialreport']['sortbycol'];
$ses_sortby = $this->session->userdata['materialreport']['sortby'];
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
                        dropdownbox('3', 'Select Customer', 'customerid', $customerlist, $ses_customerid);
                        dropdownbox('3', 'Select Item No', 'itemno', $itemlist, $ses_itemno);
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

            
                <?php if (count($materialreport)) : ?>
                <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                    
                                    <thead>
                                    <tr class="bg-light">
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
                                        <th>Order No.</th>
                                        <th>Forging Party</th>
                                        <th>Customer Name</th>
                                        <th>Item No.</th>
                                        <th>Part Type</th>
                                        <th>Total Qty</th>
                                        <th>Pending</th>
                                        <th>In Process</th>    
                                        <th>Ready To Dispatch</th>
                                        <th>Dispatched</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $i = 0;
                                    $i = $page;
                                    foreach ($materialreport as $post) :
                                        $i++;


                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                        <td ><?= $post->orderno; ?></td>
                                        <td><?= $post->forging_name; ?></td>
                                        <td><?= $post->main_party; ?></td>
                                        <td><?= $post->item_no; ?></td>
                                        <td><?= $post->part_type; ?></td>
                                        <td><?= $post->batch_qty; ?></td>
                                        <td><?= $post->batch_qty - $post->qty_used; ?></td>
                                        <td><?= $post->qty_used - $post->qty_ready; ?></td>
                                        <td><?= $post->qty_ready - $post->qty_dispatch; ?></td>
                                        <td><?= $post->qty_dispatch; ?></td>
                                        
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
