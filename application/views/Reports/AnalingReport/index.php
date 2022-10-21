<?php
$managePage = '<span class="fa fa-product-hunt mr10"></span> Analing Reports';
$addButton = "Export Analing Report";
$searchTitle = "Search Report";
$addPage = base_url() . "Reports/AnalingReport/action";
$mainPage = base_url() . "Reports/AnalingReport/";
$ses_customerid = $this->session->userdata['analingreport']['customerid'];
$ses_itemno = $this->session->userdata['analingreport']['itemno'];
$ses_parttype = $this->session->userdata['analingreport']['parttype'];
$ses_sdate = $this->session->userdata['analingreport']['sdate'];
$ses_edate = $this->session->userdata['analingreport']['edate'];
$ses_sortbycol = $this->session->userdata['analingreport']['sortbycol'];
$ses_sortby = $this->session->userdata['analingreport']['sortby'];
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

               <?php if (count($analingreport)) : ?>
               <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                    
                                    <thead>
                                    <tr class="bg-light">
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
                                        <th>Platform No.</th>
                                        <th>Furnace No.</th>
                                        <th>Panel No.</th>
                                        <th>Program Start Date Time</th>
                                        <th>Program End Date Time</th>
                                        <th>Furnace Open Date Time</th>
                                        <th>Forging Party</th>
                                        <th>Customer Name</th>
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
                                    foreach ($analingreport as $post) :
                                        $i++;
                                    $sdate = $post->start_preparing;
                                    $edate = $post->end_removing;
                                    $fdate = $post->attach_furnace;
                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                        <td ><?= $post->platformid; ?></td>
                                        <td ><?= $post->bellid; ?></td>
                                        <td ><?= $post->panelid; ?></td>
                                        <td ><?= $sdate; ?></td>
                                        <td ><?= $edate; ?></td>
                                        <td ><?= $fdate; ?></td>
                                        <td><?= $post->forging_name; ?></td>
                                        <td><?= $post->main_party; ?></td>
                                        <td><?= $post->item_no; ?></td>
                                        <td><?= $post->part_type; ?></td>
                                        <td><?= $post->qty; ?></td>
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
