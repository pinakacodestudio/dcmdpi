<?php
$managePage = '<span class="fa fa-cogs mr10"></span> Process';
$addButton = "Add Process";
$addPage = base_url() . "Process/add/";
$deletePage = base_url() . "Process/delete/";
$detailPage = base_url() . "Process/details/";
$mainPage = base_url() . "Process/";
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

                    <?php if (count($processlist)) : ?>
                    <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                    
                                    <thead>
                                    <tr class="bg-light">
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
                                        <th>Platform ID</th>
                                        <th>Furnace ID</th>
                                        <th>Panel ID</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Capacity</th>
                                        <th>Status</th>
                                        <th>View</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $i = 0;
                                    $i = $page;
                                    foreach ($processlist as $post) :
                                        $i++;
                                    $seldata = array('1' => 'Waiting For Furnace', '2' => 'Waiting For PowerPanel', '3' => 'Processing', '4' => 'Cooling', '5' => 'Closed');
                                    $status = customData($seldata, $post->status);
                                    $used = $post->platform_capacity - $post->remaining_capacity;
									if($post->start_preparing != ""){
										$date = DateTime::createFromFormat("d/m/Y h:i A", $post->start_preparing);
										$sdate = $date->format('d-m-Y');
									}
                                    if ($post->end_removing != "") {
                                        $date = DateTime::createFromFormat("d/m/Y h:i A", $post->end_removing);
                                        $edate = $date->format('d-m-Y');
                                    }
                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                        <td><?= $post->platformid; ?></td>
                                        <td><?= $post->bellid; ?></td>
                                        <td><?= $post->panelid; ?></td>
                                        <td><?= $sdate; ?></td>
                                        <td><?= $edate; ?></td>
                                        <td><?= $used . " Kg / " . $post->platform_capacity . " Kg"; ?></td>
                                        <td><?= $status; ?></td>
                                        <td><?php echo '<a href="javascript:void(0);" data-id="' . $post->id . '" class="btn btn-primary btn-gradient btn-alt anchorDetail"><span class="fa fa-search pr5"></span></a>'; ?></td>
                                        <td><?php echo anchor($addPage . $post->id, '<span class="fa fa-pencil pr5"></span></a>', ['class' => 'btn btn-success btn-gradient btn-alt']); ?></td>
                                        <td><?php
                                            if ($post->status != 5) {
                                                echo form_open($deletePage . $post->id, ['id' => 'fd' . $post->id]);
                                                echo '<a href="#" onclick="javascript:deleteBox(' . $post->id . ')" class="btn btn-danger btn-gradient btn-alt swal-btn-cancel"><span class="fa fa-close pr5"></span></a>';
                                                echo form_close();
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
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