<?php
$managePage = '<span class="fa fa-circle-o mr10"></span> Jobwork';
$addButton = "Add Order";
$addPage = base_url() . "Jobwork/add/";
$deletePage = base_url() . "Jobwork/delete/";
$mainPage = base_url() . "Jobwork/";

$searchTitle = "Search Jobwork";
$ses_customerid = $this->session->userdata['orders']['customerid'];
$ses_itemno = $this->session->userdata['orders']['itemno'];
$ses_parttype = $this->session->userdata['orders']['parttype'];
$ses_challanno = $this->session->userdata['orders']['challanno'];
$ses_sdate = $this->session->userdata['orders']['sdate'];
$ses_edate = $this->session->userdata['orders']['edate'];
$ses_sortbycol = $this->session->userdata['orders']['sortbycol'];
$ses_sortby = $this->session->userdata['orders']['sortby'];

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
        <?php manageheader($managePage, '', ''); ?>
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
                        editbox('3', 'Challan No.', 'challanno', 'Enter Challan No.', $ses_challanno);
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

                    <?php if (count($orderlist)) : ?>
                    <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                    
                                    <thead>
                                    <tr class="bg-light">
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
                                        <th>Order No.</th>
                                        <th>Received Date</th>
                                        <th>Challan No.</th>
                                        <th>From Forging Party</th>
                                        <th>Main Party</th>
                                        <th>Item No.</th>
                                        <th>Quantity</th>
                                        <th>Total Weight</th>
                                        <th>Create / Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php
        $i = 0;
        $i = $page;
        foreach ($orderlist as $post) :
            $date = new DateTime($post->received_date);
        $received_date = $date->format('d-m-Y');
        if ($post->qty_dispatch > 0) {
            $i++;
            $total_weight = $post->qty_dispatch * $post->weight_piece;
            ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                        <td><?= $post->orderno; ?></td>
                                        <td><?= $received_date; ?></td>
                                        <td><?= $post->chalan_no; ?></td>
                                        <td><?= $post->from_forgine_party; ?></td>
                                        <td><?= $post->main_party; ?></td>
                                        <td><?= $post->item_no . " - " . $post->part_type; ?></td>
                                        <td><?= $post->qty_dispatch; ?></td>
                                        <td><?= $total_weight; ?> Kg</td>
                                        <td><?php
                                            if ($post->status == 0) {
                                                $mod = "Create";
                                            } else {
                                                $mod = "Edit";
                                            }
                                            echo anchor($addPage . $post->id, '<span class="fa fa-briefcase pr5"></span> ' . $mod . ' </a>', ['class' => 'btn btn-info btn-gradient btn-alt']);

                                            ?></td>
                                    </tr>
                                    <?php

                                }
                                endforeach; ?>
                                    </tbody>
                                </table>
                        </div>
                        <input type="hidden" name="delid" id="delid" value="0">
                        
                    <?php else :
                        noRecord($addPage);
                    endif; ?>
        
        </section>
        <!-- End: Content -->

        <?php $this->load->view('Includes/footer'); ?>
    </section>
    <!-- End: Content-Wrapper -->
</div>
<!-- End: Content -->
<div id='myModal' class='modal'>
	<div class="modal-dialog panel  panel-default panel-border top">
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
    
    function deleteBox(frmname) {
        $("#delid").val(frmname);
    }

    $('.swal-btn-cancel').click(function (e) {
        e.preventDefault();

        var delid = $("#delid").val();
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this Records!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {

                    $("#fd" + delid).submit();

                } else {
                    swal({
                        title: "Cancelled",
                        text: "Your Records are safe :)",
                        type: "error",
                        confirmButtonClass: "btn-danger"
                    });
                }
            });

    });


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