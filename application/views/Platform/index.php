<?php
$managePage = '<span class="fa fa-product-hunt mr10"></span> Platform';
$addButton = "Add Platform";
$addPage = base_url() . "Platform/add/";
$deletePage = base_url() . "Platform/delete/";
$mainPage = base_url() . "Platform/";
$detailPage = base_url() . 'Platform/details';
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

           
                    <?php if (count($platform)) : ?>
                    <div class="panel panel-visible" id="spy2">
				         <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                    
                                    <thead>
                                    <tr class="bg-light">
                                        <th style="text-align: center; vertical-align: middle">Sr.</th>
                                        <th>Platform ID</th>
                                        <th>Capacity</th>
                                        <th>Description</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $i = 0;
                                    $i = $page;
                                    foreach ($platform as $post) :
                                        $i++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle"><?= $i; ?></td>
                                        <td><?= $post->platformid; ?></td>
                                        <td><?= $post->platform_capacity; ?></td>
                                        <td><?= $post->platform_description; ?></td>
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