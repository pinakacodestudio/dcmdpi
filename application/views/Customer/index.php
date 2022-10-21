<?php
$managePage = '<span class="fa fa-address-book-o mr10"></span> Customer';
$addButton = "Add Customer";
$addPage = base_url() . "Customer/add/";
$deletePage = base_url() . "Customer/delete/";
$mainPage = base_url() . "Customer/";
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

         
                    <?php if (count($customer)) : ?>
                    <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
                                        <th>Company Name</th>
                                        <th>Contact Person</th>
                                        <th>Mobile No.</th>
                                        <th>Email Id</th>
                                        <th>Company Address</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $i = 0;
                                    $i = $page;
                                    foreach ($customer as $post) :
                                        $i++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                        <td><?= $post->company_name; ?></td>
                                        <td><?= $post->customer_name; ?></td>
                                        <td><?= $post->customer_mobile; ?></td>
                                        <td><?= $post->customer_email; ?></td>
                                        <td><?= $post->customer_address; ?></td>
                                        <td><?php echo anchor($addPage . $post->id, '<span class="fa fa-pencil pr5"></span></a>', ['class' => 'btn btn-success btn-gradient btn-alt']); ?></td>
                                        <td><?php
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
                       
                    <?php else :
                        noRecord($addPage);
                    endif; ?>
        </section>
        <!-- End: Content -->

        <?php $this->load->view('Includes/footer'); ?>
    </section>
    <!-- End: Content-Wrapper -->
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


</script>
</body>
</html>