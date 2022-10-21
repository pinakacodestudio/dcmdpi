<?php
$managePage = '<span class="fa fa-product-hunt mr10"></span> Outward Reports';
$addButton = "Export Outward Report";
$searchTitle = "Search Report";
$addPage = base_url() . "Reports/OutwardReport/action";
$mainPage = base_url() . "Reports/OutwardReport/";
$ses_dispatch_party = $this->session->userdata['outwardreport']['dispatch_party'];
$ses_main_party = $this->session->userdata['outwardreport']['main_party'];
$ses_sdate = $this->session->userdata['outwardreport']['sdate'];
$ses_edate = $this->session->userdata['outwardreport']['edate'];
$ses_sortbycol = $this->session->userdata['outwardreport']['sortbycol'];
$ses_sortby = $this->session->userdata['outwardreport']['sortby'];
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
                        dropdownbox('3', 'Dispatch Party', 'dispatch_party', $customerlist, $ses_dispatch_party);
                        dropdownbox('3', 'Main Party', 'main_party', $customerlist, $ses_main_party);
                        ?>
						<div class="clearfix"></div>
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

                <?php if (count($outwardreport)) : ?>
                <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                                    <thead>
                                    <tr class="bg-light">
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
                                        <th>Dispatch Date</th>
                                        <th>Challan No.</th>
                                        <th>Po No.</th>
                                        <th>Item No.</th>
                                        <th>Part Type</th>
                                        <th>Batch Qty</th>
                                        <th>Weight / PCS</th>
                                        <th>Total Weight</th>
                                        <th>Dispatch Party</th>
                                        <th>Main Party</th>
                                        <th>Rate / KGS</th>
                                        <th>Total Amt.</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $i = 0;
                                    $i = $page;
                                    $total = 0;
									$totalweight = 0;
                                    foreach ($outwardreport as $post) :
                                        $i++;
                                    $date = new DateTime($post->dispatch_date);
                                    $disdate = $date->format('d-m-Y');
                                    $total += $post->total_amount;
									$totalweight += $post->total_weight;
                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                        <td ><?= $disdate; ?></td>
                                        <td ><?= $post->chalan_no; ?></td>
                                        <td ><?= $post->po_no; ?></td>
                                        <td ><?= $post->item_no; ?></td>
                                        <td ><?= $post->part_type; ?></td>
                                        <td ><?= $post->batch_qty; ?></td>
                                        <td><?= $post->weight_piece; ?></td>
                                        <td><?= $post->total_weight; ?></td>
                                        <td><?= $post->dispatch_party; ?></td>
                                        <td><?= $post->main_party; ?></td>
                                        <td><?= $post->rate_qty; ?></td>
                                        <td><?= $post->total_amount; ?></td>
                                    </tr>
                                    <?php
                                    endforeach; ?>
                                    </tbody>
									<tfoot>
										<tr>
											<td colspan="8" style="text-align: right; font-weight: bold; padding-right: 5px;">Total Weights</td>
											<td style="font-weight: bold;"><?= $totalweight; ?></td>
											<td colspan="3" style="text-align: right; font-weight: bold; padding-right: 5px;">Total</td>
											<td style="font-weight: bold;"><?= $total; ?></td>
										</tr>
									</tfoot>
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
