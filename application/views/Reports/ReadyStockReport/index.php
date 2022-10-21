<?php
$managePage = '<span class="fa fa-product-hunt mr10"></span> Ready Stock Reports';
$addButton = "Export Ready Material Report";
$searchTitle = "Search Report";
$addPage = base_url() . "Reports/ReadyStockReport/action";
$mainPage = base_url() . "Reports/ReadyStockReport/";
$ses_customerid = $this->session->userdata['readystockreport']['customerid'];
$ses_itemno = $this->session->userdata['readystockreport']['itemno'];
$ses_sdate = $this->session->userdata['readystockreport']['sdate'];
$ses_edate = $this->session->userdata['readystockreport']['edate'];
$ses_sortbycol = $this->session->userdata['readystockreport']['sortbycol'];
$ses_sortby = $this->session->userdata['readystockreport']['sortby'];
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

                <?php if (count($readystockreport)) : ?>
                <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                    
                                    <thead>
                                    <tr class="bg-light">
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
                                        <th>Order No.</th>
                                        <th>Po No.</th>
                                        <th>Forging Party</th>
                                        <th>Main Party</th>
                                        <th>Item No.</th>
                                        <th>Part Type</th>
                                        <th>Total Ready To Dispatch Qty</th>
                                        <th>Weight / Nos</th>
                                        <th>Total Weight</th>    
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $i = 0;
                                    $i = $page;
                                    foreach ($readystockreport as $post) :
                                        $i++;
                                    $qty_dispatch = $post->qty_ready - $post->qty_dispatch;
                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                        <td ><?= $post->orderno; ?></td>
                                        <td><?= $post->po_no; ?></td>
                                        <td><?= $post->forging_name; ?></td>
                                        <td><?= $post->main_party; ?></td>
                                        <td><?= $post->item_no; ?></td>
                                        <td><?= $post->part_type; ?></td>
                                        <td><?= $qty_dispatch; ?></td>
                                        <td><?= $post->weight_piece; ?></td>
                                        <td><?= $post->weight_piece * $qty_dispatch; ?></td>
                                        
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
