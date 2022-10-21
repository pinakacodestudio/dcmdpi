<?php
$managePage = '<span class="fa fa-send mr10"></span> Sms Reports';
$addButton = "Export Sms Report";
$searchTitle = "Search Sms Report";
// $addPage = base_url() . "Reports/SmsReport/action";
$mainPage = base_url() . "Reports/SmsReport/";
$ses_mobileno = $this->session->userdata['smsreport']['mobileno'];
$ses_sdate = $this->session->userdata['smsreport']['sdate'];
$ses_edate = $this->session->userdata['smsreport']['edate'];
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
                        datepicker('3', 'Start Date', 'sdate', 'Enter Start Date', $ses_sdate);
                        datepicker('3', 'End Date', 'edate', 'Enter End Date', $ses_edate);
                        editbox('3', 'Mobile No.', 'mobileno', 'Enter Mobile No.', $ses_mobileno);
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

                <?php if (count($smsreport)) : ?>
                <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                    
                                    <thead>
                                    <tr class="bg-light">
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
                                        <th>Send Date</th> 
                                      <th>Mobile No.</th>
                                        <th>Message</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $i = 0;
                                    $i = $page;
                                    foreach ($smsreport as $post) :
                                        $i++;
                                    $date = new DateTime($post->created_on);
                                    $sdate = $date->format('d-m-Y H:m A');
                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                        <td><?= $sdate; ?></td>
                                         <td ><?= $post->mobileno; ?></td>
                                        <td><?= $post->message; ?></td>
                                        
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
