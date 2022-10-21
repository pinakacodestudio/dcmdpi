<?php
$managePage = '<span class="fa fa-user-circle mr10"></span> Customer Reports';
$addButton = "Export Customer Report";
$searchTitle = "Search Customer Report";
// $addPage = base_url() . "Reports/SmsReport/action";
$mainPage = base_url() . "Reports/CustomerReport/";
$detailPage = base_url() . "Reports/CustomerReport/details/";

$ses_mobileno = $this->session->userdata['customerreport']['mobileno'];
$ses_sdate = $this->session->userdata['customerreport']['sdate'];
$ses_edate = $this->session->userdata['customerreport']['edate'];
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

               <?php if (count($customerreport)) : ?>
               <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                    
                                    <thead>
                                    <tr class="bg-light">
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
                                        <th>Customer Name</th> 
                                        <th>Company Name</th>
                                        <th>Mobile No. </th>
                                        <th>Address </th>
                                        <th>Total Order </th>
                                        <th>Last Year </th>
                                        <th>Current Year </th>
                                        <th>Chart Report</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $i = 0;
                                    $i = $page;
                                    foreach ($customerreport as $post) :
                                        $i++;

                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                         <td ><?= $post->customer_name; ?></td>
                                        <td><?= $post->company_name; ?></td>
                                        <td><?= $post->customer_mobile; ?></td>
                                        <td><?= $post->customer_address; ?></td>
                                        <td><?= sprintf("%0.2f",$post->totqty); ?></td>
                                        <td><?= sprintf("%0.2f",$post->lastqty); ?></td>
                                        <td><?= sprintf("%0.2f",$post->cqty); ?></td>
                                        <td><?php echo '<a href="' . $detailPage . $post->id . '" target="_blank" class="btn btn-primary btn-gradient btn-alt anchorDetail"><span class="fa fa-search pr5"></span></a>'; ?></td>
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
<!-- End: Content -->
<div id='myModal' class='modal'>
    <div class="modal-dialog panel  panel-default panel-border top" style="width:768px;">
        <div class="modal-content">
            <div id='myModalContent'></div>
        </div>
    </div>

</div>
<!-- End: Main -->
<?php $this->load->view('Includes/footerscript'); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
		$('.datetimepicker').datepicker({ dateFormat: 'dd-mm-yy' });
	});
</script>


<script type="text/javascript">

var TeamDetailPostBackURL = '<?= $detailPage; ?>';
$(function () {
    $(".anchorDetail").click(function () {
        debugger;
        var $buttonClicked = $(this);
        var id = $buttonClicked.attr('data-id');
        var options = { "backdrop": "static", keyboard: true };
        $.ajax({
            type: "GET",
            url: TeamDetailPostBackURL+'/'+id,
            contentType: "application/json; charset=utf-8",
            datatype: "json",
            success: function (data) {
                $('#myModalContent').html(data);
                $('#myModal').modal(options);
                $('#myModal').modal('show');
            },
            error: function () {
                alert("Dynamic content load failed.");
            }
        });
    });

    $("#closbtn").click(function () {
        $('#myModal').modal('hide');
    });
});

</script>
</body>
</html>
