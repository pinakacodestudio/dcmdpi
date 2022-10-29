<?php
$managePage = '<span class="fa fa-circle-o mr10"></span> Dispatch';
$addButton  = "Add Dispatch";
$addPage    = base_url() . "Dispatch/add/";
$deletePage = base_url() . "Dispatch/delete/";
$printPage  = base_url() . "Dispatch/invoice/";
$mainPage   = base_url() . "Dispatch/";
$detailPage = base_url() . "Dispatch/sendmsg/";
?>
<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('Includes/head'); ?>
    <style>
    table .btn.btn-alt{
        padding:5px;
        margin:5px 2px;
        font-size:9px;
    }
    </style>
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
            <?php if (count($dispatchlist)): ?>
                <div class="panel panel-visible" id="spy2">
                    <table class="table table-bordered mbn" id="datatable2">
                        <thead>
                            <tr class="bg-light">
                                <th style="text-align: center; vertical-align: middle">Sr.</th>
                                <th>Order No.</th>
                                <th>Dispatch<br>Date</th>
                                <th>Dispatch<br>Chalan No.</th>
                                <th>Dispatch Party</th>
                                <th>Main Party</th>
                                <th>Part Type</th>
                                <th>Quantity</th>
                                <th>Total Weight</th>
                                <th class="no-sort">Send</th>
                                <th>Print</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $i = $page;
                            foreach ($dispatchlist as $post):
                                $i++;
                                $date          = new DateTime($post->dispatch_date);
                                $dispatch_date = $date->format('d-m-Y');
                                ?>
                                <tr>
                                    <td style="text-align: center; vertical-align: middle"><?=$i; ?></td>
                                    <td><a href="<?=base_url() . "Order/add/" . $post->orderid; ?>" target="_blank"><?=$post->orderno; ?></a></td>
                                    <td><?=$dispatch_date; ?></td>
                                    <td><?=$post->chalan_no; ?></td>
                                    <td><?=$post->dispatch_party; ?></td>
                                    <td><?=$post->main_party; ?></td>
                                    <td><?=$post->item_no . " - " . $post->part_type; ?></td>
                                    <td><?=$post->batch_qty; ?></td>
                                    <td><?=sprintf("%0.3f", $post->total_weight); ?></td>
                                    <td><?php echo '<a href="javascript:void(0);" data-id="' . $post->id . '" class="btn btn-primary btn-gradient btn-alt anchorDetail"><span class="fa fa-send pr5"></span></a>'; ?></td>
                                    <td><?php echo anchor($printPage . $post->id, '<span class="fa fa-print pr5"></span></a>', ['class' => 'btn btn-default btn-gradient btn-alt', 'target' => '_blank']); ?></td>
                                    <td><?php echo anchor($addPage . $post->id, '<span class="fa fa-pencil pr5"></span></a>', ['class' => 'btn btn-success btn-gradient btn-alt']); ?></td>
                                    <td>
                                    <?php
                                        echo form_open($deletePage . $post->id, ['id' => 'fd' . $post->id]);
                                        echo '<a href="#" onclick="javascript:deleteBox(' . $post->id . ')" class="btn btn-danger btn-gradient btn-alt swal-btn-cancel"><span class="fa fa-close pr5"></span></a>';
                                        echo form_close();
                                    ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="delid" id="delid" value="0">
            <?php else:
                noRecord($addPage);
            endif; ?>   
        </section>
        <?php $this->load->view('Includes/footer'); ?>
    </section>
</div>
<div id='myModal' class='modal'>
	<div class="modal-dialog panel  panel-default panel-border top">
		<div class="modal-content">
			<div id='myModalContent'></div>
		</div>
	</div>
</div>
<!-- End: Main -->
<!-- End: Main -->
<?php $this->load->view('Includes/footerscript'); ?>
<script type="text/javascript">
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

	var TeamDetailPostBackURL = '<?=$detailPage; ?>';
	$(function () {
		$(document).on('click','.anchorDetail',function () {
			// debugger;
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
